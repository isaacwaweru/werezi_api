@extends('layouts.dashboard')

@section('content')

<!-- begin::page header -->
<div class="page-header">
    <h3>Add Books</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.books.index') }}">Books</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
        </ol>
    </nav>
</div>
<!-- end::page header -->

<div class="card">
    <div class="card-body">
        <h4 class="font-italic">Fill the form to add the new book</h4>
        <form action="{{ route('admin.books.store') }}" method="post">
            {{ csrf_field() }}
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" placeholder="Title" name="name" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">ISBN</label>
                        <input type="text" placeholder="ISBN" name="isbn" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Publish Date</label>
                        <input type="date" placeholder="Publish Date" name="date" class="form-control datepicker">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Length (Number of Pages)</label>
                        <input type="number" placeholder="Length (Number of Pages)" name="length" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Author</label>
                        <select name="author_id" class="form-control select2">
                            @foreach($authors as $author)
                            <option value="{{ $author->id }}">{{ $author->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Category</label>
                        <select name="category_id" class="form-control select2">
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Publisher</label>
                        <select name="publisher_id" class="form-control select2">
                            @foreach($publishers as $publisher)
                            <option value="{{ $publisher->id }}">{{ $publisher->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Synopsis</label>
                        <textarea class="form-control tinymce" name="synopsis" placeholder="Synopsis">{{ old('synopsis') }}</textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Excerpt</label>
                        <textarea class="form-control tinymce" name="excerpt" placeholder="Excerpt">{{ old('excerpt') }}</textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group text-right">
                        <button class="btn btn-primary"><i class="lni-save mr-2"></i>Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: 'textarea.tinymce',
        height: 300,
        plugins: "lists,code,hr,paste,spellchecker,table,wordcount"
    });
</script>
<style>
    .mce-notification-warning {
        display: none
    }
</style>
@endsection