@foreach($packages as $key => $item)
    <tr id="{{ $item->tracking_code }}">

        <td scope="row">SHIFT+{{ $key + 1 }}</td>

        <td>
            @if($item->links || $item->order_id) 🔗 @endif {{ $item->tracking_code }}
        </td>
        <td>
            {{ $item->shipping_org_price }}
        </td>
        <td>
            {{ $item->detailed_type }}
        </td>

        <td>
            {{ $item->status_label }}
        </td>

        <td>

            <div class="btn-group">

                <a target="_blank" title="Invoice" href=" {{ $item->invoice }}" type="button"
                   class="btn btn-sm btn-info btn-icon legitRipple"><i class="icon-file-pdf"></i></a>


                <button id="{{ ($key + 1) }}_add" data-tc="{{ trim($item->tracking_code) }}"
                        class="btn btn-sm btn-group btn-danger btn-icon legitRipple btn-ladda btn-ladda-spinner rescan-package"
                        data-spinner-color="#fff" data-style="slide-left" type="button">
                    <i class="icon-add-to-list"></i>
                </button>
            </div>
        </td>
    </tr>
@endforeach