@extends(config('saysay.crud.layout'))

@section('content')

    <div class="row">
        <div class="col-lg-{{ $_view['listColumns'] }} col-lg-offset-{{ (12 - $_view['listColumns'])/2 }} col-md-12 col-xs-12">
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h6>
                        {{ isset($_view['name']) ? str_plural($_view['name']) : null }}
                        <small class="display-block"> Showing {{ $items->firstItem() }} to {{ $items->lastItem() }}
                            of {{ number_format($items->total()) }} {{ $_view['sub_title'] or lcfirst(str_plural($_view['name'])) }}</small>
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
                                <th></th>
                                <th>ID</th>
                                <th>Status</th>
                                <th>Paid</th>
                                <th>Packages</th>
                                <th>Total</th>
                                <th>User</th>
                                <th>Filial</th>
                                <th>Address</th>
                                <th>Weight</th>
                                <th>At</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($items as $row => $item)
                                <?php $parcelId = $item->id; ?>
                                <tr id="{{ $parcelId }}">
                                    <td>
                                        @if($admin_type != 'courier')
                                            <a target="_blank" title="Invoice"
                                               href="{{  route('deliveries.label', $item->id)}}"
                                               class="dropdown-item legitRipple"><i
                                                        class="icon-printer"></i></a>
                                        @endif
                                    </td>
                                    <td class="tab_it closed" data-packages="parcel_{{ $parcelId }}">
                                        <i class="icon-minus2 minus"></i>
                                        <i class="icon-plus2 plus"></i>
                                        {{ $item->id }}
                                    </td>
                                    <td>
                                        @include('crud::components.columns.select-editable', [
                                            'entry' => parseRelation($item, 'status'),
                                            'head' => [
                                                        'type'     => 'select-editable',
                                                        'editable' => [
                                                            'route'            => 'deliveries.ajax',
                                                            'type'             => 'select',
                                                            'sourceFromConfig' => 'ase.attributes.delivery.' . $statuses,
                                                            'key' => 'status'
                                                        ],
                                                    ],
                                                      'key' => 'status'
                                            ]
                                        )
                                    </td>
                                    <td>{{ $item->paid ? 'Yes' : 'No' }}</td>
                                    <td>{{ $item->packages->count() }}</td>
                                    <td>@if(!$item->paid){{ $item->total_price }}₼/{{ $item->fee }}₼ @else -/- @endif</td>
                                    <td><a target="_blank" href="tel:{{ $item->cleared_phone }}">{{ $item->full_name }}
                                            (Tel:{{
                                            $item->cleared_phone }})</a></td>
                                    <td>{{ $item->filial->name or '-' }}</td>
                                    <td>{{ $item->full_address }}</td>
                                    <td>{{ $item->packages->sum('weight') }} kg</td>
                                    <td>{{ $item->created_at->diffForHumans() }}</td>
                                </tr>
                                @if($item->note)
                                    <tr class="sub-child parcel_{{ $parcelId }}">
                                        <td colspan=11">
                                            <div class="alert alert-danger">
                                                Note: {{ $item->note }}
                                            </div>

                                        </td>
                                    </tr>
                                @endif
                                @foreach($item->packages as $item)
                                    <tr class="sub-child parcel_{{ $parcelId }}"
                                        @if($item->status == 1) style="background: #ffdcdc" @endif>
                                        <td colspan=5"></td>
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