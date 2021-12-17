<?php

namespace App\Http\Controllers;

use DB;
use Alert;
use App\Models\Book;
use App\Models\Author;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function formAdd(){
        $authors=Author::latest()->get();

        return view('admin.create-book', compact('authors'));
    }
    public function formEdit($id){
        $authors=Author::latest()->get();
        $book=Book::where('id', $id)->firstorfail();

        return view('admin.edit-book', compact('authors','book','id'));
    }
    public function addBook(Request $request){
        $rules = [
			'book_name' => 'required|string|min:3|max:255',
            'issue_date' => 'required',
            'status' => 'required',
            'authors' => 'required',
    	];
		$validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			return back()
			->withInput()
			->withErrors($validator);
		}
		else {
            $data = $request->input();
			try { 

                $book = new Book;
                $book->title = $data['book_name'];
                $book->issue_date = $data['issue_date'];
                $book->status = $data['status'];
                $book->save();

                $authors = explode(",", $data['authors']);

                for ($i = 0; $i < count($authors); $i++) {
                    if (is_numeric($authors[$i])) {
                        DB::table('author_book')->insert([
                            'book_id' => $book->id,
                            'author_id' => $authors[$i]
                        ]);
                    } else {
                        $author = new Author;
                        $author->name = $authors[$i];
                        $author->slug = Str::slug($authors[$i], "-");
                        $author->save();
                        DB::table('author_book')->insert([
                            'book_id' => $book->id,
                            'author_id' => $author->id
                        ]);
                    }
                }

                Alert::success('წიგნი წარმატებით დაემატა');
                return redirect('/admin/home');
            }
			catch(Exception $e){
                Alert::error('ოპერაცია ვერ განხორციელდა');
                return back();
			}
        }
    }
    public function editBook(Request $request, $id) {
        $rules = [
			'book_name' => 'required|string|min:3|max:255',
            'issue_date' => 'required',
            'status' => 'required',
            'authors' => 'required|min:3',
    	];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return back()
            ->withInput()
            ->withErrors($validator);
        }
        else { 
            $data = $request->input();
            try {
                $book = new Book;
                $book = Book::find($id);
                $book->title = $data['book_name'];
                $book->issue_date = $data['issue_date'];
                $book->status = $data['status'];
                $book->update();
                DB::table('author_book')->where('book_id', $book->id)->delete();
                $authors = explode(",", $data['authors']);
                for ($i = 0; $i < count($authors); $i++) {
                    
                    $author = Author::where('slug', '=', $authors[$i])->first();
                    if ($author != null) {
                        DB::table('author_book')->insert([
                            'book_id' => $book->id,
                            'author_id' => $author->id
                        ]);
                    } else {
                        if($authors[$i] != ""){
                            $author = new Author;
                            $author->name = $authors[$i];
                            $author->slug = Str::slug($authors[$i], "-");
                            $author->save();
                            DB::table('author_book')->insert([
                                'book_id' => $book->id,
                                'author_id' => $author->id
                            ]);
                        } 
                    }
                    
                }

                Alert::success('წიგნი წარმატებით განახლდა');
                return redirect('/admin/home');
            }
            catch(Exception $e){
                notify()->error('ოპერაცია ვერ განხორციელდა');
                return back();
            }
        }
    }
    public function deleteBook($id) {
        Book::where('id', $id)->delete();
        Alert::success('წიგნი წარმატებით წაიშალა');
        return back();
    }

}
