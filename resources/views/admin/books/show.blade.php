@extends('layouts.dashboard')

@section('content')

<!-- begin::page header -->
<div class="page-header">
  <form action="{{ route('admin.books.destroy', $book->id) }}">
    @csrf
    @method('DELETE')
    <button class="btn btn-sm btn-danger float-right"><i class="lni-pencil mr-2"></i>Delete</button>
  </form>
  <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-sm btn-warning float-right mr-2"><i class="lni-trash mr-2"></i>Edit</a>
    <h3>Books</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.books.index') }}">Books</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $book->name }}</li>
        </ol>
    </nav>
</div>
<!-- end::page header -->

<div class="card">
  <div class="card-body">
    <h4 class="card-title">{{ $book->name }} ({{ $book->availableCopies()->count() }} cop{{ $book->availableCopies()->count() == 1 ? 'y' : 'ies' }})</h4>
    @if($book->availableCopies()->count() == 0)
    <div class="alert alert-warning alert-with-border">Add some copies to start selling.</div>
    @endif
    <div class="row">
      <div class="col-md-4">
        @if($book->main())
        <div class="text-center">
          <img src="{{ $book->main()->image() }}" alt="{{ $book->name }}" height="400px">
        </div>
        @else
        <img src="/logo.png" alt="logo" width="400px">
        @endif
      </div>
      <div class="col-md-8">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td width="20%">Name</td>
              <td>{{ $book->name }}</td>
            </tr>
            <tr>
              <td width="20%">ISBN</td>
              <td>{{ $book->isbn }}</td>
            </tr>
            <tr>
              <td>Category</td>
              <td><a href="{{ route('admin.categories.show', $book->category_id) }}">{{ $book->category->name }}</a></td>
            </tr>
            <tr>
              <td>Author</td>
              <td><a href="{{ route('admin.authors.show', $book->author_id) }}">{{ $book->author->name }}</a></td>
            </tr>
            <tr>
              <td>Publisher</td>
              <td><a href="{{ route('admin.publishers.show', $book->publisher_id) }}">{{ $book->publisher->name }}</a></td>
            </tr>
            <tr>
              <td width="20%">Length</td>
              <td>{{ number_format($book->length) }} Pages</td>
            </tr>
            <tr>
              <td width="20%">Date pf publishing</td>
              <td>{{ $book->date->format('d M Y') }}</td>
            </tr>
          </tbody>
        </table>
        <a href="#" class="btn btn-success mt-2">View Sales History</a>
      </div>
      <div class="col-md-12 my-5">
        <div class="card">
          <div class="card-body">
            <a href="#" class="btn btn-primary btn-sm float-right"  data-toggle="modal" data-target="#add-copies">Add Copy</a>
            <h4 class="mb-3">Book Copies</h4>
            <table class="table table-striped data-table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Type</th>
                  <th>Seller</th>
                  <th>Price <sub>KES</sub></th>
                  <th>Quantity Available</th>
                  <th>Added Date</th>
                  <th>Status</th>
                  <th colspan="2">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($book->availableCopies() as $copy)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $copy->type }}</td>
                  <td><a href="{{ route('admin.sellers.show', $copy->seller_id) }}">{{ $copy->seller->name }}</a></td>
                  <td>{{ number_format($copy->price) }}</td>
                  <td>{{ number_format($copy->remainder) }}</td>
                  <td>{{ $copy->created_at->format('h:i a d M Y') }}</td>
                  <td>{{ $copy->status }}</td>
                  <td width="5%">
                    @if($copy->id != $book->main_copy_id)
                    <form action="{{ route('admin.books.make-main-copy') }}" method="post">
                      @csrf 
                      <input type="hidden" name="copy_id" value="{{ $copy->id }}">
                      <input type="hidden" name="book_id" value="{{ $book->id }}">
                      <button class="btn btn-info btn-sm mx-2">Make Main</button>
                    </form>
                    @endif
                  </td>
                  <td width="5%">
                    <form action="{{ route('admin.books.delete-copy') }}" method="post">
                      @csrf 
                      <input type="hidden" name="copy_id" value="{{ $copy->id }}">
                      <input type="hidden" name="book_id" value="{{ $book->id }}">
                      <button class="btn btn-danger btn-sm mx-2"><i class="lni-trash mr-2"></i>Stop Selling</button>
                    </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <h4>Excerpt</h4>
        {!! $book->excerpt !!}
      </div>
      <div class="col-md-12 mt-3">
        <h4>Synopsis</h4>
        {!! $book->synopsis !!}
      </div>
    </div>
  </div>
</div>

{{-- Add Copies --}}
<div class="modal fade" id="add-copies" tabindex="-1">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-body">
              <a href="#" class="modal-close float-right" data-dismiss="modal" aria-label="Close"><em class="lni-close"></em></a>
              <h3 class="popup-title">Add Copy</h3>
              <hr>
              <form method="post" action="{{ route('admin.books.add-copy') }}" enctype="multipart/form-data">
                  {{ csrf_field() }}
                  <input type="hidden" value="{{ $book->id }}" name="book_id">
                  <div class="form-group">
                      <label>Type</label>
                      <select name="type" class="form-control">
                        @foreach(\App\Models\BookCopy::TYPES as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                        @endforeach
                      </select>
                  </div>
                  <div class="form-group">
                      <label>Price</label>
                      <input type="text" placeholder="Price" name="price" class="form-control" required>
                  </div>
                  <div class="form-group">
                      <label>Image</label>
                      <input type="file" placeholder="Image" name="image" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" placeholder="Quantity" name="quantity" class="form-control" required>
                </div>
                  <div class="form-group">
                    <label>Condition</label>
                    <select name="condition" class="form-control">
                      @foreach(\App\Models\BookCopy::CONDITIONS as $condition)
                      <option value="{{ $condition }}">{{ $condition }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Seller</label>
                    <select name="seller_id" required class="form-control">
                      @foreach($sellers as $seller)
                      <option value="{{ $seller->id }}">{{ $seller->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="gaps-1x"></div>
                  <button class="btn btn-primary">Submit</button>
              </form>
          </div>
      </div><!-- .modal-content -->
  </div><!-- .modal-dialog -->
</div>
@endsection
