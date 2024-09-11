<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rest extends Model
{
    use HasFactory;

    protected $dates = [
        'rest_start',
        'rest_end',
    ];

    protected $fillable = [
        'works_id',
        'rest_start',
        'rest_end'
    ];

    public function works()
    {
        return $this->belongsTo(Work::class);
    }
}
