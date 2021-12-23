@if((! isset($item->no_action) || (isset($item->no_action) && ! $item->no_action)))
    <div class="list-icons">
        <div class="dropdown">
            <a href="#" class="list-icons-item" data-toggle="dropdown">
                <i class="icon-menu9"></i>
            </a>

            <div class="dropdown-menu dropdown-menu-{{ isset($_menu_left) ? 'left' : 'right' }}">
                @if($extraActions)
                    @foreach($extraActions as $extraAction)
                        @if(view()->exists($_viewDir . '.inc.extra_button') && isset($extraAction['custom']))
                            @include($_viewDir . '.inc.extra_button')
                        @else
                            @if($item->{$extraAction['key']})
                                <a @if(isset($extraAction['target'])) target="{{ $extraAction['target'] }}"
                                   @endif title="{{ $extraAction['label'] }}"
                                   href="{{ isset($extraAction['route']) ? route($extraAction['route'], $item->id) : $item->{$extraAction['key']} }}{{ isset($extraAction['query']) ? ('?' . http_build_query($extraAction['query'])) : null }}"
                                   class="dropdown-item legitRipple"><i
                                            class="icon-{{ $extraAction['icon'] }}"></i> {{ $extraAction['label'] }}</a>
                            @endif
                        @endif

                    @endforeach
                @endif

                @if(! $item->sent && ! isset($noNeed))
                    @checking('update-' . $crud['route'])
                    @if($crud['translatable'])
                        <div class="dropdown-divider"></div>
                        <div class="dropdown-submenu dropdown-submenu-left">
                            <a href="#" class="dropdown-item"><i class="icon-pencil"></i> Edit</a>
                            <div class="dropdown-menu">
                                @foreach(config('translatable.locales_name') as $lang => $langName)
                                    <a class="dropdown-item"
                                       href="{{ route($crud['route'] . '.edit', array_merge($crud['routeParams'], ['id' => $item->id])) }}?lang={{ $lang }}">
                                        - {{ $langName }}</a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ route($crud['route'] . '.edit', array_merge($crud['routeParams'], ['id' => $item->id])) }}"
                           type="button"
                           class="dropdown-item" data-spinner-color="#fff"
                           data-style="slide-left"><i class="icon-pencil"></i> Edit</a>
                    @endif
                    @endchecking
                    @checking('delete-' . $crud['route'])
                    @if((! isset($item->dont_delete) || (isset($item->dont_delete) && ! $item->dont_delete)))
                        {{ Form::open(['class' => 'sure-that no-padding', 'url' => route($crud['route'] . '.destroy', array_merge($crud['routeParams'], ['id' => $item->id])), 'method' => 'delete']) }}
                        <button class="{{ (isset($class) ? $class : '') . "dropdown-item" }}" data-spinner-color="#fff"
                                data-style="slide-left" type="submit">
                            <i class="icon-trash"></i> Delete
                        </button>
                        {{ Form::close() }}
                    @endif
                    @endchecking
                @endif


            </div>
        </div>
    </div>
@endif