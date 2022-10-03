<table>
    <thead>
    <tr>
        <th><b>User ID</b></th>
        <th><b>Receiver</b></th>
        <th><b>Phone</b></th>
        <th><b>Email</b></th>
        <th><b>Post Index</b></th>
        <th><b>CWB</b></th>
        <th><b>Reg Number</b></th>
        <th><b>QTY</b></th>
        <th><b>Description</b></th>
        <th><b>Weight (kq)</b></th>
        <th><b>Delivery Price [AZN]</b></th>
        <th><b>Delivery Price [USD]</b></th>
        <th><b>Value</b></th>
        <th><b>Paid By</b></th>
        <th><b>Address</b></th>
    </tr>
    </thead>
    <tbody>
    @foreach($packages as $package)
        <tr>
            <td>{{ $package->user ? $package->user->customer_id : '-' }}</td>
            <td>{{ $package->user ? $package->user->full_name : '-' }}</td>
            <td>{{ $package->user ? $package->user->cleared_phone : '-' }}</td>
            <td>{{ $package->user ? $package->user->email : '-' }}</td>
            <td>{{ $package->user ? $package->zip_code : '-' }}</td>
            {{--<td>{{ $package->user ? ($package->user->phone ? \App\Models\Extra\SMS::clearNumber($package->user->phone) : '-' ) : '-' }}</td>--}}
            <td>{{ $package->custom_id }}</td>
            <td>{{ $package->reg_number }}</td>
            <td>{{ $package->number_items }}</td>
            <td>{{ ($package->type_id && $package->type ? ($package->type->translate('en') ? ($package->type->translate('en')->name . ($package->other_type ? "(" . $package->other_type .")" : null)) : "-") : ($package->detailed_type ?: '-')) }}</td>
            <td>{{ $package->weight }}</td>
            <td>{{ $package->delivery_manat_price }}</td>
            <td>{{ $package->delivery_price }}</td>
            <td>{{ $package->total_price_with_label }}</td>
            <td>{{ $package->transaction ? $package->transaction->paid_by : '-' }}</td>
            <td>{{ $package->user ? $package->user->address : '-' }}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="15"></td>
    </tr>
    <tr>
        <td colspan="15"></td>
    </tr>
    <tr>
        <td colspan="5"></td>
        <td>Tarix</td>
        <td>{{ Carbon\Carbon::today()->format("Y.m.d") }}</td>
    </tr>
    <tr>

        <td colspan="13">AD Soyad</td>
        <td colspan="13">{{ str_repeat("_", 12) }}</td>
    </tr>
    <tr>
        <td colspan="13">İmza</td>
        <td colspan="13">{{ str_repeat("_", 12) }}</td>
    </tr>

    </tbody>
</table>