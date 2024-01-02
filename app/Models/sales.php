<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sales extends Model
{
    use HasFactory;
    protected $table = 'sales';
    protected $guarded = [];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pc) {
            $lastPC = self::orderBy('id', 'desc')->first();
            $lastID = ($lastPC) ? $lastPC->id : 0;
            $pc->referensi = 'SL-' . str_pad($lastID + 1, 4, '0', STR_PAD_LEFT);
        });
    }
    public function product()
    {
        return $this->belongsToMany(product::class, 'salesList')->withPivot('jumlah');
    }
    public function customer()
    {
        return $this->belongsTo(customer::class);
    }
}
