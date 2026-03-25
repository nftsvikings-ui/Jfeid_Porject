<x-filament::widget>
    <x-filament::card>
               <h2 class="text-2xl font-bold text-gray-800 mb-6">📊 Overview Statistics</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($this->getStats() as $stat)
                <x-filament::card class="bg-gray-900 text-white">
                    <div class="text-lg font-semibold">{{ $stat['title'] }}</div>
                    <div class="text-3xl font-bold my-2">{{ $stat['count'] }}</div>

                    <div class="flex justify-between mt-4 space-x-2">
                        <a href="{{ $stat['view_route'] }}" class="text-sm text-blue-400 hover:underline">View All</a>
                        <a href="{{ $stat['create_route'] }}" class="text-sm text-green-400 hover:underline">Add New</a>
                    </div>
                </x-filament::card>
            @endforeach
        </div>
    </x-filament::card>
</x-filament::widget>