<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\CashBook;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $tittle     ="Dashboard";
        $cashBooks  = CashBook::where('company_id', Auth::user()->company_id);
        $date = date('Y-m-d');
        $sumIncomeByDay = $cashBooks->where('type', 'K') ->where('date', date('Y-m-d'))->sum('amount');
        $sumIncomeByWeek = $cashBooks->where('type', 'K')->whereBetween('date', [
            Carbon::parse('last monday')->startOfDay(),
            Carbon::parse('next sunday')->endOfDay(),
        ])->sum('amount');
        $sumIncomeByMonth = $cashBooks->where('type', 'K')->whereMonth('date',date('m'))->sum('amount');
        $sumIncomeByYear = $cashBooks->where('type', 'K')->where('date', date('Y'))->sum('amount');
        $sumIncomeallTime = $cashBooks->where('type', 'K')->sum('amount');

        $sumExpensebyDay = $cashBooks->where('type', 'M')->where('date', date('d'))->sum('amount');
        $sumExpensebyWeek = $cashBooks->where('type', 'M')->whereBetween('date', [
            Carbon::parse('last monday')->startOfDay(),
            Carbon::parse('next sunday')->endOfDay(),
        ])->sum('amount');
        $sumExpensebyMonth = $cashBooks->where('type', 'M')->where('date', date('m'))->sum('amount');
        $sumExpensebyYear = $cashBooks->where('type', 'M')->where('date', date('y'))->sum('amount');
        $sumExpenseallTime = $cashBooks->where('type', 'M')->where('date', date('y'))->sum('amount');

        return view('dashboard/index', compact (
            'sumIncomeByDay',
            'sumIncomeByWeek',
            'sumIncomeByMonth',
            'sumIncomeByYear',
            'sumIncomeallTime',
            'sumExpensebyDay',
            'sumExpensebyWeek',
            'sumExpensebyMonth',
            'sumExpensebyYear',
            'sumExpenseallTime',

        ));
    }
}
