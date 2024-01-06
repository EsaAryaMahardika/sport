<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employee extends Model
{
    use HasFactory;
    protected $table = 'employee';
    protected $guarded = [];
    

    public function depart()
    {
        return $this->belongsTo(departemen::class);
    }
    public function jobpos()
    {
        return $this->belongsTo(jobposition::class);
    }
}
