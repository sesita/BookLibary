@extends('layouts.app')
@section('css')
    <!--[if IE 8]><script src="js/es5.js"></script><![endif]-->
    <script src="/js/jquery.min.js"></script>
    <script src="/dist/js/standalone/selectize.js"></script>
    <script src="/js/index.js"></script>
    <link rel="stylesheet" href="/dist/css/selectize.bootstrap5.css">
@endsection

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
        <form action="{{ route('admin.book.create') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="BookName" class="form-label">Book Name</label>
                <input type="text" class="form-control" id="BookName" name="book_name" placeholder="Book Name..."
                    value="{{ old('book_name') }}">
            </div>
            <div class="mb-3">
                <label for="issue_date" class="form-label">Date Of Issue</label>
                <input type="date" class="form-control" id="issue_date" name="issue_date" placeholder="Book Name..."
                    value="{{ old('issue_date') }}">
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status">
                    <option value=""> - Status - </option>
                    <option value="1"> თავისუფალი </option>
                    <option value="2"> დაკავებული </option>
                </select>
            </div>
            <div class="mb-3">
                <label for="authors" class="form-label">Authors</label>
                <input type="text" id="authors" name="authors" placeholder="Authors...">
            </div>
            
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

@endsection
@section('javascript')
    <script>
        let content = <?php echo json_encode($authors); ?>;
        $('#authors').selectize({
            plugins: ['remove_button'],
            maxItems: null,
            valueField: "id",
            labelField: 'name',
            searchField: 'name',
            options: content,
            create: true,
        });
    </script>
@endsection
