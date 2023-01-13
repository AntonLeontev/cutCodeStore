<div>
    <h5 class="mb-4 text-sm font-bold 2xl:text-md">{{$filter->title()}}</h5>
    <div class="flex items-center justify-between gap-3 mb-2">
        <span class="font-medium text-body text-xxs">От, ₽</span>
        <span class="font-medium text-body text-xxs">До, ₽</span>
    </div>

    <div class="flex items-center gap-3">
        <input id="{{ $filter->id('from') }}"
            class="border-body/10 focus:border-pink h-12 w-full rounded-lg border bg-white/5 px-4 text-xs text-white shadow-transparent outline-0 transition focus:shadow-[0_0_0_3px_#EC4176]"
            name="{{ $filter->name('from') }}" type="number" value="{{ $filter->requestValue('from') }}" placeholder="0">
        <span class="text-sm font-medium text-body">–</span>

        <input id="{{ $filter->id('to') }}"
            class="border-body/10 focus:border-pink h-12 w-full rounded-lg border bg-white/5 px-4 text-xs text-white shadow-transparent outline-0 transition focus:shadow-[0_0_0_3px_#EC4176]"
            name="{{ $filter->name('to') }}" type="number" value="{{ $filter->requestValue('to') }}" placeholder="100000">
    </div>
</div>
