<x-app-layout>
    <div class="flex flex-col gap-y-12">
        <div class="max-w-full lg:max-w-sm bg-white overflow-hidden shadow rounded-lg p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <img class="h-10 w-10 rounded" src="{{ asset($security->logo) }}"
                         alt="{{ $security->name }}">
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt>
                            <div class="text-lg font-medium text-gray-900">
                                {{ $security->name }}
                            </div>
                        </dt>
                        <dd class="text-xs font-medium text-gray-500 truncate">
                            {{ $security->ticker }} / {{ $security->currency }}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <security-historical-datum
            :security='@json($security)'
            :frequencies='@json($frequencies)'
        >
        </security-historical-datum>
    </div>
</x-app-layout>
