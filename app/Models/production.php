<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class production extends Model
{
    use HasFactory;
    protected $table = 'production';
    protected $guarded = [];
    public $timestamps = false;
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pc) {
            $lastPC = self::orderBy('id', 'desc')->first();
            $lastID = ($lastPC) ? $lastPC->id : 0;
            $pc->referensi = 'PC-' . str_pad($lastID + 1, 4, '0', STR_PAD_LEFT);
        });
    }
    function product() {
        return $this->belongsTo(product::class);
    }
    public function materials()
    {
        return $this->product->materials();
    }
}
