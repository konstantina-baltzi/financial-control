<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    // Ορίζουμε ποια πεδία μπορούν να συμπληρωθούν μαζικά
    protected $fillable = [
        'title',
        'amount',
        'paid_at',
        'expires_at',
        'notes',
    ];

    protected $casts = [
        'paid_at' => 'date',
        'expires_at' => 'date',
    ];
}
