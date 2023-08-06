<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    
    protected $fillable = ['book_id'];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

}
