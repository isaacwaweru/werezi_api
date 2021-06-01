@extends('layouts.mails')

@section('content')
<div class="invoice">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="text-center">
          <img src="{{ asset('/logo.jpg') }}" alt="" height="150px">
        </div>
        <a href="#" class="btn btn-primary no-print float-right" onclick="window.print()"><i class="lni-printer mr-2"></i> Print</a>
      </div>
      <div class="col-md-12">
        <div class="content">
            <h4>Customer Details</h4>
            <p>Name: <strong>{{ $order->name }}</strong></p>
            <p>Address: <strong>{{ $order->address }}</strong></p>
            <hr>
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <td>Order Date</td>
                  <td>{{ $order->created_at->format('D d M Y') }}</td>
                </tr>
                <tr>
                  <td>Order Number</td>
                  <td>{{ $order->reference }}</td>
                </tr>
                <tr>
                  <td>Payment Method</td>
                  <td>{{ $order->payment }}</td>
                </tr>
                <tr>
                  <td>Order Amount</td>
                  <td><small>KES </small>{{ number_format($order->amount) }}</td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <th>Payable Amount</th>
                  <th>{{ number_format($order->amount + $order->delivery_fee) }}</th>
                </tr>
              </tfoot>
            </table>
            <hr>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Product</th>
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
        </div>
      </div>
    </div>
  </div>
</div>
@endsection