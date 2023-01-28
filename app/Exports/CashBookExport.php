<?php

namespace App\Exports;

use App\Models\CashBook;
use App\Models\Category;
use App\Models\Company;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class CashBookExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $categories = self::getCategories();
        $companies = Company::find(auth()->user()->company_id);

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

    	return view('report.excel',['cashbooks' => $cashbooks, 'categories' => $categories, 'companies' => $companies]);
    	
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
