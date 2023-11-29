<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    protected $table = 'product';
    protected $guarded = [];
    public function materials()
    {
        return $this->belongsToMany(materials::class, 'component')->withPivot('jumlah');
    }
    public function factory()
    {
        return $this->belongsTo(factory::class);
    }
    public function category()
    {
        return $this->belongsTo(category::class);
    }
}
