@if($entry)
    <img title="{{ $entry->name }}" src="{{ $entry->flag }}" class="{{ $head['class'] ?? null }}"
         id="{{ $head['id'] ?? null }}"
         width="{{ $head['width'] ?? '20' }}"
         height="{{ $head['height'] ?? '20' }}">
@elseif(isset($item->country))
    <img title="{{ $item->country->name }}" src="{{ $item->country->flag }}" class="{{ $head['class'] ?? null }}"
         id="{{ $head['id'] ?? null }}"
         width="{{ $head['width'] ?? '20' }}"
         height="{{ $head['height'] ?? '20' }}">
@endif