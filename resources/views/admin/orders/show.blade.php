@extends('layouts.dashboard')

@section('content')
    <!-- begin::page header -->
    <div class="page-header">
        <h3>Orders</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $order->number }}</li>
            </ol>
        </nav>
    </div>
    <!-- end::page header -->

	<div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-head">
                        <h4 class="card-title">Order #{{ $order->reference }} <small><span class="badge badge-info">{{ $order->status }}</span></small></h4>
                    </div>
                    <div class="gaps-1x"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Customer Information</h5>
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>Name</td>
                                                <td>{{ $order->user->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Email</td>
                                                <td>{{ $order->user->email }}</td>
                                            </tr>
                                            <tr>
                                                <td>Phone Number</td>
                                                <td>{{ $order->user->phone_number }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button class="btn btn-success btn-block my-3">{{ $order->created_at->format('D d M Y') }}</button>
                                    <br>
                                    <button class="btn btn-info btn-block">{{ $order->status }}</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Shipping Information</h5>
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>Name</td>
                                                <td>{{ $order->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Phone Number</td>
                                                <td>{{ $order->phone_number }}</td>
                                            </tr>
                                            <tr>
                                                <td>Address</td>
                                                <td>{{ $order->address }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <h4>Items</h4>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th colspan="2">Item</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->items as $item)
                                        <tr>
                                            <td><img src="{{ $item->book->image() }}" height="100px;"></td>
                                            <td><h5>{{ $item->book->name }}</h5></td>
                                            <td>{{ number_format($item->price) }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ number_format($item->total) }}</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="4" align="right">Total</td>
                                            <td><strong>KES {{ number_format($order->delivery_fee + $order->items->sum('total')) }}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Actions</h4>
                            <hr>
                            <p>Current Order status is <span class="badge badge-info">{{ $order->status }}</span></p>

                            @if($order->status == 'pending')
                            <form action="{{ route('admin.orders.update', $order->id) }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="">Process Order</label>
                                    <select name="status" class="form-control">
                                        <option value="confirmed">Confirm Order</option>
                                        <option value="cancelled">Cancell Order</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary">Save</button>
                                </div>
                            </form>
                            @endif

                            @if($order->status == 'confirmed')
                            <form action="{{ route('admin.orders.update', $order->id) }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <button class="btn btn-primary">Mark as packaged</button>
                                </div>
                            </form>
                            @endif

                            @if($order->status == 'packaged')
                            <h5>Packed Items</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                    <th>#</th>
                                    <th>Book</th>
                                    <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->sold() as $item)
                                    <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item['name'] }}</td>
                                    <td>{{ number_format($item['price']) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <hr>
                            <a href="{{ route('admin.orders.invoice', $order->id) }}" class="btn btn-primary" target="_blank">Generate Invoice</a>
                            <a href="{{ route('admin.orders.shipping-list', $order->id) }}" class="btn btn-primary" target="_blank">Generate Shipping List</a>
                            <hr>
                            <form action="{{ route('admin.orders.update', $order->id) }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="">Process Order</label>
                                    <select name="status" class="form-control">
                                        <option value="shipping">Ship Order</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary">Save</button>
                                </div>
                            </form>
                            @endif

                            @if($order->status == 'shipped')
                            <form action="{{ route('admin.orders.update', $order->id) }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="">Process Order</label>
                                    <select name="status" class="form-control">
                                        <option value="complete">Mark Order as Completed</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary">Save</button>
                                </div>
                            </form>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection