@extends('layouts.dashboard')

@section('content')
    <!-- begin::page header -->
    <div class="page-header">
        <h3>Categories</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Categories</li>
            </ol>
        </nav>
    </div>
    <!-- end::page header -->

	<div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-head">
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm" style="float: right">Add Category</a>
                        <h4 class="card-title">All Categories</h4>
                    </div>
                    <div class="gaps-1x"></div>
                    <table class="table table-striped data-table">
                        <thead>
                                <tr class="data-item data-head">
                                    <th class="data-col dt-user">Name</th>
                                    <th class="data-col dt-token">Parent</th>
                                    <th class="data-col dt-email">Number of Products</th>
                                    <th class="data-col dt-verify">Actions</th>
                                </tr>

                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->parentCategory->name }}</td>
                                <td>0</td>
                                <td class="text-right">
                                    <a href="{{ route('admin.categories.show', $category->id) }}" class="btn btn-info btn-sm">View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection