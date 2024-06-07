<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'position',
        'institution',
        'duration',
        'job_type',
        'responsibilities',
        'technologies_used'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
