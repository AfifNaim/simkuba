<?php

namespace App\Http\Controllers;
use App\Models\CashBook;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use LaravelIdea\Helper\App\Models\_IH_CashBook_C;

class CashBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function index()
    {
        $this->authorize('cashbook-access');

        if (\request()->has('id')){
            return redirect()->route('cash-books.index')
                ->with('success','Berhasil menyimpan catatan');
        }

        $cashBooks = CashBook::where('company_id', Auth::user()->company_id)->get();

        $sumIncome = $cashBooks->where('type', 'K')->sum('summary');
        $sumExpanse = $cashBooks->where('type', 'D')->sum('summary');

        return view('cash-book/index', compact('cashBooks', 'sumIncome', 'sumExpanse'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $title = \request('type') === 'K' ? 'Tambah Pemasukan' : 'Tambah Pengeluaran';
        $type = \request('type');
        $qty = \request('quantity');

        $categories = self::getCategories();

        return view('cash-book.create', compact(
            'title',
            'type',
            'categories'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse|JsonResponse
     */
    public function store(Request $request)
    {
        $this->authorize('cashbook-create');

        $request->merge([
            'user_id' => Auth::user()->id,
            'company_id' => Auth::user()->company_id,
        ]);

        $validator = $this->validation($request);

        if ($validator->fails())
        {
            return $request->ajax()
                ? response()->json(['errors'  => $validator->errors()], 400)
                : back()
                    ->withInput()
                    ->withErrors($validator->errors())
                    ->with('error',"Gagal menyimpan catatan. Cek kembali data inputan Anda.");
        }

        $saveCashBook = $validator->safe()->except(['image']);

        if ($image = $request->file('image')) {
            $destinationPath = 'images/cashbook';
            $fileName = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $fileName);

            $saveCashBook['image'] = $fileName;
        }

        $saveCashBook['summary'] = $request->qty * $request->amount;

        $cashBook = CashBook::create($saveCashBook);

        return $request->ajax()
            ? $cashBook
            : redirect()->route('cash-books.index')
                ->with('success','Berhasil menyimpan catatan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function show(CashBook $cashBook)
    {
        $this->authorize('cashbook-show');

        $cashBook = CashBook::with('category')
            ->where('id', $cashBook->id)
            ->firstOrFail();

        $title = 'Detail Catatan';

        return view('cash-book.show', compact('cashBook', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CashBook $cashBook
     * @return Application|Factory|View
     */
    public function edit(CashBook $cashBook)
    {
        $title = \request('type') === 'K' ? 'Edit Pemasukan' : 'Edit Pengeluaran';
        $type = \request('type');

        $categories = self::getCategories();

        return view('cash-book.edit', compact(
            'title',
            'type',
            'categories',
            'cashBook'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param CashBook $cashBook
     * @return CashBook|CashBook[]|JsonResponse|RedirectResponse|_IH_CashBook_C
     */
    public function update(Request $request, CashBook $cashBook)
    {
        $this->authorize('cashbook-edit');

        $validator = $this->validation($request);

        if ($validator->fails())
        {
            return $request->ajax()
                ? response()->json(['errors'  => $validator->errors()], 400)
                : back()
                    ->withInput()
                    ->withErrors($validator->errors())
                    ->with('error',"Gagal menyimpan catatan. Cek kembali data inputan Anda.");
        }

        $saveCashBook = $validator->safe()->except(['image']);

        if ($image = $request->file('image')) {
            File::delete(public_path('images/cashbook/'.$cashBook->image));

            $destinationPath = 'images/cashbook';
            $fileName = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $fileName);

            $saveCashBook['image'] = $fileName;
        }

        $saveCashBook['summary'] = $request->qty * $request->amount;

        $cashBook->update($saveCashBook);

        $cashBook = CashBook::find($cashBook->id);

        return $request->ajax()
            ? $cashBook
            : redirect()->route('cash-books.index')
                ->with('success','Berhasil menyimpan catatan.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CashBook $cashBook
     * @return RedirectResponse
     */
    public function destroy(CashBook $cashBook)
    {
        $this->authorize('cashbook-delete');

        $cashBook->delete();
        File::delete(public_path('images/cashbook/'.$cashBook->image));

        return redirect()->route('cash-books.index')
            ->with('success',"Catatan berhasil dihapus.");
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function validation(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($request->except('category_name'), [
            'user_id' => 'sometimes',
            'company_id' => 'sometimes',
            'category_id' => 'required',
            'date' => 'required',
            'type' => 'required',
            'amount' => 'int|required',
            'qty' => 'int|required',
            'description' => 'required',
            'image' => 'sometimes|file|mimes:jpg,jpeg,png|max:1048'
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    private function getCategories(): \Illuminate\Support\Collection
    {
        $categories = collect(Category::query()
            ->where('company_id', auth()->user()->company_id)
            ->orWhereNull('company_id')
            ->orderBy('name')
            ->get());

        return $categories->where('type', \request('type'));
    }

    public function report()
    {
        $categories = CashBook::with('category')->groupBy('category_id')->get(['category_id']);
        $report = [];
        foreach ($categories as $key => $value) {
            $category_id = $value->category_id;
            $category = Category::find($category_id);

            $report['daily'][] = [
                'category' => $category->name,
                'summary' => CashBook::where('category_id',$category_id)
                    ->whereDate('date',date('Y-m-d'))
                    ->sum('amount')
            ];

            $report['weekly'][] = [
                'category' => $category->name,
                'summary' => CashBook::where('category_id',$category_id)
                    ->whereBetween('date', [
                        Carbon::parse('last monday')->startOfDay(),
                        Carbon::parse('next sunday')->endOfDay(),
                    ])
                    ->sum('amount')
            ];

            $report['monthly'][] = [
                'category' => $category->name,
                'summary' => CashBook::where('category_id',$category_id)
                    ->whereMonth('date',date('m'))
                    ->sum('amount')
            ];

            $report['yearly'][] = [
                'category' => $category->name,
                'summary' => CashBook::where('category_id',$category_id)
                    ->whereYear('date',date('Y'))
                    ->sum('amount')
            ];
        }

        return $report;
    }
}
