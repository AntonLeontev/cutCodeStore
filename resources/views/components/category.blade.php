<a href="{{route('catalog', $category->slug)}}"
		class="@if (Str::endsWith(request()->url(), $category->slug))
			bg-pink
		@else
			bg-card
		@endif
		p-3 font-semibold text-white sm:p-4 2xl:p-6 rounded-xl hover:bg-pink text-xxs sm:text-xs lg:text-sm">{{ $category->title }}</a>
