@extends('layouts.mails')

@section('content')
<div class="order-received">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="image text-center">
          <img src="{{ asset('/logo.jpg') }}" alt="" height="150px">
        </div>
      </div>
      <div class="col-md-12">
        <div class="content">
          <h4>Dear {{ $order->user->name }}</h4>
          <p>Your order {{ $order->reference }} has been successfully confirmed.</p>
          <p>It will be packaged and shipped as soon as possible. Once this happens you will receive a shipping notification email with tracking information.</p>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Recipient Details</th>
                <th>Shipping Address</th>
              </tr>
            </thead>
            <tr>
              <td>
                <p>Name: <strong>{{ $order->shippingDetails->name }}</strong></p>
                <p>Phone: <strong>{{ $order->shippingDetails->phone_number }}</strong></p>
                <p>Email: <strong>{{ $order->user->email }}</strong></p>
              </td>
              <td>
                <p>Region: <strong>{{ $order->shippingDetails->region->name }}</strong></p>
                <p>City: <strong>{{ $order->shippingDetails->city }}</strong></p>
                <p>Address: <strong>{{ $order->shippingDetails->address }}</strong></p>
              </td>
            </tr>
          </table>
          <hr>
          <h5>Your Order Details</h5>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th></th>
                <th>Item</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              @foreach($order->items as $item)
              <tr>
                <td><img src="{{ $item->product->mainImageUrl() }}" alt="{{ $item->id }}" height="100px;"></td>
                <td>{{ $item->product->name }}</td>
                <td>{{ number_format($item->price) }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->total) }}</td>
              </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <td colspan="3" align="right">
                  <p>Total</p>
                  <p>Shipping Cost</p>
                  <p>Discount</p>
                  <p>Total</p>
                  <p>Payment Method</p>
                </td>
                <td colspan="2" align="right">
                  <p><strong>{{ number_format($order->items->sum('total')) }}</strong></p>
                  <p><strong>{{ number_format($order->delivery_fee) }}</strong></p>
                  <p><strong>0</strong></p>
                  <p><strong>{{ number_format($order->items->sum('total') + $order->delivery_fee) }}</strong></p>
                  <p><strong>Cash On Delivery</strong></p>
                </td>
              </tr>
            </tfoot>
          </table>
          <table class="table table-bordered">
            <tfoot>
              <tr>
                <td colspan="5">
                  <p>{{ env('APP_NAME') }} offers safe and convenient payment for all products. You can pay conveniently online or at the point of delivery using your credit or debit card, MPESA or using other payment methods.
                  <p>{{ env('APP_NAME') }} also provides you a 14-day guarantee on certain eligible products. Check return policy and warranty conditions tabs on the product page.</p>
                </td>
              </tr>
              <tr>
                <td colspan="5">
                  <p>Happy Shopping!</p>
                  <p>Warm Regards</p>
                  <p>{{ env('APP_NAME') }} Sales Team</p>
                  <ul>
                    <li>Get in touch with us on Call or WhatsApp via 0705 272 685</li>
                    <li>We provide 24/7 support to our customers.</li>
                  </ul>
                </td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection