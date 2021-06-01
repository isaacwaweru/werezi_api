@extends('layouts.dashboard')

@section('content')
    <!-- begin::page header -->
    <div class="page-header">
        <h3>Authors</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.authors.index') }}">Authors</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $author->name }}</li>
            </ol>
        </nav>
    </div>
    <!-- end::page header -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-head">
                        <form action="{{ route('admin.authors.destroy', $author->id) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button class="btn btn-danger btn-sm btn-auto float-right">Delete</button>
                        </form>
                        <a href="{{ route('admin.authors.edit', $author->id) }}" class="btn btn-sm mr-2 btn-info float-right"><i class="lni-pencil mr-2"></i>edit</a>
                        <h4 class="card-title">{{ $author->name}}</h4>
                    </div>
                    <div class="gaps-1x"></div>
                    <div class="card-body">
                      <img src="{{ $author->image() }}" alt="{{ $author->name}}" height="200px">
                      <hr>
                      <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#upload-photos" style="margin-top: 3rem;">Change Image</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Medium -->
<div class="modal fade" id="upload-photos" tabindex="-1">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-body">
            <a href="#" class="modal-close float-right" data-dismiss="modal" aria-label="Close"><em class="lni-close"></em></a>
              <h3 class="popup-title">Change Image</h3>
              <hr>
              <form method="post" action="{{ route('admin.authors.update', $author->id) }}" enctype="multipart/form-data">
                  {{ csrf_field() }}
                  {{ method_field('PUT') }}

                  <div class="form-group">
                      <label>Select Image</label>
                      <input type="file" class="form-control-file" id="other-images" name="image">
                  </div>
                  <div class="gaps-1x"></div>
                  <button class="btn btn-primary">Submit</button>
              </form>
          </div>
      </div><!-- .modal-content -->
  </div><!-- .modal-dialog -->
</div>
<!-- Modal End -->
@endsection