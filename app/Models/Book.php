<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Book extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title', 'description',
        'price', 'image', 'author_id'];

    /**
     * Get the author that owns the Book
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
