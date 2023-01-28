<?php

namespace App\Http\Controllers;

use App\Models\CashBook;
use App\Models\Category;
use App\Models\Company;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Exports\CashBookExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(isset($_GET['categories'])){
            $categories = self::getCategories();
                if($_GET['categories'] == ""){
                        $cashbooks = CashBook::whereDate('date','>=',$_GET['from'])
                        ->whereDate('date','<=',$_GET['to'])
                        ->where('company_id', Auth::user()->company_id)
                        ->get();
                    }else{
                        $cashbooks = CashBook::where('category_id',$_GET['categories'])
                        ->whereDate('date','>=',$_GET['from'])
                        ->whereDate('date','<=',$_GET['to'])
                        ->where('company_id', Auth::user()->company_id)
                        ->get();
                    }

                    return view('report/index',['cashbooks' => $cashbooks, 'categories' => $categories]);
                }else{
                    $categories = Category::orderBy('name','asc')->get();

                    return view('report/index',['cashbooks' => array(), 'categories' => $categories]);
                }
    }

    public function report_excel()
    {
        $company = Company::find(auth()->user()->company_id);
        return Excel::download(new CashBookExport, 'Laporan Keuangan - '. $company->name .' - '. time() . '.xls');
    }

    public function report_pdf()
    {
        $categories = self::getCategories();
        $company = Company::find(auth()->user()->company_id);
        
        if($_GET['categories'] == ""){
            $cashbooks = CashBook::whereDate('date','>=',$_GET['from'])
                ->whereDate('date','<=',$_GET['to'])
                ->where('company_id', Auth::user()->company_id)
                ->get();
        }else{
            $cashbooks = CashBook::where('category_id',$_GET['categories'])
                ->whereDate('date','>=',$_GET['from'])
                ->whereDate('date','<=',$_GET['to'])
                ->where('company_id', Auth::user()->company_id)
                ->get();
        }

        $pdf = PDF::loadView('report.pdf', ['cashbooks' => $cashbooks, 'categories' => $categories, 'company' => $company]);
        return $pdf->download('Laporan Keuangan - '. $company->name .' - '. time() . '.pdf');
    }

    public function report_daily()
    {

        $company = Company::find(auth()->user()->company_id);
        $categories = self::getCategories();
        $day = date('d');

        $cashbooks = CashBook::where('company_id', Auth::user()->company_id)
        ->whereDate('date', $day)
        ->get();

        return view('report.daily',['cashbooks' => $cashbooks, 'categories' => $categories, 'company' => $company]);
    }

    public function report_monthly()
    {

        $company = Company::find(auth()->user()->company_id);
        $categories = self::getCategories();
        $month = date('m');

        $cashbooks = CashBook::where('company_id', Auth::user()->company_id)
        ->whereMonth('date', $month)
        ->get();

        return view('report.montly',['cashbooks' => $cashbooks, 'categories' => $categories, 'company' => $company]);
    }
    public function report_annual()
    {

        $company = Company::find(auth()->user()->company_id);
        $categories = self::getCategories();
        $year = date('Y');

        $cashbooks = CashBook::where('company_id', Auth::user()->company_id)
        ->whereYear('date', $year)
        ->get();

        return view('report.annual',['cashbooks' => $cashbooks, 'categories' => $categories, 'company' => $company]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function getCategories(): \Illuminate\Support\Collection
    {
        $categories = collect(Category::query()
            ->where('company_id', auth()->user()->company_id)
            ->orWhereNull('company_id')
            ->orderBy('name')
            ->get());

        return $categories;
    }
}
