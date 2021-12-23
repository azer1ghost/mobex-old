<?php $color = (isset($item) && $item->user) ? (($item->total_price < $item->user->orderBalance(false)) ? '#8bc34a' : '#f44336' ) : null;  ?>
<span style="@if($color && $item->status < 2) background-color: {{ $color }}; @endif padding: 5px">{!! $item->user->order_balance !!}</span>
