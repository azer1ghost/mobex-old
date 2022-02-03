<html>
<style>
    table {
        border: none !important;
    }
</style>
<body>
<table>
    <tbody>
    <tr>
        <td><b>SHİPPER NAME</b></td>
        <td colspan="2">International Courier System</td>
        <td></td>
        <td><b>AIRWAYBILL</b></td>
        <td>{{ $parcel->awb ?? '-' }}</td>
        <td></td>
        <td><b>RECEIVER NAME</b></td>
        <td>MOBEX EXPRESS</td>
    </tr>
    <tr>
        <td><b>ADDRESS</b></td>
        <td colspan="2">{{ $warehouse->address->address_line_1 ?? 'Pleas add Address' }}</td>
        <td></td>
        <td><b>TOTAL WEIGHT</b></td>
        <td>{{ $parcel->packages->sum('weight') }}</td>
        <td></td>
        <td><b>ADDRESS</b></td>
        <td>JAFAR JABBARLI STR 27.</td>
    </tr>
    <tr>
        <td><b>TELEPHONE</b></td>
        <td colspan="2">+1 (302) 225-9005</td>
        <td></td>
        <td><b>DIMENSIONS</b></td>
        <td>ILL PUT IT IN</td>
        <td></td>
        <td><b>TELEPHONE</b></td>
        <td>994517007557</td>
    </tr>


    <tr>
        <td colspan="11" style="color: #fff"> -</td>
    </tr>
    <tr>
        <td colspan="11" style="color: #fff"> -</td>
    </tr>


    <tr>
        <th><b>№</b></th>
        <th><b>Way bill</b></th>
        <th><b>Invoice CCY</b></th>
        <th><b>PRICE</b></th>
        <th><b>Weight</b></th>
        <th><b>Category</b></th>
        <th><b>Box</b></th>
        <th><b>ItemCount</b></th>
        <th><b>Sender</b></th>
        <th><b>Buyer</b></th>
        <th><b>FIN</b></th>
    </tr>


    @foreach($packages as $key => $package)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $package->custom_id }}</td>
            <td>USD</td>
            <td>${{ $package->shipping_converted_price }}</td>
            <td>{{ $package->weight }}</td>
            <td>{{ ($package->type_id && $package->type ? ($package->type->translate('en') ? ($package->type->translate('en')->name . ($package->other_type ? "(" . $package->other_type .")" : null)) : "-") : ($package->detailed_type ?: '-')) }}</td>
            <td>{{ $parcel->custom_id ?? '-' }}</td>
            <td>{{ $package->number_items }}</td>
            <td>{{ $package->website_name ? getOnlyDomain($package->website_name) : '-' }}</td>
            <td>{{ $package->user ? $package->user->full_name : '-' }}</td>
            <td>{{ $package->user ? $package->user->fin : '-' }}</td>
        </tr>
    @endforeach

    </tbody>
</table>

</body>
</html>