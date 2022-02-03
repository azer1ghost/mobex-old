@extends(config('saysay.crud.layout'))

@section('content')
    <div class="row">
        <div class="col-lg-{{ $_view['formColumns'] }} col-lg-offset-{{ (12 - $_view['formColumns'])/2 }} col-md-12 col-xs-12">
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h6>
                        {{ isset($_view['name']) ? str_plural($_view['name']) : null }}
                        <small class="display-block">{{ $_view['sub_title'] ?? null }}</small>
                    </h6>
                    <div class="heading-elements">
                        @if(isset($currentLang))
                            <div class="btn-group heading-btn">
                                <button class="btn btn-success">{{ config('translatable.locales_name.' . $currentLang) }}</button>
                                <button class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                </button>

                                <ul class="dropdown-menu dropdown-menu-right">
                                    @foreach(config('translatable.locales_name') as $_lang => $langName)
                                        @if($_lang != $currentLang)
                                            <li>
                                                <a href="{{ $form['selfLink'] . "?lang=" . $_lang }}">{{ $langName }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>

                @if (session('error'))
                    <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
                @endif
                 {{ Form::open(['url' => $form['route'], 'method' => $form['method'], 'id' => 'form-' . strtolower($_view['name']), 'class' => 'form-' . $_view['formStyle'], 'files' => true]) }}
                 <div class="panel-body">
                     <div id="updated" class="alert alert-success" style="display: none">Updated! </div>
                     @if(isset($currentLang))
                         {{ Form::hidden('_lang', $currentLang) }}
                     @endif

                     @if($fields)
                         @foreach ($fields as $field)
                             @include('crud::fields.' . $field['type'], ['field' => $field])
                         @endforeach
                     @else
                         @include('crud::components.alert', ['text' => trans('saysay::crud.no_fields')])
                     @endif

                         <div class="row">
                             <div class="col-lg-12">

                                 @if(isset($includes))
                                     @foreach($includes as $include)
                                         @include($include['view'], $include['data'])
                                     @endforeach
                                 @endif
                             </div>
                         </div>

                 </div>

                 <div class="panel-footer">
                     @include('crud::inc.form_save_buttons')
                 </div>
                 {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection