<nav class="gap-8 2xl:flex">
    @foreach ($menu as $item)
        <x-menu.item :$item />
    @endforeach
</nav>
