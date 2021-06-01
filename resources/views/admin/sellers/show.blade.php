@extends('layouts.dashboard')

@section('content')
    <!-- begin::page header -->
    <div class="page-header">
        <h3>Sellers</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.sellers.index') }}">Sellers</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $seller->name }}</li>
            </ol>
        </nav>
    </div>
    <!-- end::page header -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-head">
                        <form action="{{ route('admin.sellers.destroy', $seller->id) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button class="btn btn-danger btn-sm btn-auto float-right">Delete</button>
                        </form>
                        <a href="{{ route('admin.sellers.edit', $seller->id) }}" class="btn btn-sm mr-2 btn-info float-right"><i class="lni-pencil mr-2"></i>edit</a>
                        <h4 class="card-title">{{ $seller->name}}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection