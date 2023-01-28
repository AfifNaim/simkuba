<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CashBook extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeSummary($query, string $type, string $reportPeriod = null, $conditionValue = null)
    {
        return $query->where('company_id', \auth()->user()->company_id)
            ->where('type', $type)
            ->when($reportPeriod == 'daily', function () use ($query, $conditionValue){
                return $query->whereDate('date', $conditionValue ?? date('Y-m-d'));
            })
            ->when($reportPeriod == 'weekly', function () use ($query, $conditionValue){
                return $query->whereBetween('date', $conditionValue ?? [
                    Carbon::parse('last monday')->startOfDay(),
                    Carbon::parse('next sunday')->endOfDay()
                ]);
            })
            ->when($reportPeriod == 'monthly', function () use ($query, $conditionValue){
                return $query->whereMonth('date', $conditionValue ?? date('m'));
            })
            ->when($reportPeriod == 'yearly', function () use ($query, $conditionValue){
                return $query->whereYear('date', $conditionValue ?? date('Y'));
            })
            ->sum('summary');
    }
}
