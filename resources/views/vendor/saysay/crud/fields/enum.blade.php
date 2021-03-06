<!-- enum -->
<div @include('crud::inc.field_wrapper_attributes') >
    @if (isset($field['label']))
        <label>{!! $field['label'] !!}</label>
    @endif

    @include('crud::inc.field_translatable_icon')
    <?php $entity_model = $crud->model; ?>
    <select
            name="{{ $field['name'] }}"
            @include('crud::inc.field_attributes')
    >

        @if ($entity_model::isColumnNullable($field['name']))
            <option value="">{{ is_string($field['allowNull']) ? $field['allowNull'] : '-' }}</option>
        @endif

        @if (count($entity_model::getPossibleEnumValues($field['name'])))
            @foreach ($entity_model::getPossibleEnumValues($field['name']) as $possible_value)
                <option value="{{ $possible_value }}"
                        @if (( old($field['name']) &&  old($field['name']) == $possible_value) || (isset($item->{$field['name']}) && $item->{$field['name']}==$possible_value))
                        selected
                        @endif
                >{{ $possible_value }}</option>
            @endforeach
        @endif
    </select>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>
