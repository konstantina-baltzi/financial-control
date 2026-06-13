<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    // Ορίζουμε ποια πεδία μπορούν να συμπληρωθούν μαζικά
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'amount',
        'paid_at',
        'expires_at',
        'notes',
        'frequency',
    ];

    protected $casts = [
        'paid_at' => 'date',
        'expires_at' => 'date',
    ];

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
