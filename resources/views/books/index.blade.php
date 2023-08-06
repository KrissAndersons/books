@extends('layouts.app')

@section('content')
<div class="search_box"><lable>Search for books: </lable><input type="text" autofocus="autofocus" onkeyup="doSearch(this.value)"></div>
<div class="content">
    <div class="row first_row">
        <div class="title inline_block">Title</div>
        <div class="authors inline_block">Authors</div>
        <div class="pop_total inline_block">Sold total</div>
        <div class="pop_month inline_block">Popularity</div>
        <div class="button inline_block"></div>
    </div>
    
    @foreach($books as $book)
        <div class="row lines">
            <div class="title inline_block">{{ $book['title'] }}</div>
            <div class="authors inline_block">{{ $book['authors'] }}</div>
            <div class="pop_total inline_block">{{ $book['pop_total'] }}</div>
            <div class="pop_month inline_block">{{ $book['pop_last_month'] }}</div>
            <div class="button inline_block"><button type="button" onclick="buyBook({{ $book['id'] }})">Buy</button></div>
        </div>
    @endforeach
    

</div>

@endsection