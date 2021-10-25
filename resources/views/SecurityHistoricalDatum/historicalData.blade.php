<x-app-layout>
    <div class="flex flex-col gap-y-4">
        <div class="flex items-center gap-2">
            <img class="h-6 w-6 rounded" src="{{ asset($security->logo) }}"
                 alt="{{ $security->name }}">
            <h2 class="text-gray-500 text-base font-medium uppercase tracking-wide">{{ $security->name }}</h2>
        </div>

        <security-historical-datum
            :security='@json($security)'
            :frequencies='@json($frequencies)'
        >
        </security-historical-datum>
    </div>
</x-app-layout>
