@extends('layouts.sidebar')

@section('content')

    <main class="p-6 bg-gray-50 flex-1">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">List Berita</h3>
            <form action="{{ route('news.index') }}" method="GET">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Search by Title..." 
                    class="border px-4 py-2 rounded-lg w-64"
                >
            </form>
        </div>

        <div class="bg-white shadow-md rounded-lg p-4">
            <div class="mb-4 text-right">
                <a href="{{route('news.create')}}" class="bg-blue-400 hover:bg-blue-500 text-white px-4 py-2 rounded-lg">
                    Tambah Berita
                </a>
            </div>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-blue-300 text-white">
                        <th class="p-3">No</th>
                        <th class="p-3">Dokumentasi</th>
                        <th class="p-3">Judul Berita</th>
                        <th class="p-3">Tanggal</th>
                        <th class="p-3">Isi Berita</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($news as $newsItem)
                        <tr class="border-b">
                            <td class="p-3 text-center align-middle">{{ $loop->iteration}}</td>
                            <td class="p-3 text-center align-middle">
                                @if ($newsItem->image)
                                    <a href="{{ asset('storage/' . $newsItem->image) }}" target="_blank">
                                        <img src="{{ asset('assets/img/Picture.png') }}" alt="image" class="w-8 h-8 mx-auto">
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">Tidak ada file</span>
                                @endif
                            </td>
                            <td class="p-3 text-left align-middle">{{ $newsItem->title }}</td>
                            <td class="p-3 text-center align-middle">
                                {{ \Carbon\Carbon::parse($newsItem->upload_time)->locale('id')->translatedFormat('l, d F Y - H:i') }} 
                            </td>
                            <td class="p-3 align-middle text-center">
                                <button type="button" 
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm"
                                    onclick="openModal({{ $newsItem->id }})">
                                    Preview
                                </button>

                                <!-- Modal -->
                                <div id="modal-{{ $newsItem->id }}" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
                                    <div class="bg-white rounded-lg shadow-lg max-w-xl w-full max-h-[90vh] overflow-y-auto p-6 relative">
                                        <button onclick="closeModal({{ $newsItem->id }})" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                                        <img src="{{ asset('storage/' . $newsItem->image) }}" alt="image" class="w-45 h-45 mx-auto">
                                        <h2 class="text-xl font-semibold mb-4">{{ $newsItem->title }}</h2>
                                        <p class="text-gray-700 text-sm mb-4">
                                            <strong>Upload:</strong> {{ \Carbon\Carbon::parse($newsItem->upload_time)->format('d/m/Y - H:i') }}
                                        </p>
                                        <div class="text-gray-800">
                                            {!! nl2br(e($newsItem->content)) !!}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            </td>
                              <td class="p-3 text-center align-middle">
                                <div class="flex justify-center space-x-2">
                                    <button onclick="window.location='{{ route('news.edit', $newsItem->id) }}'" class="bg-green-500 hover:bg-green-600 p-2 rounded-lg">
                                            <img src="{{ asset('assets/img/Edit.png') }}" alt="Edit" class="w-5 h-5">
                                    </button>
                                    <form id="delete-form-{{ $newsItem->id }}" method="POST" action="{{ route('news.destroy', $newsItem->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" data-id="{{ $newsItem->id }}" class="delete-button bg-red-500 hover:bg-red-600 p-2 rounded-lg">
                                            <img src="{{ asset('assets/img/Trash.png') }}" alt="Delete" class="w-5 h-5">
                                        </button>
                                    </form>
                                </div>
                             </td>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center p-4 text-gray-500">Data Berita belum tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.delete-button');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const adminId = this.getAttribute('data-id');

                    Swal.fire({
                        title: "Yakin ingin dihapus?",
                        text: "Data yang dihapus tidak dapat dikembalikan!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya, Hapus!",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById(`delete-form-${adminId}`).submit();
                        }
                    });
                });
            });
        });
    </script>

    @if(session('error'))
    <script>
        Swal.fire({
            title: "Gagal!",
            text: "{{ session('error') }}",
            icon: "error",
            confirmButtonColor: "#d33"
        });
    </script>
    @endif
    @if(session('success'))
    <script>
        Swal.fire({
            title: "Berhasil!",
            text: "{{ session('success') }}",
            icon: "success",
            confirmButtonColor: "#3085d6"
        });
    </script>
    @endif

<script>
    function openModal(id) {
        document.getElementById(`modal-${id}`).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(`modal-${id}`).classList.add('hidden');
    }
</script>


@endsection