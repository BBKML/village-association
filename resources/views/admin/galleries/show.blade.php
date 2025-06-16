@extends('layouts.admin')

@section('title', 'Détails de la Galerie')

@section('admin-content')
<div class="bg-white shadow-xl rounded-2xl p-8 max-w-7xl mx-auto mt-6">

    {{-- Titre & Description --}}
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-blue-700">{{ $gallery->title }}</h1>
        <p class="text-gray-500 text-lg mt-2">{{ $gallery->description }}</p>
    </div>

    {{-- Actions --}}
    <div class="flex flex-col md:flex-row md:justify-between items-center gap-4 mb-10">
        <a href="{{ route('admin.galleries.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg shadow hover:bg-gray-200 transition">
            <i class="fas fa-arrow-left mr-2"></i> Retour
        </a>
        <div class="flex gap-3">
            <a href="{{ route('admin.galleries.edit', $gallery) }}" class="px-4 py-2 bg-yellow-400 text-white text-sm rounded-lg hover:bg-yellow-500 transition">
                <i class="fas fa-edit mr-1"></i> Modifier
            </a>
            <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette galerie ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-500 text-white text-sm rounded-lg hover:bg-red-600 transition">
                    <i class="fas fa-trash-alt mr-1"></i> Supprimer
                </button>
            </form>
        </div>
    </div>

    {{-- Upload Section --}}
    <div class="bg-gray-50 p-6 rounded-xl shadow-inner mb-10">
        <h3 class="text-xl font-semibold text-gray-700 mb-4">📤 Ajouter des Médias</h3>
        <form action="{{ route('admin.galleries.upload', $gallery) }}" method="POST" enctype="multipart/form-data" class="flex flex-col md:flex-row gap-4">
            @csrf
            <input type="file" name="files[]" multiple class="flex-1 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                <i class="fas fa-upload mr-2"></i>Uploader
            </button>
        </form>
    </div>

    {{-- Médias --}}
    <h3 class="text-2xl font-semibold text-gray-700 mb-6">🖼️ Médias</h3>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" id="sortable-media">
        @forelse($gallery->items as $item)
            <div class="bg-white rounded-lg shadow group overflow-hidden" data-id="{{ $item->id }}">
                @if($item->file_type === 'image')
                    <img src="{{ asset('storage/' . $item->file_path) }}" alt="{{ $item->alt_text }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform">
                @else
                    <video controls class="w-full h-48 object-cover">
                        <source src="{{ asset('storage/' . $item->file_path) }}" type="video/mp4">
                    </video>
                @endif
                <div class="p-4">
                    <h5 class="font-semibold text-gray-800">{{ $item->caption }}</h5>
                    <div class="flex justify-between mt-4 text-sm">
                        <a href="{{ route('admin.media.show', $item) }}" class="text-blue-600 hover:underline">Voir</a>
                        <a href="{{ route('admin.media.edit', $item) }}" class="text-yellow-600 hover:underline">Modifier</a>
                        <form action="{{ route('admin.media.destroy', $item) }}" method="POST" onsubmit="return confirm('Supprimer ce média ?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-500">Aucun média disponible pour cette galerie.</p>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<!-- jQuery UI pour tri -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(function() {
        $("#sortable-media").sortable({
            update: function(event, ui) {
                const itemIds = $(this).find('[data-id]').map(function() {
                    return $(this).data('id');
                }).get();

                $.post("{{ route('admin.media.reorder') }}", {
                    items: itemIds,
                    _token: "{{ csrf_token() }}"
                });
            }
        });
    });
</script>
@endpush
