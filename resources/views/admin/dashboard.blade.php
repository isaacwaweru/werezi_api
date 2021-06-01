@extends('layouts.dashboard') 

@section('content')
<!-- begin::page header -->
<div class="page-header">
    <h3>Dashboard</h3>
</div>
<!-- end::page header -->

<div class="row dashboard-statistics mb-4">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase font-size-11 m-b-15">Books</h6>
                        <h4 class="m-b-0">
                            {{ $stats['books'] }}
                        </h4>
                    </div>
                    <div class="icon text-success">
                        <i class="lni-package"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase font-size-11 m-b-15">Authors</h6>
                        <h4 class="m-b-0">
                            {{ $stats['authors'] }}
                        </h4>
                    </div>
                    <div class="icon text-info">
                        <i class="lni-protection"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase font-size-11 m-b-15">Categories</h6>
                        <h4 class="m-b-0">
                            {{ $stats['categories'] }}
                        </h4>
                    </div>
                    <div class="icon text-warning">
                        <i class="lni-briefcase"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase font-size-11 m-b-15">Sellers</h6>
                        <h4 class="m-b-0">
                            {{ $stats['sellers'] }}
                        </h4>
                    </div>
                    <div class="icon text-danger">
                        <i class="lni-layers"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <a
                    href="{{ route('admin.orders.index') }}"
                    class="btn btn-info btn-sm float-right"
                    >View All
                    <em class="lni-chevron-right ml-2"></em
                ></a>
                <h4 class="card-title">New Orders</h4>
            </div>
            <div class="card-body">
                <table class="table tnx-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Order Number</th>
                            <th>Customer</th>
                            <th>Amount KES</th>
                            <th></th>
                        </tr>
                        <!-- tr -->
                    </thead>
                    <!-- thead -->
                    <tbody>
                        @foreach($current_orders as $order)
                        <tr>
                            <td>{{ $order->created_at->format('Y m d h:ia') }}</td>
                            <td>{{ $order->reference }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ number_format($order->amount) }}</td>
                            <td class="tnx-type">
                                <a
                                    href="{{ route('admin.orders.show', $order->id) }}"
                                    ><span
                                        class="tnx-type-md badge badge-outline badge-success badge-md"
                                        >View</span
                                    ></a
                                >
                            </td>
                        </tr>
                        <!-- tr -->
                        @endforeach
                    </tbody>
                    <!-- tbody -->
                </table>
                <!-- .table -->
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase font-size-11 m-b-15">Number of Orders Today</h6>
                        <h4 class="m-b-0">
                            {{ $stats['orders'] }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase font-size-11 m-b-15">Total Amount in Orders Today</h6>
                        <h4 class="m-b-0">
                            <small>KES </small>{{ number_format($stats['orders_total']) }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
