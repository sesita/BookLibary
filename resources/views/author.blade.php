@extends('layouts.app')

@section('content')

    <div class="container">

        <h1 class="text-center"> {{ $author->name }} ის - წიგნები </h1>
        <div class="row mt-4">
            @foreach ($author->books as $book)
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
                                    <a href="{{ route('author', $author->slug ) }}" class="text-dark text-decoration-none"> {{ $author->name }}, </a>
                                @endforeach
                            </p>
                            <p> სტატუსი: <strong> {{ $status }} </strong></p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
