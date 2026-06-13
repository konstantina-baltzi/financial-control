<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Ορίζουμε ποια πεδία επιτρέπεται να γεμίζουν αυτόματα
    protected $fillable = [
        'user_id',
        'name',
        'color',
    ];

    // Η σχέση: Μια κατηγορία έχει πολλούς λογαριασμούς
    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    // Η σχέση: Μια κατηγορία ανήκει σε έναν χρήστη
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
