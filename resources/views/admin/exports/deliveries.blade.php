<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Paid</th>
        <th>Packages</th>
        <th>Total</th>
        <th>Your fee</th>
        <th>User</th>
        <th>Phone</th>
        <th>Filial</th>
        <th>Address</th>
        <th>Weight</th>
        <th>At</th>
    </tr>
    </thead>
    <tbody>
    <?php $totalGet = 0; $totalGetFee = 0; ?>
    @foreach($deliveries as $item)
        <?php if (! $item->paid) {
            $totalGet += $item->total_price;
        }
        $totalGetFee += $item->fee;
        ?>
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->paid ? 'Yes' : 'No' }}</td>
            <td>{{ $item->packages->count() }}</td>
            <td>@if(!$item->paid){{ $item->total_price }}₼ @else - @endif</td>
            <td> {{ $item->fee }}₼</td>
            <td>{{ $item->full_name }}</td>
            <td>{{ $item->cleared_phone }}</td>
            <td>{{ $item->filial->name ?? '-' }}</td>
            <td>{{ $item->full_address }}</td>
            <td>{{ $item->packages->sum('weight') }} kg</td>
            <td>{{ $item->created_at->diffForHumans() }}</td>
        </tr>
    @endforeach

    <tr>
        <td colspan="11"></td>
    </tr>
    <tr>
        <td colspan="3">Total</td>
        <td>
            {{ $totalGet }}₼
        </td>
        <td>
            {{ $totalGetFee }}₼
        </td>
    </tr>
    </tbody>
</table>