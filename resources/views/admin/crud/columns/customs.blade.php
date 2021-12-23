@if($item->custom_status !== null)
   {!! str_repeat('✅ ', $item->custom_status + 1) !!}
@endif