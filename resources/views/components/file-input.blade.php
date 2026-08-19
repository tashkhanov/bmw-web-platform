<div class="space-y-2">
    <label class="text-sm font-medium" for="{{ $getId() }}">
        {{ $getLabel() }}
    </label>
    
    <input
        type="file"
        id="{{ $getId() }}"
        name="{{ $getId() }}"
        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
    >
    
    @error($getId())
        <p class="text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>