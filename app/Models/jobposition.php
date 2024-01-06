<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jobposition extends Model
{
    use HasFactory;
    protected $table = 'jobposition';
    public $incrementing = false;
    protected $keytype = 'string';
    public $timestamps = false;
    protected $fillable = ['id', 'nama'];
}
