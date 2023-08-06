<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;
use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\Book;
use App\Models\Author;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Display top en books from last month.
     */
    public function topten(): JsonResponse
    {

        $top_ten = Purchase::selectRaw('count(*) as popularity, book_id, title')
            ->where('purchases.created_at', '>', now()->subDays(30)->endOfDay())
            ->leftJoin('books', 'purchases.book_id', '=', 'books.id')
            ->groupBy('book_id', 'title')
            ->orderBy('popularity', 'desc')
            ->limit(10)
            ->get();

        $book_list = [];
        foreach( $top_ten as $row ){

            $book_list[] = [
                'id'         => $row->book_id,
                'title'      => $row->title,
                'popularity' => $row->popularity,
            ];
        }

        return response()->json($book_list);
    }


    /**
     * Serch books and authors
     */
    public function search(string $search): JsonResponse
    {
        $books = Book::where('title', 'LIKE', '%'.$search.'%')
            ->pluck('id')
            ->toArray();

        $authors = Author::leftJoin('author_book', 'authors.id', '=', 'author_book.author_id')
            ->where('pseudonym', 'LIKE', '%'.$search.'%')
            ->pluck('book_id')
            ->toArray();

        
        $combined_ids = array_unique(array_merge($books, $authors), SORT_REGULAR);

        $book_list = [];
        foreach( $combined_ids as $book_id ){

            $book = Book::find($book_id);
            
            $book_list[] = [
                'id'               => $book_id,
                'title'            => $book->title,
                'authors'          => $book->getPseudonyms(),
                'popularity_total' => $book->getPopularityTotal(),
                'popularity'       => $book->getPopularityLastMonth(),
            ];
        }

        usort($book_list, fn ($x, $y) =>  $y['popularity'] <=> $x['popularity']);

        return response()->json($book_list);
    }

}
