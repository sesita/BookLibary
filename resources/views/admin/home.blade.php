@extends('layouts.app')

@section('content')

    <div class="container mt-4">
        <div class="row mt-3">
            <div class="row col-md-8">
                <h1 class="text-center pb-3"> წიგნები </h1>
                <form method="get" action="{{ route('search') }}" class="d-flex pb-3">
                    <input class="form-control me-2" type="search" name="query" placeholder="Search Books..." aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
                <div class="col-sm-4 pb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title fw-bold"> წიგნის დამატება </h5>
                            <a href="{{ route('admin.book.formAdd') }}" class="btn btn-primary mt-2"><i
                                    class="fas fa-plus"></i>
                                დამატება </a>
                        </div>
                    </div>
                </div>
                @foreach ($books as $book)
                    <?php
                    if ($book->status === 1) {
                        $status = 'თავისუფალია';
                    } elseif ($book->status === 2) {
                        $status = 'დაკავებულია';
                    } else {
                        $status = 'უცნობია';
                    }
                    ?>
                    <div class="col-sm-4 pb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $book->title }}</h5>
                                <p> გამოშვების წელი: <strong>{{ $book->issue_date }}</strong></p>
                                <p> ავტორი:
                                    @foreach ($book->authors as $author)
                                        <a href="{{ route('admin.author', $author->slug) }}"
                                            class="text-dark text-decoration-none"> {{ $author->name }}, </a>
                                    @endforeach
                                </p>
                                <p> სტატუსი: <strong> {{ $status }} </strong></p>
                                <form method="post" action="{{ route('admin.book.delete', $book->id) }}">
                                    @csrf @method('delete')
                                    <a href="{{ route('admin.book.formEdit', $book->id) }}" class="btn btn-primary"><i
                                            class="fas fa-edit"></i> რედაქტირება </a>
                                    <button type="submit" class="btn btn-danger float-end"><i class="fas fa-trash"></i>
                                        წაშლა
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-md-3 ms-auto">
                <h1 class="text-center pb-3"> ავტორები </h1>
                @foreach ($authors as $author)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title pb-2"><a href="{{ route('admin.author', $author->slug ) }}" class="text-decoration-none"> {{ $author->name }} </a></h5>
                            <form method="post" action="{{ route('admin.author.delete', $author->id) }}">
                                @csrf @method('delete')
                                <a href="{{ route('admin.author.formEdit', $author->id) }}" class="btn btn-primary"><i
                                        class="fas fa-edit"></i> რედაქტირება </a>
                                <button type="submit" class="btn btn-danger float-end"><i class="fas fa-trash"></i>
                                    წაშლა
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
