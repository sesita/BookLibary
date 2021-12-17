<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $books = Book::with(['authors'])->latest()->get();
        $authors=Author::latest()->get();
        return view('home', compact('books','authors'));
    }

    public function adminHome()
    {
        $books = Book::with(['authors'])->latest()->get();
        $authors=Author::latest()->get();
        return view('admin.home', compact('books','authors'));
    }
    public function search(Request $request)
    {
        $data = $request->input();
        $query = Book::where('title','like','%'.$data['query'].'%')->latest()->get();
        $authors=Author::latest()->get();
        return view('search', compact('query','authors'));
    }
}