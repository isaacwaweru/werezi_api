@extends('layouts.dashboard')

@section('content')
    <!-- begin::page header -->
    <div class="page-header">
        <h3>Authors</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.authors.index') }}">Authors</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.authors.show', $author->name) }}">{{ $author->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div>
    <!-- end::page header -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-head">
                        <h4 class="card-title">Edit - {{ $author->name }}</h4>
                    </div>
                    <div class="gaps-1x"></div>
                    @if ($errors->count() > 0)
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                        @endforeach
                    </div>
                    @endif
                    <form method="post" action="{{ route('admin.authors.update', $author->id) }}">
                        {{ csrf_field() }}
                        @method('PUT')
                        <input type="hidden" name="action" value="name">
                        <div class="form-group">
                            <label>Name</label>
                            <input class="form-control" type="text" name="name" required="" value="{{ $author->name }}" placeholder="Name">
                        </div>
                        <div class="gaps-1x"></div>
                        <button class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection