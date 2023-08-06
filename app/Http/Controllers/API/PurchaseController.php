<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\Book;
use Exception;

class PurchaseController extends Controller
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
     * Add purchace.
     */
    public function purchase(string $id): JsonResponse
    {
        
        if (!Book::where('id', '=', $id)->exists()) 
        {
            $response = response()->json(['succes' => false, 'message' => 'Bad request'], 400);    
        } else 
        {
            try {
                Purchase::create(['book_id' => $id]);                
                $response = response()->json(['succes' => true]); 
            } catch (Exception $e) {
                $response = response()->json(['succes' => false, 'message' => 'General server error'], 500);
            }
        }
        
        return $response;
    }
}
