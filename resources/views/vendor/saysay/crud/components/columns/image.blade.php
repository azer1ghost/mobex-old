@if($entry)
    <img src="{{ $entry }}" class="{{ $head['class'] ?? null }}" id="{{ $head['id'] ?? null }}"
         height="{{ $head['height'] ?? '60' }}">
@endif