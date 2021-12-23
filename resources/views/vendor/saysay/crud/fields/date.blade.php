<!-- html5 date input -->

<?php
// if the column has been cast to Carbon or Date (using attribute casting)
// get the value as a date string
if (isset($item->{$field['name']}) && ($item->{$field['name']} instanceof \Carbon\Carbon || $item->{$field['name']} instanceof \Jenssegers\Date\Date)) {
    $item->{$field['name']} = $item->{$field['name']}->toDateString();
}
?>

<div @include('crud::inc.field_wrapper_attributes') >
    @if (isset($field['label']))        <label>{!! $field['label'] !!}</label>    @endif
    @include('crud::inc.field_translatable_icon')
    <input
            type="date"
            name="{{ $field['name'] }}"
            value="{{ old($field['name']) ? old($field['name']) : (isset($item->{$field['name']}) ? $item->{$field['name']} : (isset($field['default']) ? $field['default'] : '' )) }}"
            @include('crud::inc.field_attributes')
    >

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>
