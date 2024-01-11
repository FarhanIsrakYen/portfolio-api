<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectAndPublication extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'category',
        'duration',
        'link',
        'technologies_used',
        'images'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
