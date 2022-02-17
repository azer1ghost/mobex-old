<form class="row">
    @foreach($filters as $name => $filter)
        <div class="{{$filter->parentClass}}">
            @isset($filter->label)
                <label for="filter_{{$name}}">{{$filter->label}}</label>
            @endisset
            @if($filter->type === 'select')
                <select
                    @isset($filter->class) class="{{$filter->class}}" @endisset
                    name="{{$name}}" id="filter_{{$name}}">
                    @foreach($filter->options as $key => $value)
                        <option
                                @if(request($name) == $key) selected @endif
                                value="{{$key}}">
                            {{$value}}
                        </option>
                    @endforeach
                </select>
            @else
                <input
                    @if(request()->filled($name)) value="{{request($name)}}" @endisset
                    @isset($filter->placeholder) placeholder="{{$filter->placeholder}}" @endisset
                    @isset($filter->class) class="{{$filter->class}}" @endisset
                    type="{{$filter->type}}"
                    name="{{$name}}" id="filter_{{$name}}">
            @endif
            @isset($filter->help)
                <small style="font-size: 13px" class="text-muted">{{$filter->help}}</small>
            @endisset
        </div>
    @endforeach
    <div class="col-1 col-xxl-1 my-4 my-xxl-2">
        <div class="btn-group shadow">
            <button class="btn btn-success btn-sm " style="line-height: 30px;min-width: 40px" type="submit">
                Axtar
            </button>
            <a class="btn btn-danger btn-sm" style="line-height: 30px;min-width: 40px" href="{{url()->current()}}">
                Təmizlə
            </a>
        </div>
    </div>

</form>
