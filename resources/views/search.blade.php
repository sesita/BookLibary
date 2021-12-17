@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row mt-3">
            <div class="row col-md-8">
                <h1 class="text-center pb-3"> წიგნები </h1>
                <form method="get" action="{{ route('search') }}" class="d-flex pb-3">
                    <input class="form-control me-2" type="search" name="query" placeholder="Search Books..." aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
                <br>
                @foreach ($query as $book)
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
                                        <a href="{{ route('author', $author->slug) }}"
                                            class="text-dark text-decoration-none"> {{ $author->name }}, </a>
                                    @endforeach
                                </p>
                                <p> სტატუსი: <strong> {{ $status }} </strong></p>
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
                            <h5 class="card-title pb-2"><a href="{{ route('author', $author->slug) }}"
                                    class="text-decoration-none"> {{ $author->name }} </a></h5>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
