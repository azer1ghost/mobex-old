<style>
    * {
        font-size: 7px;
        font-family: Arial sans-serif;
    }

    .dejavu {
        line-height: 1em;
        font-family: Arial, "DejaVu Sans";
    }
</style>

<img style="width: 100%" src="{{ asset('admin/images/trendyol_temp.png') }}"/>

{{--<img id="logo" style="position: absolute; top: 25px; left: 33px; max-width: 130px; max-height: 40px"
     src="https://bon.az/uploads/home/shops/pierrecardin.png">--}}
<div id="depo_id" style="position: absolute; top: 21.66em; left: 24.4em; font-weight: 600">{{ rand(140, 160) }}</div>
<div id="customid" style="position: absolute; top: 27.209em; left: 7.6em;">{{ $item->user->customer_id ?? 'Istanbul' }}</div>
<div id="name" style="position: absolute; top: 25.7em; left: 8em;">{{ $item->user->full_name ?? 'Belirsiz' }}</div>

<div id="email" style="position: absolute; top: 33.68em; left: 8.5em; ">{{ $item->user->email ?? (uniqid() . '@trendyol.com') }}</div>

<div id="track" style="position: absolute; top: 2em; left: 29.7em; font-size: 1.7em; font-weight: 700 ">{{ $item->invoice_numbers['track'] }}</div>
<div id="track" style="position: absolute; top: 16.7em; left: 28.2em; font-size: 1.7em; font-weight: 700 ">{{ $item->invoice_numbers['tys'] }}</div>

<div id="fatura_no"
     style="position: absolute; top: 17.82em; left: 79.45em; font-weight: 600; font-size: 7px ">{{ $item->invoice_numbers['tys'] }}</div>
<div id="fatura_tarihi"
     style="position: absolute; top: 19.7em; left: 79.45em; font-weight: 600; font-size: 7px ">{{ $item->invoice_numbers['date'] }}</div>
<div id="tci"
     style="position: absolute; top: 21.62em; left: 79.45em; font-weight: 600; font-size: 7px ">{{ $item->invoice_numbers['tci'] }}</div>
<div id="irsaniye"
     style="position: absolute; top: 23.52em; left: 79.45em; font-weight: 600; font-size: 7px ">{{ $item->invoice_numbers['date'] }}</div>
<div id="duzenleme"
     style="position: absolute; top: 25.42em; left: 79.45em; font-weight: 600; font-size: 7px ">{{ $item->invoice_numbers['hour'] }}</div>


<div id="ettn"
     style="position: absolute; top: 25.9em; left: 63.6em; font-weight: 600; font-size: 8px ">{{ $item->invoice_numbers['ettn'] }}</div>
<div id="tracking"
     style="position: absolute; top: 33.92em; left: 74.3em;  font-size: 7px ">{{ $item->invoice_numbers['track'] }}</div>
<div id="vade"
     style="position: absolute; top: 36.12em; left: 74.2em;  font-size: 7px ">{{ $item->invoice_numbers['vade'] }}</div>
<div class="dejavu" id="vade"
     style="position: absolute; top: 44.74em; left: 85em;  font-size: 6px ">{{ $item->invoice_numbers['sayi_net'] }}</div>
<div id="vade"
     style="position: absolute; top: 44.81em; left: 75.21em;  font-size: 7px ">{{ $item->invoice_numbers['vade'] }}</div>
{{--<div id="website"
     style="position: absolute; top: 47em; left: 75.26em;  font-size: 7px ">{{ getDomain($item->website_name) }}</div>--}}
<div id="date"
     style="position: absolute; top: 49.12em; left: 74.81em;  font-size: 7px ">{{ $item->invoice_numbers['date'] }}</div>
<div id="cargo_name" style="position: absolute; top: 51.3em; left: 75.6em;  font-size: 7px ">{{ $cargo['name'] }}</div>
<div id="cargo_number"
     style="position: absolute; top: 53.43em; left: 74.54em;  font-size: 7px ">{{ $cargo['number'] }}</div>


<div id="cargo_number"
     style="position: absolute; top: 55.7em; right: 3.65em; font-weight: 600; font-size: 1.04em ">{{ $item->invoice_numbers['total_birim'] }}</div>
<div id="cargo_number"
     style="position: absolute; top: 58.2em; right: 3.65em; font-weight: 600; font-size: 1.04em ">{{ $item->invoice_numbers['total_iskonto'] }}</div>
<div id="cargo_number"
     style="position: absolute; top: 60.7em; right: 3.65em; font-weight: 600; font-size: 1.04em ">{{ $item->invoice_numbers['net_tutar'] }}</div>
<div id="cargo_number"
     style="position: absolute; top: 63.3em; right: 3.65em; font-weight: 600; font-size: 1.04em ">{{ $item->invoice_numbers['kdv'] }}</div>
<div id="cargo_number" style="position: absolute; top: 65.2em; right: 3.65em; font-weight: 600; font-size: 1.04em ">
    0,00
</div>
<div id="cargo_number"
     style="position: absolute; top: 66.2em; right: 3.65em; font-weight: 600; font-size: 1.04em ">{{ $item->invoice_numbers['kdv'] }}</div>
<div id="cargo_number" style="position: absolute; top: 67.2em; right: 3.65em; font-weight: 600; font-size: 1.04em ">
    0,00
</div>
<div id="cargo_number"
     style="position: absolute; top: 69.1em; right: 3.65em; font-weight: 600; font-size: 1.04em ">{{ $item->invoice_numbers['net'] }}</div>


<div id="product_k" style="position: absolute; top: 49.9em; left: 33.6em;">1</div>
<div id="product_k" style="position: absolute; top: 49.9em; left: 38.6em;">9,99</div>
<div id="product_k" style="position: absolute; top: 49.9em; left: 44.96em;">9,99</div>
<div id="product_k" style="position: absolute; top: 49.9em; left: 51.21em;">0,00</div>
<div id="product_k" style="position: absolute; top: 49.9em; left: 58.23em;">18</div>
<div id="product_k" style="position: absolute; top: 49.9em; left: 63.61em;">0,00</div>


<div id="product_k"
     style="position: absolute; top: 49.2em; left: 3.3em; font-size: 1.14em ">{{ $item->invoice_numbers['product'] }}</div>
<div id="product_k" style="position: absolute; top: 56.18em; left: 12em; width: 105px; ">{{ $item->invoice_numbers['product_name'] }}
</div>

<div id="product_k" style="position: absolute; top: 56.21em; left: 33.61em;">{{ $item->number_items }}</div>


<div id="product_k" style="position: absolute; top: 56.21em; right: 60em;">{{ $item->invoice_numbers['birim'] }}</div>
<div id="product_k" style="position: absolute; top: 56.21em; right: 53.6em;">{{ $item->invoice_numbers['iskonto'] }}</div>
<div id="product_k" style="position: absolute; top: 56.21em; right: 47.4em;">{{ $item->invoice_numbers['net_tutar'] }}</div>
<div id="product_k" style="position: absolute; top: 56.21em; right: 41.4em;">8</div>
<div id="product_k" style="position: absolute; top: 56.21em; right: 35em;">{{ $item->invoice_numbers['kdv'] }}</div>
