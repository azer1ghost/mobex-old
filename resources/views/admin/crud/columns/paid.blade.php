@if($item->portmanat)
    <a target="_blank" href="{{ route('transactions.index') }}?id={{ $item->portmanat->id }}">by PortManat</a>
    @if($item->transaction)
        <br/> @ {{ $item->transaction->created_at }}
    @endif
    @if($item->status == 2)
        <br>
        <a href="#!" class="btn btn-info btn-xs legitRipple text-white"
           data-ajax-request="{{ route('packages.request', $item->id) }}">Request</a>
    @endif
@else
    @include('crud::components.columns.select-editable' )
    @if($item->transaction)
        <br/> @ {{ $item->transaction->created_at }}
    @endif
@endif