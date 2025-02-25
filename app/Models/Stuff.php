<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stuff extends Model
{
    // jika menggunakan uuid harus diimport
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $fillable = ['name', 'type'];
    // isi enum
    public const HTL_KLN = "HTL/KLN";
    public const LAB = "Lab";
    public const SARPRAS = "Sarpras";

    public function inboundStuff()
    {
        return $this->hasMany(InboundStuff::class);
    }

    public function stuffStock()
    {
        return $this->hasOne(StuffStock::class);
    }

    public function lending()
    {
        return $this->hasMany(Lending::class);
    }
}
