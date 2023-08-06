<?php

namespace App\Http\Controllers;

use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Purchase;
use Carbon\Carbon;

class BooksController extends Controller
{
    
    public function index(){

        $top_list = Purchase::selectRaw('count(*) as popularity, book_id')
            ->where('created_at', '>', now()->subDays(30)->endOfDay())
            ->groupBy('book_id');
        
        $books_popularity = DB::table('books')
            ->leftJoinSub($top_list, 'popularity', function (JoinClause $join) {
                $join->on('books.id', '=', 'popularity.book_id');
            })
            ->orderBy('popularity', 'desc')
            ->get();
        
        $books = [];
        foreach( $books_popularity as $row ){

            $book = Book::find($row->id);

            $books[] = [
                'id'             => $book->id,
                'title'          => $book->title,
                'authors'        => $book->getPseudonyms(),
                'pop_total'      => $book->getPopularityTotal(),
                'pop_last_month' => $row->popularity,
            ];
        }

        return view('books/index', [
            'books' => $books,
        ]);

    }

}
