<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'isbn',
        'title',
        'author',
        'publisher',
        'image',
        'back_image',
        'shelf_number',
        'category',
        'stock',
        'is_featured',
        'description',
        'language',
        'published_date',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    /**
     * Get the loans for the book
     */
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
