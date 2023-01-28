<?php

namespace App\Http\Controllers;

use App\Models\CashBook;
use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('Manager|Employe'))
            return self::adminDashboard();
        else if (auth()->user()->hasRole('Admin'))
            return self::superAdminDashboard();
        else
            abort(403);
    }

    public function superAdminDashboard()
    {
        $data = [
            'company_count' => Company::count(),
            'user_count' => User::whereNotNull('company_id')->count(),
            'cashbook_count' => CashBook::count()
        ];

        return \view('dashboard.super-admin', compact('data'));
    }

    public function adminDashboard()
    {
        
        $summary = static::getSummaryReport();
        return \view('dashboard.admin', compact('summary'));
    }

    public function report($reportType)
    {
        switch ($reportType){
            case 'daily':
                $report = static::getDailyReport();
                break;
            case 'weekly':
                $report = static::getWeeklyReport();
                break;
            case 'monthly':
                $report = static::getMonthlyReport();
                break;
            case 'yearly':
                $report = static::getYearlyReport();
                break;
        }

        return $report ?? ['labels' => null, 'data' => null];
    }

    private static function getDailyReport()
    {
        $report['labels'] = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"];
        $report['data']   = [];

        $startDate  = Carbon::parse('last monday');
        $date = $startDate;

        for ($i = 0; $i < 7; $i++){
            $report['data']['income'][] = CashBook::query()->summary('K', 'daily', $date->format('Y-m-d'));
            $report['data']['expanse'][] = CashBook::query()->summary('D', 'daily', $date->format('Y-m-d'));
            $report['data']['amount'][] = CashBook::query()->summary('K', 'daily', $date->format('Y-m-d')) - CashBook::query()->summary('D', 'daily', $date->format('Y-m-d'));

            $date = $startDate->addDays();
        }

        return $report;
    }

    private static function getWeeklyReport()
    {
        $labels = [];

        $weekRange      = [];

        $dayOfWeek      = date('w');
        $dayStart       = 1;
        $diff           = $dayStart - $dayOfWeek;
        $minus_weeks    = 5;

        for ($i = 0; $i <= $minus_weeks; $i++) {

            $k = $i - 1;

            $from_formula   = strtotime("-$i week $diff day");
            $to_formula     = strtotime("-$k week " . ($diff - 1) . " day");
            $weekRange[] = date('Y-m-d', $from_formula) . ',' . date('Y-m-d', $to_formula);

            $day_from   = date('j', $from_formula);
            $day_to     = date('j', $to_formula);

            $month_from = date('M', $from_formula);
            $month_to   = date('M', $to_formula);
            $labels[] = "$day_from $month_from - $day_to $month_to";
        }

        $income = [];
        $expanse = [];
        $amount = [];

        foreach ($weekRange as $week){
            $income[] = CashBook::query()->summary('K', 'weekly', explode(',', $week));
            $expanse[] = CashBook::query()->summary('D', 'weekly', explode(',', $week));
            $amount[] = CashBook::query()->summary('K', 'weekly', explode(',', $week)) - CashBook::query()->summary('D', 'weekly', explode(',', $week));
        }

        $data['income'] = array_reverse($income);
        $data['expanse'] = array_reverse($expanse);
        $data['amount'] = array_reverse($amount);

        $report['labels'] = array_reverse($labels);
        $report['data']   = $data;

        return $report;
    }

    private static function getMonthlyReport()
    {
        $report['labels'] = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $report['data']   = [];

        for ($i = 1; $i <= 12; $i++){
            $report['data']['income'][] = CashBook::query()->summary('K', 'monthly', $i);
            $report['data']['expanse'][] = CashBook::query()->summary('D', 'monthly', $i);
            $report['data']['amount'][] = CashBook::query()->summary('K', 'monthly', $i) - CashBook::query()->summary('D', 'monthly', $i);
        }

        return $report;
    }

    private static function getYearlyReport()
    {
        $report['labels'] = range(date('Y')-2,date("Y"));
        $report['data']   = [];

        for ($i = date('Y')-2; $i <= date("Y"); $i++){
            $report['data']['income'][] = CashBook::query()->summary('K', 'yearly', $i);
            $report['data']['expanse'][] = CashBook::query()->summary('D', 'yearly', $i);
            $report['data']['amount'][] = CashBook::query()->summary('K', 'yearly', $i) - CashBook::query()->summary('D', 'yearly', $i);
        }

        return $report;
    }

    private static function getSummaryReport()
    {
        $report = [];

        $report['all'] = [
            'income' => CashBook::query()->summary('K'),
            'expanse' => CashBook::query()->summary('D'),
        ];

        $report['daily'] = [
            'income' => CashBook::query()->summary('K', 'daily'),
            'expanse' => CashBook::query()->summary('D', 'daily'),
            'amount' => CashBook::query()->summary('K','daily') - CashBook::query()->summary('D','daily'),
        ];

        $report['weekly'] = [
            'income' => CashBook::query()->summary('K', 'weekly'),
            'expanse' => CashBook::query()->summary('D', 'weekly'),
            'amount' => CashBook::query()->summary('K','weekly') - CashBook::query()->summary('D','weekly'),
        ];

        $report['monthly'] = [
            'income' => CashBook::query()->summary('K', 'monthly'),
            'expanse' => CashBook::query()->summary('D', 'monthly'),
            'amount' => CashBook::query()->summary('K','monthly') - CashBook::query()->summary('D','monthly'),
        ];

        $report['yearly'] = [
            'income' => CashBook::query()->summary('K', 'yearly'),
            'expanse' => CashBook::query()->summary('D', 'yearly'),
            'amount' => CashBook::query()->summary('K','yearly') - CashBook::query()->summary('D','yearly'),
        ];
        return json_decode(json_encode($report));
    }
}
