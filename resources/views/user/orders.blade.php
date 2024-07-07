@extends('user.dashboard')

@section('user_content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="section-title position-relative text-uppercase mb-4">
                <span class="bg-secondary pr-3">Order History</span>
            </h2>
            <div class="bg-light p-4 mb-4">
                <div class="table-responsive mb-3">
                    <table id="ordersTable" class="table table-borderless table-hover text-center mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Subtotal</th>
                                <th>Shipping</th>
                                <th>Discount</th>
                                <th>Total</th>
                                <th>Payment Method</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                            @forelse ($orders as $order)
                            <tr>
                                <td>{{ $order->name }} {{ $order->surname }}</td>
                                <td>{{ $order->email }}</td>
                                <td>{{ $order->phone }}</td>
                                <td>
                                    {{ $order->house_number }}, {{ $order->street_name }},<br>
                                    {{ $order->town }}, {{ $order->postcode }}
                                </td>
                                <td>{{ number_format($order->subtotal_amount, 2) }}</td>
                                <td>{{ number_format($order->shipping_amount, 2) }}</td>
                                <td>{{ number_format($order->discount_amount, 2) }}</td>
                                <td>{{ number_format($order->net_amount, 2) }}</td>
                                <td>{{ ucfirst($order->payment_method) }}</td>
                                <td>
                                @if($order->status == 1)
                                    Pending
                                @elseif($order->status == 2)
                                        Processing
                                @elseif($order->status == 3)
                                    Packed
                                @elseif($order->status == 4)
                                    Shipped
                                @elseif($order->status == 5)
                                    Delivered
                                @elseif($order->status == 6)
                                    Returned
                                @elseif($order->status == 7)
                                    Cancelled
                                @else
                                    Unknown
                                @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="11">No orders found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

<script>
    $(document).ready(function() {
        $('#ordersTable').DataTable({
            "order": []
        });
    });
</script>

@endsection


