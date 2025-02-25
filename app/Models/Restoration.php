<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Restoration extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $fillable = ["user_id", "lending_id", "date_time", "total_good_stuff", "total_defec_stuff"];

    public function lending()
    {
        return $this->belongsTo(Lending::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
