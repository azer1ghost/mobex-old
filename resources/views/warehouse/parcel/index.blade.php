@extends(config('saysay.crud.layout'))

@section('content')

    <div class="row">
        <div class="col-lg-{{ $_view['listColumns'] }} col-lg-offset-{{ (12 - $_view['listColumns'])/2 }} col-md-12 col-xs-12">
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h6>
                        {{ isset($_view['name']) ? str_plural($_view['name']) : null }}
                    </h6>
                    <div class="heading-elements">
                        @if($extraButtons)
                            @foreach($extraButtons as $extraAction)
                                <a @if(isset($extraAction['target'])) target="{{ $extraAction['target'] }}"
                                   @endif title="{{ $extraAction['label'] }}"
                                   href="{{ route($extraAction['route']) }}{{ isset($type) ? ('?type=' . $type) : null }}"
                                   type="button" class="btn btn-{{ $extraAction['color'] }} btn-icon legitRipple"><i
                                            class="icon-{{ $extraAction['icon'] }}"></i> {{ $extraAction['label'] }}</a>
                            @endforeach
                        @endif

                        @if($type != 'sent')
                            @checking('create-' . $crud['route'])
                            <a href="{{ route($crud['route'] . '.create') }}{{ isset($type) ? ('?type=' . $type) : null }}"
                               class="btn btn-info btn-sm legitRipple">
                                <i class="icon-plus2 position-left"></i>
                                {{ __('saysay::crud.create_button', ['title' => lcfirst($_view['name'])]) }}
                            </a>
                            @endchecking
                        @endif

                    </div>
                </div>

                <div class="panel-body">
                    @include('crud::inc.filter-stack')
                    <div class="table-responsive overflow-visible">
                        <table class="table table-hover responsive table-bordered">
                            <thead>
                            <tr>
                                @if (isset($_view['checklist']))
                                    <th>
                                        <input title="check" type="checkbox" class="styled" id="check_all"/>
                                    </th>
                                @endif
                                <th>#</th>
                                <th>AWB</th>
                                <th>Weight</th>
                                <th>Items</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $dev = false; ?>
                            <?php $sent = false; ?>
                            @forelse($items as $row => $item)
                                <?php $parcelId = $item->id; ?>
                                @if($item->real && ! $item->sent && ! $dev)
                                    <?php $dev = true; ?>
                                    <tr style="background: #eeeded;height: 55px;">
                                        <td colspan="7" style="font-weight: 600;">Ready to Fly</td>
                                    </tr>
                                @endif
                                @if($item->sent && ! $sent)
                                    <?php $sent = true; ?>
                                    <tr style="background: #e2ffe4;height: 55px;">
                                        <td colspan="7" style="font-weight: 600;">Sent</td>
                                    </tr>
                                @endif

                                <tr>
                                    <td class="tab_it closed" data-packages="parcel_{{ $parcelId }}">
                                        <i class="icon-minus2 minus"></i>
                                        <i class="icon-plus2 plus"></i>
                                        {{ $item->custom_id }}
                                    </td>
                                    <td>
                                        {{ $item->awb }}
                                    </td>
                                    <td>{{ $item->packages->sum('weight') }} kg</td>
                                    <td>{{ $item->packages_count }}   @if(! $item->sent)/<span
                                                style="background: green;color: #fff;padding: 5px;border-radius: 5px;">{{ $item->packages()->where('custom_status', 1)->count() }}</span>@endif
                                    </td>
                                    <td>{{ $item->sent_with_label }}</td>
                                    <td>{{ $item->created_at->diffForHumans() }}</td>
                                    <td>
                                        @include('crud::inc.button-stack')
                                    </td>
                                </tr>
                                @foreach($item->packages as $item)
                                    <tr class="sub-child parcel_{{ $parcelId }}">
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
                                        <td>
                                            @include('crud::inc.button-stack', ['extraActions' => $extraActionsForPackage, 'noNeed' => true])
                                        </td>
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
                        {{-- <div class="pull-right">
                             <div>{!! $items->appends(Request::except('page'))->links() !!}</div>
                         </div>--}}
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection