<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'topic',
        'percentage'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
