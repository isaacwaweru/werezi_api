@extends('layouts.dashboard')

@section('content')
    <!-- begin::page header -->
    <div class="page-header">
        <h3>Featured Items</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.featured-items.index') }}">Featured Items</a></li>
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
                        <h4 class="card-title">Products</h4>
                    </div>
                    <div class="gaps-1x"></div>
                    @if($errors->count() > 0)
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                        @endforeach
                    </div>
                    @endif
                    <form action="{{ route('admin.featured-items.store') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="input-item-label text-exlight">Title</label>
                            <input class="form-control" type="text" name="title" required="" placeholder="Title">
                        </div>
                        <div class="form-group">
                            <label>Target</label>
                            <select required="" class="form-control select2" name="target">
                                @foreach($navigations as $nav)
                                <option value="{{ $nav->slug }}">{{ $nav->reference . ' - ' . $nav->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="gaps-1x"></div>
                        <button class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection