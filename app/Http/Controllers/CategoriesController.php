<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Models\CashBook;
use App\Models\Category;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|RedirectResponse|View
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('category-access');

        if (\request()->has('name')){
            return redirect()->route('categories.index')
                ->with('success','Berhasil menyimpan kategori '.\request('name'));
        }

        $incomeCategories = collect();
        $expanseCategories = collect();

        Category::with('user')
            ->whereNull('company_id')
            ->when(auth()->user()->hasAnyRole('Manager|Employe'), function ($query){
                return $query->orWhere('company_id', auth()->user()->company_id);
            })
            ->withCount('cash_book')
            ->each(function ($category) use ($incomeCategories, $expanseCategories){
                if ($category->type == 'K')
                    $incomeCategories->push($category);
                else if ($category->type == 'D')
                    $expanseCategories->push($category);
            });

        return view('categories.index')
            ->with(compact('incomeCategories', 'expanseCategories'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $tittle = 'Tambah Kategori';
        return view('categories.create', compact('tittle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->authorize('category-create');

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories',
            'type' => 'required'
        ]);

        if (auth()->user()->hasAnyRole('Manager|Employe')) {
            $saveData = $validator->safe()->merge([
                'company_id' => auth()->user()->company_id,
                'user_id' => auth()->user()->id
            ]);
        }

        if ($validator->fails())
        {
            return $request->ajax()
                ? response()->json(['errors'  => $validator->errors()], 400)
                : back()
                    ->withInput()
                    ->withErrors($validator->errors())
                    ->with('error',"Gagal menyimpan catatan. Cek kembali data inputan Anda.");
        }

        $category = Category::create(collect($saveData ?? $validator->validated())->toArray());

        return $request->ajax()
            ? $category
            : redirect()->route('categories.index')
                ->with('success','Berhasil menyimpan kategori.');
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return Application|Factory|View
     */
    public function edit(Category $category)
    {
        $tittle = 'Edit Kategori';
        return view('categories.edit', compact('tittle','category'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function update(Request $request, Category $category)
    {
        $this->authorize('category-edit');

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories',
            'type' => 'required',
        ]);

        if ($validator->fails())
        {
            return back()
                ->withInput()
                ->withErrors($validator->errors())
                ->with('error',"Gagal menyimpan kategori. Cek kembali data inputan Anda.");
        }

        $category->update($validator->validated());

        return redirect()->route('categories.index')
            ->with('success','Berhasil menyimpan kategori.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy(Category $category)
    {
        $this->authorize('category-delete');

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success',"Kategori $category->name berhasil dihapus.");
    }
}
