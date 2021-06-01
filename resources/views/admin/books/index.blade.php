@extends('layouts.dashboard')

@section('content')

<!-- begin::page header -->
<div class="page-header">
    <a href="{{ route('admin.books.create') }}" class="btn btn-primary btn-sm float-right"><i class="lni-plus mr-2"></i>Add New Book</a>
    <h3>Books</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Books</li>
        </ol>
    </nav>
</div>
<!-- end::page header -->


<div class="card">
    <div class="card-body">
        <table class="table table-striped data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>ISBN</th>
                    <th>Author</th>
                    <th>Publisher</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($books as $book)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $book->name }}</a></td>
                    <td>{{ $book->isbn }}</a></td>
                    <td><a href="{{ route('admin.authors.show', $book->id) }}">{{ $book->author->name }}</td>
                    <td><a href="{{ route('admin.publishers.show', $book->id) }}">{{ $book->publisher->name }}</td>
                    <td><a href="{{ route('admin.categories.show', $book->id) }}">{{ $book->category->name }}</a></td>
                    <td><a href="{{ route('admin.books.show', $book->id) }}" class="btn btn-primary btn-sm"><i class="lni-eye mr-2"></i> view</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
