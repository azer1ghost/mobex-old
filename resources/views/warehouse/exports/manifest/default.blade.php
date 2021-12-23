<html>
<style>
    table {
        border: none !important;
    }
</style>
<body>
<table style="width: 1200px">
    <tbody>
    <tr>
        <td colspan="{{ $span }}" style="color: #fff">-</td>
    </tr>
    <tr>
        <td colspan="{{ $span }}" style="color: #fff">-</td>
    </tr>

    <tr>
        <td><b>Shipper</b></td>
        <td colspan="{{ $span - 6 }}">{{ $warehouse->company_name }}</td>
        <td><b>Receiver</b></td>
        <td colspan="4">{{ env('APP_NAME') }} CARGO AS</td>
    </tr>
    <tr>
        <td style="color: #fff">-</td>
        <td colspan="{{ $span - 6 }}">{{ $warehouse->address->address_line_1 or 'Pleas add Address' }}</td>
        <td style="color: #fff">-</td>
        <td colspan="4">JAFAR JABBARLI STR 27.</td>
    </tr>
    <tr>
        <td style="color: #fff">-</td>
        <td colspan="{{ $span - 6 }}">@if($warehouse->address) {{ $warehouse->address->city }} {{ $warehouse->address->state }} , {{ $warehouse->address->zip_code }} @else Please Add Address @endif
            </td>
        <td style="color: #fff">-</td>
        <td colspan="4">BAKU, AZERBAIJAN</td>
    </tr>
    <tr>
        <td style="color: #fff">-</td>
        <td colspan="{{ $span - 6 }}">{{ isset($warehouse->country->translate('en')->name) ? $warehouse->country->translate('en')->name : $warehouse->country->name }}</td>
        <td style="color: #fff">-</td>
        <td colspan="4">TEL: 994517007557</td>
    </tr>

    <tr>
        <td colspan="{{ $span }}" style="color: #fff"> -</td>
    </tr>
    <tr>
        <td colspan="{{ $span }}" style="color: #fff"> -</td>
    </tr>


    <tr>
        <th style="color: #fff">-</th>
        <th><b>SENDER</b></th>
        <th><b>BUYER</b></th>
        @if($ext == 'Xlsx')
            <th><b>FIN</b></th>
        @endif
        <th><b>ID CODE</b></th>
        <th><b>ADDRESS</b></th>
        <th><b>ITEM CODE</b></th>
        <th><b>ITEM DESCRIPTION</b></th>
        <th><b>QTY</b></th>
        <th><b>PRICE ({{ $warehouse->currency_with_label }})</b></th>
        <th><b>WEIGHT (kg)</b></th>
    </tr>


    @foreach($packages as $key => $package)
        <tr>
            <td>{{ $key + 1 }} <span>         </span></td>
            <td><span>         </span> {{ $package->website_name ? getOnlyDomain($package->website_name) : '-' }}</td>
            <td>{{ $package->user ? $package->user->full_name : '-' }}</td>
            @if($ext == 'Xlsx')
                <td>{{ $package->user ? $package->user->fin : '-' }}</td>
            @endif
            <td>{{ $package->user ? str_replace(env('MEMBER_PREFIX_CODE'), "", $package->user->customer_id) : '-' }} <span>         </span>
            </td>
            <td><span>         </span> {{ $package->user ? $package->user->address : '-' }}</td>
            <td>{{ $package->custom_id or '-' }} <span>         </span></td>
            <td> <span>         </span>{{ ($package->type_id && $package->type ? ($package->type->translate('en') ? ($package->type->translate('en')->name . ($package->other_type ? "(" . $package->other_type .")" : null)) : "-") : ($package->detailed_type ?: '-')) }}</td>
            <td>{{ $package->number_items }}</td>
            <td>{{ specialPrice($package->shipping_amount) }}</td>
            <td>{{ specialPrice($package->weight) }}</td>
        </tr>
    @endforeach

    </tbody>
</table>

</body>
</html>