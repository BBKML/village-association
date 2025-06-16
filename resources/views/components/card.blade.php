<div class="bg-white rounded-xl shadow-md overflow-hidden {{ $attributes->get('class') }}">
    @if(isset($image))
        <div class="relative h-48 overflow-hidden">
            <img src="{{ $image }}" alt="{{ $alt }}" class="w-full h-full object-cover">
            @if(isset($badge))
                <span class="absolute top-2 left-2 {{ $badgeClass }}">{{ $badge }}</span>
            @endif
        </div>
    @endif
    <div class="p-6">
        {{ $slot }}
    </div>
</div>