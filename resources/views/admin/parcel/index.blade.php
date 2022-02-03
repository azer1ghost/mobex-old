@extends(config('saysay.crud.layout'))

@section('content')

    <div class="row">
        <div class="col-lg-{{ $_view['listColumns'] }} col-lg-offset-{{ (12 - $_view['listColumns'])/2 }} col-md-12 col-xs-12">
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h6>
                        {{ isset($_view['name']) ? str_plural($_view['name']) : null }}
                        <small class="display-block"> Showing {{ $items->firstItem() }} to {{ $items->lastItem() }}
                            of {{ number_format($items->total()) }} {{ $_view['sub_title'] ?? lcfirst(str_plural($_view['name'])) }}</small>
                    </h6>
                </div>

                <div class="panel-body">
                    @include('crud::inc.filter-stack')
                    <div class="table-responsive">
                        <table class="table table-hover responsive table-bordered">
                            <thead>
                            <tr>
                                @if (isset($_view['checklist']))
                                    <th>
                                        <input title="check" type="checkbox" class="styled" id="check_all"/>
                                    </th>
                                @endif
                                <th>MWB</th>
                                <th>AWB</th>
                                @foreach($_list as $key => $head)
                                    <th>{{ is_array($head) ? (array_key_exists('label', $head) ? $head['label'] : ucfirst(str_replace("_", " ", $key))) : ucfirst(str_replace("_", " ", $head)) }}</th>
                                @endforeach
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $dev = false; ?>
                            @forelse($items as $row => $item)
                                <?php $parcelId = $item->id; ?>
                                @if($item->real && ! $dev)
                                    <?php $dev = true; ?>
                                    <tr>
                                        <td colspan="12"></td>
                                    </tr>
                                @endif
                                <tr>
                                    <td class="tab_it closed" data-packages="parcel_{{ $parcelId }}">
                                        <i class="icon-minus2 minus"></i>
                                        <i class="icon-plus2 plus"></i>
                                        {{ $item->custom_id }}
                                    </td>
                                    <td>
                                        @include('crud::components.columns.editable', [
                                            'entry' => parseRelation($item, 'awb'),
                                            'head' => [
                                                        'type'     => 'editable',
                                                        'editable' => [
                                                            'title' => 'AWB',
                                                            'route' => 'parcels.ajax',
                                                            'type'  => 'text',
                                                            'key'  => 'awb',
                                                            'skip'  => true,
                                                        ],
                                                    ],
                                            ]
                                        )
                                    </td>
                                    <td>
                                        @php
                                            $key = 'warehouse.country';
                                            $type = 'country';
                                            $entry = parseRelation($item, $key);
                                        @endphp
                                        @if(view()->exists('admin.crud.columns.' . $type))
                                            @include('admin.crud.columns.' . $type)
                                        @else
                                            @include('crud::components.columns.' . $type )
                                        @endif
                                    </td>
                                    <td colspan="{{  intval(isset($_view['checklist'])) + count($_list) - 6 }}"></td>
                                    <td>{{ $item->packages->sum('weight') }} kg</td>
                                    <td>{{ $item->packages_count }} @if($item->waiting_count) /<a
                                                href="{{ route('packages.index') }}?status=1&warehouse_id={{ $item->warehouse_id }}&limit=150&parcel_id={{ $item->id }}"
                                                class="waiting_packages"
                                                style="background: red;color: #fff;padding: 5px;border-radius: 5px;">{{ $item->waiting_count }}</a>@endif
                                    </td>
                                    <td>@if($item->customs_sent) ✅ @endif</td>
                                    <td>{{ $item->sent_with_label }}</td>
                                    <td>{{ $item->created_at->diffForHumans() }}</td>
                                    <td>
                                        @include('crud::inc.button-stack')
                                    </td>
                                </tr>
                                @foreach($item->packages as $item)
                                    <tr class="sub-child parcel_{{ $parcelId }}"
                                        @if($item->status == 1) style="background: #ffdcdc" @endif>
                                        <td></td>
                                        <td></td>
                                        @foreach($_list as $key => $head)
                                            <td>
                                                @php
                                                    $key = is_array($head) ? $key : $head;
                                                    $type = isset($head['type']) ? $head['type'] : 'text';
                                                    $entry = parseRelation($item, $key);
                                                @endphp

                                                @if(view()->exists('admin.crud.columns.' . $type))
                                                    @include('admin.crud.columns.' . $type)
                                                @else
                                                    @include('crud::components.columns.' . $type )
                                                @endif
                                            </td>
                                        @endforeach
                                        <td></td>
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="{{ 2 + intval(isset($_view['checklist'])) + count($_list) }}">
                                        @include('crud::components.alert')
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="panel-footer">
                    <div class="heading-elements">
                        @if (isset($_view['checklist']) and is_array($_view['checklist']))
                            <div class="btn-group">
                                @foreach($_view['checklist'] as $button)
                                    <button data-route="{{ route($button['route']) }}"
                                            data-value="{{ $button['value'] }}"
                                            data-key="{{ $button['key'] }}" type="button"
                                            data-loading-text="<i class='icon-spinner4 spinner position-left'></i> Loading"
                                            class="btn btn-{{ isset($button['type']) ? $button['type'] : 'info' }} btn-loading do-list-action">
                                        <i class="icon-{{ isset($button['icon']) ? $button['icon'] : 'spinner4' }} position-left"></i>
                                        {{ $button['label'] }}
                                    </button>
                                @endforeach
                            </div>
                        @endif
                        <div class="pull-right">
                            <div>{!! $items->appends(Request::except('page'))->links() !!}</div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection