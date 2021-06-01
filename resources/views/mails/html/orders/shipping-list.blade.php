@extends('layouts.mails')

@section('content')
<div class="invoice">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="image text-center">
          <img src="{{ asset('/logo.jpg') }}" alt="" height="150px;">
        </div>
        <a href="#" class="btn btn-primary float-right no-print" onclick="window.print()"><i class="lni-printer"></i> Print</a>
      </div>
      <div class="col-md-12">
        <div class="content">
          <p><strong>Order Number: </strong> {{ $order->reference }}</p>
          <p><strong>Order Total: </strong> {{ number_format($order->amount) }} <span style="color: red">({{ $order->payment }})</span></p>
        </div>

        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>
                <h5>Cutomer's Information</h5>
                <br>
                <p>Name: <strong>{{ $order->user->name }}</strong></p>
                <p>Phone Number: <strong>{{ $order->user->phone_number }}</strong></p>
                <p>Email: <strong>{{ $order->user->email }}</strong></p>
                <p>Order Placed: <strong>{{ $order->created_at->format('D d M Y') }}</strong></p>
                <p>Order Number: <strong>{{ $order->reference }}</strong></p>
              </td>
              <td>
                <h5>Shipping Address</h5>
                <br>
                <p>Address: <strong>{{ $order->address }}</strong></p>
              </td>
            </tr>
          </tbody>
        </table>

        <br>
        <h5 align="center">Payment Information</h5>
        <h4>Payment Method;</h4>
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td><strong style="color: red">{{ $order->payment }}</strong></td>
              <td>Item{{ $order->items->count() > 1 ? 's' : '' }} subtotal</td>
              <td>KES {{ number_format($order->amount) }}</td>
            </tr>
            <tr>
              <td colspan="2"><strong>Total</strong></td>
              <td><strong>KES {{ number_format($order->amount) }}</strong></td>
            </tr>
          </tbody>
        </table>
        <div style="border-bottom: dotted 2px #404040;"></div>
        <br>
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
        <br>
      </div>
    </div>
  </div>
</div>
@endsection