@props(['flash'])

<div class="{{ $flash->class() }} p-5">
    {{ $flash->message() }}
</div>
