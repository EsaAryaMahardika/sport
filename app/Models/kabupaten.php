<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kabupaten extends Model
{
    use HasFactory;
    protected $table = 'kabupaten';
    public $incrementing = false;
    protected $keytype = 'string';
    public $timestamps = false;
    protected $fillable = ['id', 'id_prov', 'nama'];
    public function prov()
    {
        return $this->belongsTo(provinsi::class);
    }
}
