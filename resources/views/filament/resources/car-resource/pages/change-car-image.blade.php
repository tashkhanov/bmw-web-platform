<x-filament-panels::page>
    <div class="mb-6">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Текущее изображение</h3>
        @if ($record->image)
            <div class="mt-2">
                <img src="{{ asset($record->image) }}" alt="Current Image" class="max-w-xs h-auto rounded-lg shadow-md">
            </div>
        @else
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Изображение не загружено.</p>
        @endif
    </div>

    <form wire:submit.prevent="submit">
        {{ $this->form }}

        <div class="mt-6 flex gap-x-3">
            <x-filament::button type="submit">
                Загрузить и сохранить
            </x-filament::button>
            
            <x-filament::button color="gray" tag="a" :href="App\Filament\Resources\CarResource::getUrl('edit', ['record' => $record])">
                Отмена
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>