<table align="center">
    <tbody>
    <tr>
        <td colspan="8"></td>
    </tr>
    <tr>
        <td colspan="8"></td>
    </tr>

    <tr>
        <td></td>
        <td><b>Shipper</b></td>
        <td colspan="2">{{ $warehouse->company_name }}</td>
        <td><b>Receiver</b></td>
        <td colspan="3">{{ env('APP_NAME') }} AFRIKA HIZLI CARGO AS</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td colspan="2">{{ $warehouse->address->address_line_1 }}</td>
        <td></td>
        <td colspan="3">25 UZEIR HAJIBEYOV STR</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td colspan="2">{{ $warehouse->address->city }} {{ $warehouse->address->state }}, {{ $warehouse->address->zip_code }}</td>
        <td></td>
        <td colspan="3">BAKU, AZERBAIJAN</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td colspan="2">{{ $warehouse->country->name }}</td>
        <td></td>
        <td colspan="3">TEL: 994124973775</td>
    </tr>
    <tr>
        <td colspan="8"></td>
    </tr>
    </tbody>
</table>


<table>
    <thead>
    <tr>
        <th></th>
        <th><b>CWB</b></th>
        <th><b>QTY</b></th>
        <th><b>Description</b></th>
        <th><b>Weight (kg)</b></th>
        <th><b>Value ({{ $warehouse->currency_with_label }})</b></th>
    </tr>
    </thead>
    <tbody>
    @foreach($packages as $key => $package)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $package->custom_id }}</td>
            <td>{{ $package->number_items }}</td>
            <td>{{ ($package->type ? ($package->type->translate('en') ? ($package->type->translate('en')->name . ($package->other_type ? "(" . $package->other_type .")" : null)) : "-") : '-') }}</td>
            <td>{{ $package->weight }}</td>
            <td>{{ $package->shipping_amount }}</td>
        </tr>
    @endforeach
    </tbody>
</table>