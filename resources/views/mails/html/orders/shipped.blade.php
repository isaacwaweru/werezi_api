@extends('layouts.mails')

@section('content')
<div class="order-shipped">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="image text-center" style="text-align: center">
          <img src="{{ asset('/logo.jpg') }}" alt="" height="150px">
        </div>
      </div>
      <div class="col-md-12">
        <div class="content">
          <h5>Dear {{ $order->user->name }},</h5>
          <p>We have just shipped the item{{ $order->items->count() > 0 ? 's' : '' }} below from your order {{ $order->reference }}</p>
          <p>The package will be delivered at the address provided.</p>
          <p>Once your package arrives, we will give you a call or contact you via SMS on your provided number {{ $order->shippingDetails->phone_number }}</p>
          <p>Note: </p>
          <ul>
            <li>For pay on delivery, we only accept payments via MPESA to our paybill number. We do not collect cash unless it is within our Nairobi CBD pick up stations.</li>
          </ul>
          <hr>
          <table class="table table-bordered" style="width: 100%">
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
                @foreach($order->products() as $item)
                <tr>
                  <td><img src="{{ $item['image'] }}" alt="{{ $item->id }}" height="100px;"></td>
                  <td>{{ $item['name'] }}</td>
                  <td>{{ number_format($item['price']) }}</td>
                  <td>{{ $item['quantity'] }}</td>
                  <td>{{ number_format($item['total']) }}</td>
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
              <tbody>
                <tr>
                  <td>
                    <p>{{ env('APP_NAME') }} offers safe and convenient payment for all products. You can pay conveniently online or at the point of delivery using your credit or debit card, MPESA or using other payment methods.</p>
                  </td>
                </tr>
                <tr>
                  <td>
                    <p>{{ env('APP_NAME') }} also provides you a 14-day guarantee on certain eligible products. Check return policy and warranty conditions tabs on the product page.</p>
                  </td>
                </tr>
                <tr>
                  <td>
                    <p>Happy Shopping!</p>
                    <p>Warm Regards</p>
                    <p>{{ env('APP_NAME') }} Sales Team</p>
                    <ul>
                      <li>Get in touch with us on Call or WhatsApp via (+254) 702 654 848</li>
                      <li>We provide 24/7 support to our customers.</li>
                    </ul>
                  </td>
                </tr>
              </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection