@extends('layouts.dashboard')

@section('content')
    <!-- begin::page header -->
    <div class="page-header">
        <h3>Categories</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create</li>
            </ol>
        </nav>
    </div>
    <!-- end::page header -->

	<div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-head">
                        <h4 class="card-title">Create Category</h4>
                    </div>
                    <div class="gaps-1x"></div>
                    @if ($errors->count() > 0)
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                        @endforeach
                    </div>
                    @endif
                    <div id="parent-selection">
                        <form method="post" action="{{ route('admin.categories.store') }}" @submit.prevent="validate">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label>Name</label>
                                <input class="form-control" type="text" name="name" placeholder="Name" required="">
                            </div>
                            <div class="form-group">
                                <label for="">Parent</label>
                                <select class="form-control select2" name="parent" required placeholder="Select Parent">
                                    <option value="0">None</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Position</label>
                                <input class="form-control" type="number" position="position" placeholder="Position" value="1">
                            </div>
                            <div class="gaps-1x"></div>
                            <button class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
