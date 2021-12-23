<?php
$alertText = null;
$alertType = 'success';
$filials = isset(auth()->guard('admin')->user()->filials) ? auth()->guard('admin')->user()->filials->pluck('id')->all() : [];

if ($filials && (isset($user->filial_id) && ! in_array($user->filial_id, $filials))) {
    $alertText = "This package belongs to <b>" . $user->filial_name . "</b>. Please set this package aside.";
    $alertType = 'danger';
} else {
    if ($nearBy) {
        if ($dealer) {
            $alertText = "Dealer (" . $dealer->full_name . ") has " . $nearByCount . " packages in <b>" . $nearBy . "</b>. Put it there.";
            $alertType = 'info';
        } else {
            $alertText = $user->full_name . " has " . $nearByCount . " packages in <b>" . $nearBy . "</b>. Put it there.";
            $alertType = 'info';
        }
    }
}

?>

@if($alertText)
    <div class="alert alert-{{ $alertType }}" style="margin-top: 20px">
        {!! $alertText !!}
    </div>
@endif