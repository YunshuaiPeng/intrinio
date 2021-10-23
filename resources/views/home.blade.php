<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="px-4 mt-6 sm:px-6 lg:px-8">
                <h2 class="text-gray-500 text-base font-medium uppercase tracking-wide">Securities</h2>
                <div class="mt-2 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($securities as $security)
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="p-5">
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
                            <div class="bg-gray-50 px-5 py-3 flex justify-between">
                                <div class="text-xs font-medium text-gray-500 truncate inline-flex items-end">
                                    {{ $security->historical_data_count }} close price records
                                </div>
                                <div class="text-sm inline-flex items-end">
                                    <a href="#" class="font-medium text-blue-500 hover:text-blue-600">
                                        Chartify
                                        <span aria-hidden="true">→</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
