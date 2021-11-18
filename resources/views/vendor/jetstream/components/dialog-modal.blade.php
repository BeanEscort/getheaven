@props(['id' => null, 'maxWidth' => null])

<x-jet-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="px-6 py-2">
        <div class="text-lg">
            {{ $title }}
        </div>

        <div class="mt-2">
            {{ $content }}
        </div>
    </div>

    <div class="px-6 py-2 bg-gray-100 text-right">
        {{ $footer }}
    </div>
</x-jet-modal>
