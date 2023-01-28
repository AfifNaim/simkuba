<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'company_id','type', 'name'
    ];

    public function cash_book(){
        return $this->hasMany(CashBook::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
