@extends('layouts.dashboard')

@section('content')
    <!-- begin::page header -->
    <div class="page-header">
        <h3>Publishers</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.publishers.index') }}">Publishers</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.publishers.show', $publisher->name) }}">{{ $publisher->name }}</a></li>
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
                        <h4 class="card-title">Edit - {{ $publisher->name }}</h4>
                    </div>
                    <div class="gaps-1x"></div>
                    @if ($errors->count() > 0)
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                        @endforeach
                    </div>
                    @endif
                    <form method="post" action="{{ route('admin.publishers.update', $publisher->id) }}">
                        {{ csrf_field() }}
                        @method('PUT')
                        <input type="hidden" name="action" value="name">
                        <div class="form-group">
                            <label>Name</label>
                            <input class="form-control" type="text" name="name" required="" value="{{ $publisher->name }}" placeholder="Name">
                        </div>
                        <div class="gaps-1x"></div>
                        <button class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection