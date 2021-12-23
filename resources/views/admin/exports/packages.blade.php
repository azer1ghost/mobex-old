<table>
    <thead>
    <tr>
        <th><b>User ID</b></th>
        <th><b>Receiver</b></th>
        <th><b>Phone</b></th>
        <th><b>Email</b></th>
        <th><b>Filial</b></th>
        <th><b>CWB</b></th>
        <th><b>Reg Number</b></th>
        <th><b>QTY</b></th>
        <th><b>Description</b></th>
        <th><b>Weight (kq)</b></th>
        <th><b>Delivery Price [AZN]</b></th>
        <th><b>Delivery Price [USD]</b></th>
        <th><b>Value</b></th>
        <th><b>Paid By</b></th>
    </tr>
    </thead>
    <tbody>
    @foreach($packages as $package)
        <tr>
            <td>{{ $package->user ? $package->user->customer_id : '-' }}</td>
            <td>{{ $package->user ? $package->user->full_name : '-' }}</td>
            <td>{{ $package->user ? $package->user->cleared_phone : '-' }}</td>
            <td>{{ $package->user ? $package->user->email : '-' }}</td>
            <td>{{ $package->user ? $package->user->filial_name : '-' }}</td>
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
        </tr>
    @endforeach
    </tbody>
</table>