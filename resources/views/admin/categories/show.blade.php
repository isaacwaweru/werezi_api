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
            <li class="breadcrumb-item active" aria-current="page">
                {{ $category->name }}
            </li>
        </ol>
    </nav>
</div>
<!-- end::page header -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <p>{{ $category->slug() }}</p>
                
                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button class="btn btn-sm btn-danger float-right"><i class="lni-trash mr-2"></i>delete</button>
                </form>
                
                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm mr-2 btn-info float-right"><i class="lni-pencil mr-2"></i>edit</a>
                <h4 class="card-title">{{ $category->name}}</h4>
            </div>
        </div>
    </div>
</div>
@endsection
