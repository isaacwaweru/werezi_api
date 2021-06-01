@extends('layouts.dashboard') @section('content')
<!-- begin::page header -->
<div class="page-header">
    <h3>Categories</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.categories.index') }}">Categories</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                <a href="{{ route('admin.categories.show', $category->id) }}"
                    >{{ $category->name }}</a
                >
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Edit
            </li>
        </ol>
    </nav>
</div>
<!-- end::page header -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-head">
                    <h4 class="card-title">Edit Category</h4>
                </div>
                <div class="gaps-1x"></div>
                @if ($errors->count() > 0)
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                    @endforeach
                </div>
                @endif
                <form method="POST" action="{{ route('admin.categories.update', $category->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label
                            >Name</label
                        >
                        <input
                            class="form-control"
                            type="text"
                            name="name"
                            value="{{ $category->name }}"
                            required=""
                        />
                    </div>
                    <div class="form-group">
                        <label>Parent</label>
                        <select
                            required=""
                            class="form-control select2"
                            name="parent"
                        >
                            <option value="0">None</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $cat->id == $category->parent ? 'selected' : '' }}
                                >{{ $cat->name }}</option
                            >
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Position</label>
                        <input class="form-control" type="number" name="number" placeholder="Position" value="{{ $category->position }}">
                    </div>
                    <div class="gaps-1x"></div>
                    <button class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 
