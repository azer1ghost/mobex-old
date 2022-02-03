<table style="width: 1400px">
    <thead>
    <tr>
        <th><b>Operator</b></th>
        <th><b>Card</b></th>
        <th><b>Member</b></th>
        <th><b>Order ID</b></th>
        <th><b>Response</b></th>
        <th><b>Date</b></th>
        <th><b>Price</b></th>
        <th><b>Fee</b></th>
        <th><b>Total</b></th>
        <th><b>Admin paid</b></th>
    </tr>
    </thead>
    <tbody>
    <?php $total = 0; ?>
    @foreach($orders as $order)
        <tr>
            <td>{{ $order->admin->name ?? '-' }}</td>
            <td>{{ $order->card->hidden_number ?? 'Unknown' }}</td>
            <td>{{ $order->user->full_name ?? '-' }}</td>
            <td>#{{ $order->id }}</td>
            <td>{{ $order->response }}</td>
            <td>{{ $order->updated_at }}</td>
            <td>{{ $order->price }} TL</td>
            <td>{{ $order->service_fee }} TL</td>
            <td>{{ $order->total_price }} TL</td>
            <td>{{ $order->admin_paid }} TL</td>
        </tr>
    @endforeach

    <tr>
        <td colspan="10">{{ str_repeat("_", 164) }}</td>
    </tr>
    <tr>
        <td colspan="10">{{ str_repeat("_", 164) }}</td>
    </tr>
    <tr>
        <td>Card</td>
        <td>Count</td>
        <td>Total Paid</td>
        <td>Total Service fee</td>
        <td>Total Admin Paid</td>
        <td colspan="5"></td>
    </tr>

    @foreach($cards as $key => $card)
        <tr>
            <td>{{ $key }}</td>
            <td>{{ $card['count'] }} Orders</td>
            <td>{{ $card['total'] }} TL</td>
            <td>{{ $card['fee'] }} TL</td>
            <td>{{ $card['admin_paid'] }} TL</td>
            <td colspan="5"></td>
        </tr>
    @endforeach
    <tr>
        <td colspan="10">{{ str_repeat("      .      .", 41) }}</td>
    </tr>
    <tr>
        <td colspan="10">{{ str_repeat("      .      .", 41) }}</td>
    </tr>
    <tr>
        <td colspan="5"></td>
        <td>Date</td>
        <td>{{ Carbon\Carbon::today()->format("Y.m.d") }}</td>
    </tr>
    <tr>

        <td>Name</td>
        <td>{{ str_repeat("_", 12) }}</td>
    </tr>
    <tr>
        <td>Signature</td>
        <td>{{ str_repeat("_", 12) }}</td>
    </tr>
    </tbody>
</table>