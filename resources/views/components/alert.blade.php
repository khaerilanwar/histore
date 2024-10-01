<?php
$error = 'text-red-800 bg-red-50';
$success = 'text-green-800 bg-green-50';
?>

<div class="p-4 mb-4 text-sm rounded-lg absolute top-14 left-1/2 -translate-x-1/2 alert @if ($attributes->get('type') === 'error') {{ $error }}
     @elseif ($attributes->get('type') === 'success')
     {{ $success }} @endif"
    role="alert">
    {{ $slot }}
</div>
