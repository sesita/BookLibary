<?php

namespace App\Http\Controllers;

use Alert;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    public function index($slug)
    {
        $author = Author::where('slug', $slug)->with(['books'])->firstorfail();
        return view('author', compact('author'));
    }
    public function adminAuthor($slug)
    {
        $author = Author::where('slug', $slug)->with(['books'])->firstorfail();
        return view('admin.author', compact('author'));
    }
    public function formEdit($id){
        $author=Author::where('id', $id)->firstorfail();
        return view('admin.edit-author', compact('author','id'));
    }
    public function editAuthor(Request $request, $id) {
        $rules = [
			'author_name' => 'required|string|min:3|max:255',
            'slug' => 'required',
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
                $author = new Author;
                $author = Author::find($id);
                $author->name = $data['author_name'];
                $author->slug = $data['slug'];
                $author->update();
                Alert::success('ავტორი წარმატებით განახლდა');
                return redirect('/admin/home');
            }
            catch(Exception $e){
                notify()->error('ოპერაცია ვერ განხორციელდა');
                return back();
            }
        }
    }
    public function deleteAuthor($id) {
        Author::where('id', $id)->delete();
        Alert::success('ავტორი წარმატებით წაიშალა');
        return back();
    }
}
