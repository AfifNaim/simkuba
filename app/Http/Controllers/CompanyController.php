<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use LaravelIdea\Helper\App\Models\_IH_CashBook_C;
use Illuminate\Support\Facades\Auth;



class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('company-access');

        $companies = Company::all();

        return view('companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|RedirectResponse
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('company-create');

        if (\auth()->user()->company_id)
            return redirect()->route('companies.profile');

        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $input = $request->all();

        if ($logo = $request->file('logo')) {
            $destinationPath = 'images/company';
            $companyLogo = date('YmdHis') . "." . $logo->getClientOriginalExtension();
            $logo->move($destinationPath, $companyLogo);
            $input['logo'] = "$companyLogo";
        }

        $company = Company::create($input);

        $user= auth()->user();
        $user->update(['company_id' => $company->id ]);

        return redirect()->route('companies.profile')
                        ->with('success','Data UMKM berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     *
     * @return Application|Factory|View|RedirectResponse
     * @throws AuthorizationException
     */
    public function profile()
    {
        $this->authorize('company-profile');

        $user = auth()->user();

        if (! $user->company_id){
            return redirect()->route('companies.create')
            ->with('error',"Data UMKM tidak ditemukan. Silakan isi data UMKM terlebih dahulu.");
        }

        $company = Company::find(auth()->user()->company_id);

        return view('companies.profile', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Company $company
     * @return Application|Factory|View
     */
    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Company $company
     * @return JsonResponse|RedirectResponse
     */
    public function update(Request $request, Company $company)
    {
        $validator = $this->validation($request);

        if ($validator->fails())
        {
            return $request->ajax()
                ? response()->json(['errors'  => $validator->errors()], 400)
                : back()
                    ->withInput()
                    ->withErrors($validator->errors())
                    ->with('error',"Gagal menyimpan perubahan. Cek kembali data inputan Anda.");
        }

        $saveCompany = $validator->safe()->except(['logo']);

        if ($logo = $request->file('logo')) {
            File::delete(public_path('images/company/'.$company->logo));

            $destinationPath = 'images/company';
            $fileName = date('YmdHis') . "." . $logo->getClientOriginalExtension();
            $logo->move($destinationPath, $fileName);

            $saveCompany['logo'] = $fileName;
        }

        $company->update($saveCompany);

        return redirect()->route('companies.profile')
                        ->with('success','Data UMKM berhasil disimpan.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Company $company
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(Company $company)
    {
        $this->authorize('company-delete');
        $company->delete();

        return redirect()->route('companies.index')
            ->with('success', "UMKM $company->name berhasil dihapus");
    }

    private function validation(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($request->except('category_name'), [
            'name' => 'required',
            'address' => 'required',
            'logo' => 'sometimes|file|mimes:jpg,jpeg,png|max:1048'
        ]);
    }
}
