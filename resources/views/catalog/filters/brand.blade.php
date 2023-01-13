<div>
    <h5 class="mb-4 text-sm font-bold 2xl:text-md">{{ $filter->title() }}</h5>

    @foreach ($filter->values() as $brand)
        <div class="form-checkbox">
            <input id="brand-{{ $brand['id'] }}" name="{{ $filter->name($brand['id']) }}" type="checkbox"
                value="{{ $brand['id'] }}" @checked($filter->requestValue($brand['id']))>

            <label class="form-checkbox-label" for="brand-{{ $brand['id'] }}">
                {{ $brand['title'] }} 
				({{ $brand['products_count'] }})
            </label>
        </div>
    @endforeach
</div>
