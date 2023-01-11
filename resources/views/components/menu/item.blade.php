<a class="@if($item->isActive()) font-bold @endif
 text-white hover:text-pink" href="{{ $item->link() }}">{{ $item->title() }}</a>
