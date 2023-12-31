<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class factory extends Model
{
    use HasFactory;
    protected $table = 'factory';
    protected $guarded = [];
    public function prov()
    {
        return $this->belongsTo(provinsi::class);
    }
    public function kab()
    {
        return $this->belongsTo(kabupaten::class);
    }
}
