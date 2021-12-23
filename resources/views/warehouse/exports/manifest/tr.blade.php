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
        <th><b>İzləmə kodu</b></th>
        <th><b>Çuval No</b></th>
        <th><b>Package No</b></th>
        <th><b>Direction</b></th>
        <th><b>Miqdar</b></th>
        <th><b>Weight</b></th>
        <th><b>Invoice Price TL</b></th>
        <th><b>Invoice Price</b></th>
        <th><b>Delivery Price</b></th>
        <th><b>Total Price</b></th>
        <th><b>Currency type</b></th>
        <th><b>Product type</b></th>
        <th><b>Idxal name</b></th>
        <th><b>Idxal address</b></th>
        <th><b>Ixrac name</b></th>
        <th><b>Ixrac address</b></th>
        <th><b>TRACKING NO</b></th>
        <th><b>Qaime no.</b></th>
        <th><b>Fin</b></th>
        <th><b>Phone</b></th>
    </tr>

    <?php $total = 0; ?>
    @foreach($packages as $key => $package)
        <?php $total += $package->weight; ?>


        <tr>
            <td>{{ $package->custom_id }}</td>
            <td>{{ $package->parcel->count() ? $package->parcel->first()->custom_id : 'No' }}</td>
            <td>1</td>
            <td>1</td>
            <td>{{ $package->number_items }}</td>
            <td>{{ $package->weight }}</td>
            <td>{{ $package->shipping_amount }}</td>
            <td>{{ $package->shipping_converted_price }}</td>
            <td>{{ $package->delivery_price }}</td>
            <td>{{ $package->total_price }}</td>
            <td>840</td>
            <td>{{ $package->detailed_type }}</td>
            <td>{{ $package->user->full_name }}</td>
            <td>{{ $package->user->address }}</td>
            <td>{{ $package->website_name ? getOnlyDomain($package->website_name) : '-' }}</td>
            <td>Turkey</td>
            <td>{{ $package->tracking_code }}</td>
            <td>{{ $package->custom_id }}</td>
            <td>{{ $package->user->fin }}</td>
            <td>{{ $package->user->cleared_phone }}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="4"></td>
        <td>Toplam</td>
        <td>{{ round($total, 2) }}</td>
    </tr>

    </tbody>
</table>

</body>
</html>