<span>{{ $entry->company_name }}</span>
(<img src="{{ $entry->country->flag }}" class="{{ $head['class'] ?? null }}" id="{{ $head['id'] ?? null }}"
     width="{{ $head['width'] ?? '20' }}"
     height="{{ $head['height'] ?? '20' }}">)