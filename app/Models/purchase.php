<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchase extends Model
{
    use HasFactory;
    protected $table = 'purchase';
    protected $guarded = [];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pc) {
            $lastPC = self::orderBy('id', 'desc')->first();
            $lastID = ($lastPC) ? $lastPC->id : 0;
            $pc->referensi = 'PR-' . str_pad($lastID + 1, 4, '0', STR_PAD_LEFT);
        });
    }
    public function materials()
    {
        return $this->belongsToMany(materials::class, 'purchaseList')->withPivot('jumlah');
    }
    public function vendor()
    {
        return $this->belongsTo(vendor::class);
    }
}
