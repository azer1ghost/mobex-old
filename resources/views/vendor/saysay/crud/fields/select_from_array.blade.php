<!-- select from array -->
<div @include('crud::inc.field_wrapper_attributes') >
    @if (isset($field['label']))        <label>{!! $field['label'] !!}</label>    @endif
    @include('crud::inc.field_translatable_icon')
    <?php if(isset($field['default_by_relation'])){
            $field['default'] = parseRelation(auth()->guard('worker')->user()->warehouse, $field['default_by_relation']);
        }
    ?>
    <select
            @if(isset($field['name']))
            name="{{ $field['name'] }}@if (isset($field['allows_multiple']) && $field['allows_multiple']==true)[]@endif"
            @endif
            @include('crud::inc.field_attributes')
            @if (isset($field['allows_multiple']) && $field['allows_multiple']==true)multiple @endif
    >

        @if (isset($field['allowNull']) && $field['allowNull']==true)
            <option value="">{{ is_string($field['allowNull']) ? $field['allowNull'] : '-' }}</option>
        @endif

        <?php
        if (isset($field['optionsFromConfig'])) $field['options'] = config($field['optionsFromConfig']);
        ?>
        @if (isset($field['options']) && count($field['options']))
            @foreach ($field['options'] as $key => $value)
                <option value="{{ $key }}"
                        @if (
                        isset($field['name'])
                         && isset($item->{$field['name']})
                         && (
                          $key === $item->{$field['name']} || (is_array($item->{$field['name']}) && in_array($key, $item->{$field['name']})))
                            || ( ! is_null( old($field['name']) ) && old($field['name']) == $key)
                            || ( ! is_null(Request::get($field['name'])) && Request::get($field['name']) == $key )
                            || (isset($field['default']) && $field['default'] == $key)
                            )
                        selected
                        @endif
                >{{ $value }}</option>
            @endforeach
        @endif
    </select>

    @include('crud::inc.error_or_hint')
</div>
