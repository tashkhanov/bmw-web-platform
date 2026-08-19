<div>
    <h3 class="text-lg font-semibold mb-2">🔄 Сменить изображение</h3>

    @php
        $record = \App\Models\CarImage::find($this->recordId);
    @endphp

    @if($record && $record->image_path)
        <div class="mb-4">
            <p class="text-sm text-gray-600">Текущее изображение:</p>
            <img src="{{ asset($record->image_path) }}" alt="Текущее изображение"
                 class="w-48 h-auto rounded shadow mt-2">
        </div>
    @else
        <p class="text-sm text-gray-500 mb-4">Нет текущего изображения</p>
    @endif

    <input type="file" wire:model="newImage" accept="image/*" class="block w-full text-sm text-gray-500
        file:mr-4 file:py-2 file:px-4
        file:rounded file:border-0
        file:text-sm file:font-semibold
        file:bg-blue-50 file:text-blue-700
        hover:file:bg-blue-100
    " />

    @error('newImage') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

    <button wire:click="save"
            wire:loading.attr="disabled"
            class="mt-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
        💾 Сохранить новое изображение
    </button>

    <div wire:loading wire:target="newImage" class="mt-2 text-blue-600">
        ⏳ Загрузка...
    </div>
</div>