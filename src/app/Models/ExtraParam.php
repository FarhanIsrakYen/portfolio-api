<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtraParam extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'parameter_name',
        'parameter_value'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
