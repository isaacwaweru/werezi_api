@extends('layouts.dashboard')

@section('content')
    <!-- begin::page header -->
    <div class="page-header">
        <h3>Home Page Slider</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Home Page Slider</li>
            </ol>
        </nav>
    </div>
    <!-- end::page header -->

	<div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-head">
                        <a href="{{ route('admin.home-page-slides.create') }}" class="btn btn-primary btn-sm float-right"><i class="lni-plus mr-2"></i> Add Slide</a>
                        <h4 class="card-title">Home Slider Settings</h4>
                    </div>
                    <div class="gaps-1x"></div>
                    <table class="data-table table table-striped">
                        <thead>
                            <tr class="data-item data-head">
                                <th class="data-col dt-name">Name</th>
                                <th class="data-col dt-category">Image</th>
                                <th class="data-col dt-brand">Target</th>
                                <th class="data-col dt-amount">Status</th>
                                <th class="data-col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($slides as $slide)
                            <tr>
                                <td>{{ $slide->name }}</td>
                                <td>
                                    <img height="100px" src="{{ $slide->url() }}" alt="{{ $slide->name }}">
                                </td>
                                <td>{{ $slide->target }}</td>
                                <td>{{ $slide->published ? 'published' : 'not published' }}</td>
                                <td>
                                    @if($slide->published)
                                    <form style="display: inline-block;" method="post" action="{{ route('admin.home-page-slides.update', $slide->id) }}">
                                        {{ csrf_field() }}
                                        {{ method_field('PUT') }}
                                        <input type="hidden" name="toggle" value="1">
                                        <button class="btn btn-warning btn-sm btn-sm">Unpublish</button>
                                    </form>
                                    @else
                                    <form style="display: inline-block;" method="post" action="{{ route('admin.home-page-slides.update', $slide->id) }}">
                                        {{ csrf_field() }}
                                        {{ method_field('PUT') }}
                                        <input type="hidden" name="toggle" value="1">
                                        <button class="btn btn-success btn-sm btn-sm">Publish</button>
                                    </form>
                                    @endif
                                    @if(! $slide->published)
                                    <form style="display: inline-block;" method="post" action="{{ route('admin.home-page-slides.destroy', $slide->id) }}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <input type="hidden" name="toggle" value="1">
                                        <button class="btn btn-danger btn-sm btn-sm">Delete</button>
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