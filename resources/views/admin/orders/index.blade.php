@extends('layouts.dashboard')

@section('content')
    <!-- begin::page header -->
    <div class="page-header">
        <h3>Orders</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Orders</li>
            </ol>
        </nav>
    </div>
    <!-- end::page header -->
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link {{ !in_array(request('status'), ['pending', 'shipped','complete']) ? 'active' : '' }}"
               href="{{ url('admin/orders') }}">Orders</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}"
               href="{{ url("admin/orders?status=pending") }}">Pending</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('status') == 'shipped' ? 'active' : '' }}"
               href="{{ url("admin/orders?status=shipped") }}">Shipped</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('status') == 'complete' ? 'active' : '' }}"
               href="{{ url("admin/orders?status=complete") }}">Complete</a>
        </li>
    </ul>

    <div class="p-4 bg-white border-right border-left border-bottom">

        <div class="float-right">
            <select id="show" onchange="filterOrders()">
                <option value="">--Show--</option>
                @foreach([10, 20, 50, 100, 200] as $i)
                    <option @if(request('show')==$i) selected @endif>{{ $i }}</option>
                @endforeach
            </select>
            <select id="order" onchange="filterOrders()">
                <option value="">--Order by--</option>
                @foreach(['date', 'status', 'customer', 'amount'] as $i)
                    <option @if(request('order')==$i) selected @endif>{{ $i }}</option>
                @endforeach
            </select>
            <select id="direction" class="filter-orders" onchange="filterOrders()">
                <option value="asc" @if(request('direction')=='asc') selected @endif>Ascending</option>
                <option value="desc" @if(request('direction')=='desc') selected @endif>Descending</option>
            </select>
            <select id="status" class="filter-orders" onchange="filterOrders()">
                <option value="">--All--</option>
                @foreach(\App\Models\Order::STATUS as $k => $v)
                    <option @if(request('status')==$k) selected @endif value="{{ $k }}">{{ ucfirst($v) }}</option>
                @endforeach
            </select>
        </div>

        <h4 class="font-weight-bold">Orders</h4>

        <table class="table table-bordered table-sm">
            <thead class="bg-light">
            <tr>
                <th>Date</th>
                <th>Order No</th>
                <th>Items</th>
                <th>Customer</th>
                <th>Phone</th>
                <th>Status</th>
                <th class="text-right">Amount (KES)</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @if($orders->count() == 0)
                <tr>
                    <td colspan="6" class="text-danger">
                        No order results found
                    </td>
                </tr>
            @endif

            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->created_at->format('M d, H:i A') }}</td>
                    <td>{{ $order->reference }}</td>
                    <td>{{ $order->items->count() }}</td>
                    <td>{{ $order->name ?? '-:-' }}</td>
                    <td>{{ $order->phone_number ?? '-:-' }}</td>
                    <td>{{ $order->status }}</td>
                    <td class="text-right">{{ number_format($order->amount) }}</td>
                    <td class="tnx-type text-right">
                        <a href="{{ route('admin.orders.show', $order->id) }}"><span
                                class="btn btn-info btn-sm">View</span></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th colspan="6">TOTAL</th>
                <th class="text-right bg-light">{{ number_format($orders->sum('amount')) }}</th>
                <th class="bg-light"></th>
            </tr>
            </tfoot>
        </table>

        <a href="{{ request()->fullUrlWithQuery(['csv' => true]) }}" class="btn btn-secondary">Download Excel</a>
    </div>
@endsection

@section('scripts')
    <script>
        function filterOrders() {
            // How many results
            let _show = document.getElementById('show');
            let show = _show.options[_show.selectedIndex].value;

            // Order by
            let _order = document.getElementById('order');
            let order = _order.options[_order.selectedIndex].value;

            // Order direction
            let _direction = document.getElementById('direction');
            let direction = _direction.options[_direction.selectedIndex].value;

            // Order status
            let _status = document.getElementById('status');
            let status = _status.options[_status.selectedIndex].value;

            let params = '?show=' + show + '&order=' + order + '&direction=' + direction + '&status=' + status;
            window.location.href = domain + '/admin/orders/' + params;
        }
    </script>
@endsection
