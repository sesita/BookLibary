@extends('layouts.app')

@section('content')

    <div class="container bg-white text-dark p-4 mt-4">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }} <br>
                @endforeach
            </div>
        @endif
        <form action="{{ route('admin.author.edit', $id) }}" method="post">
            @csrf
            @method('patch')
            <div class="mb-3">
                <label for="AuthorName" class="form-label">Author Name</label>
                <input type="text" class="form-control" id="AuthorName" name="author_name" placeholder="Author Name..." value="{{ $author->name }}">
            </div>
            <div class="mb-3">
                <label for="Slug" class="form-label">Slug</label>
                <input type="text" class="form-control" id="Slug" name="slug" placeholder="Slug..." value="{{ $author->slug }}">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

@endsection
