<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Book extends Model
{
    use HasFactory;

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    public function getPseudonyms(): string
    {
        $pseudonyms = [];
        foreach( $this->authors as $author )
        {
            $pseudonyms[] = $author->pseudonym;
        }

        return implode(', ', $pseudonyms);
    }

    public function getPopularityTotal(): int
    {
        return $this->purchases->count();
    }

    public function getPopularityLastMonth(): int
    {
        return $this->purchases()->where('created_at', '>', now()->subDays(30)->endOfDay())->count();
    }

}
