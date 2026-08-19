<div>
    <label for="{{ $getId() }}" class="block text-sm font-medium text-gray-700">
        {{ $getLabel() }}
    </label>
    
    <div class="mt-1 flex items-center">
        <input
            type="file"
            id="{{ $getId() }}"
            name="{{ $getId() }}"
            class="py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
        >
    </div>
    
    @error($getId())
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>