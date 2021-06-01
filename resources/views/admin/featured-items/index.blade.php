@extends('layouts.dashboard')

@section('content')
    <!-- begin::page header -->
    <div class="page-header">
        <h3>Featured Items</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Featured Items</li>
            </ol>
        </nav>
    </div>
    <!-- end::page header -->

	<div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-head">
                        <a href="{{ route('admin.featured-items.create') }}" class="btn btn-primary btn-sm float-right"><i class="lni-plus mr-2"></i> Add Featured Items</a>
                        <h4 class="card-title">Featured Items</h4>
                    </div>
                    <div class="gaps-1x"></div>
                    <table class="data-table table table-striped">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Target</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($featured_items as $feature)
                            <tr>
                                <td><i class="{{ $feature->icon }}"></i> {{ $feature->title }}</td>
                                <td>{{ $feature->target }}</td>
                                <td>
                                    @if($feature->published)
                                    <form style="display: inline-block;" method="post" action="{{ route('admin.featured-items.update', $feature->id) }}">
                                        {{ csrf_field() }}
                                        {{ method_field('PUT') }}
                                        <input type="hidden" name="toggle" value="1">
                                        <button class="btn btn-warning btn-sm btn-auto">Unpublish</button>
                                    </form>
                                    @else
                                    <form style="display: inline-block;" method="post" action="{{ route('admin.featured-items.update', $feature->id) }}">
                                        {{ csrf_field() }}
                                        {{ method_field('PUT') }}
                                        <input type="hidden" name="toggle" value="1">
                                        <button class="btn btn-success btn-sm btn-auto">Publish</button>
                                    </form>
                                    @endif
                                    @if(! $feature->published)
                                    <form style="display: inline-block;" method="post" action="{{ route('admin.featured-items.destroy', $feature->id) }}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <input type="hidden" name="toggle" value="1">
                                        <button class="btn btn-danger btn-sm btn-auto">Delete</button>
                                    </form>
                                    @endif
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