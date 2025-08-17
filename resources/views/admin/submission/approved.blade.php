@extends('layouts.sidebar')

@section('content')
<main class="p-6 bg-gray-50 flex-1">
  <div class="flex justify-between items-center mb-4">
    <h3 class="text-lg font-semibold">Daftar Pengajuan Approved</h3>
    <form action="{{ route('submission.approved.list') }}" method="GET">
      <input 
        type="text" 
        name="search" 
        value="{{ request('search') }}"
        placeholder="Search by vendor..." 
        class="border px-4 py-2 rounded-lg w-64"
      >
    </form>
  </div>

  <div class="bg-white shadow-md rounded-lg p-4">
    <table class="w-full border-collapse">
      <thead>
        <tr class="bg-blue-300 text-white">
          <th class="p-3">No</th>
          <th class="p-3">ID</th>
          <th class="p-3">Kegiatan</th>
          <th class="p-3">Pengajuan</th>
          <th class="p-3">Pengusul</th>
          <th class="p-3">Lampiran</th>
          <th class="p-3">Detail</th>
          <th class="p-3">Status</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($submissions as $sub)
          <tr class="border-b">
            <td class="p-3 text-center">{{ $loop->iteration }}</td>
            <td class="p-3 text-center">{{ $sub->id }}</td>
            <td class="p-3">{{ $sub->name_event }}</td>
            <td class="p-3">{{ $sub->apply_date }}</td>
            <td class="p-3">{{ $sub->vendor }}</td>
            <td class="p-3">
              @if($sub->file)
                <a href="{{ asset('storage/' . $sub->file) }}" target="_blank" class="text-blue-600 underline">
                  📄 File Proposal
                </a><br>
              @else
                <span class="text-gray-500 italic">Tidak ada</span><br>
              @endif
    
              @if($sub->ktp)
                <a href="{{ asset('storage/' . $sub->ktp) }}" target="_blank" class="text-blue-600 underline">
                  🆔 Scan KTP
                </a><br>
              @else
                <span class="text-gray-500 italic">Tidak ada</span><br>
              @endif
              
              @if($sub->appl_letter)
                <a href="{{ asset('storage/' . $sub->appl_letter) }}" target="_blank" class="text-blue-600 underline">
                  📄 File Pengajuan
                </a><br>
              @else
                <span class="text-gray-500 italic">Tidak ada</span><br>
              @endif

              @if($sub->actv_letter)
                <a href="{{ asset('storage/' . $sub->actv_letter) }}" target="_blank" class="text-blue-600 underline">
                  📑 Proposal Kegiatan
                </a><br>
              @else
                <span class="text-gray-500 italic">Tidak ada</span><br>
              @endif
            </td>
            <td class="p-3 text-center">
            <button 
                type="button" 
                class="text-blue-600 underline hover:text-blue-800" 
                data-modal-target="modal-{{ $sub->id }}">
                Detail
            </button>

            <!-- Modal -->
            <div id="modal-{{ $sub->id }}" 
                class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
                  <div class="bg-white w-11/12 max-w-3xl rounded-2xl shadow-2xl p-8 relative">

                    <!-- Tombol Close -->
                    <button onclick="closeModal('modal-{{ $sub->id }}')" 
                            class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 text-2xl font-bold">
                      &times;
                    </button>

                    <!-- Header -->
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-3">
                      Detail Pengajuan
                    </h2>

                    <!-- Tabel -->
                    <div class="overflow-x-auto">
                      <table class="w-full text-sm text-gray-700">
                        <tbody class="divide-y divide-gray-200">
                          <tr>
                            <td class="font-semibold py-3 w-1/3">ID</td>
                            <td class="py-3">{{ $sub->id }}</td>
                          </tr>
                          <tr>
                            <td class="font-semibold py-3">Tanggal Pengajuan</td>
                            <td class="py-3">{{ \Carbon\Carbon::parse($sub->apply_date)->format('d M Y') }}</td>
                          </tr>
                          <tr>
                            <td class="font-semibold py-3">Nama PIC</td>
                            <td class="py-3">{{ $sub->namePIC }}</td>
                          </tr>
                          <tr>
                            <td class="font-semibold py-3">No. HP</td>
                            <td class="py-3">{{ $sub->no_hp }}</td>
                          </tr>
                          <tr>
                            <td class="font-semibold py-3">Vendor</td>
                            <td class="py-3">{{ $sub->vendor }}</td>
                          </tr>
                          <tr>
                            <td class="font-semibold py-3">Alamat</td>
                            <td class="py-3">{{ $sub->address }}</td>
                          </tr>
                          <tr>
                            <td class="font-semibold py-3">Lokasi</td>
                            <td class="py-3">{{ $sub->location }}</td>
                          </tr>
                          <tr>
                            <td class="font-semibold py-3">Nama Kegiatan</td>
                            <td class="py-3">{{ $sub->name_event }}</td>
                          </tr>
                          <tr>
                            <td class="font-semibold py-3">Tanggal Mulai Kegiatan</td>
                            <td class="py-3">{{ \Carbon\Carbon::parse($sub->start_date)->format('d M Y') }}</td>
                          </tr>
                          <tr>
                            <td class="font-semibold py-3">Tanggal Selesai Kegiatan</td>
                            <td class="py-3">{{ \Carbon\Carbon::parse($sub->end_date)->format('d M Y') }}</td>
                          </tr>
                          <tr>
                            <td class="font-semibold py-3">Lampiran</td>
                            <td class="py-3 space-y-2">
                              @if($sub->file)
                                📄 <a href="{{ asset('storage/' . $sub->file) }}" target="_blank" class="text-blue-600 hover:underline">File Proposal</a><br>
                              @endif
                              @if($sub->ktp)
                                🆔 <a href="{{ asset('storage/' . $sub->ktp) }}" target="_blank" class="text-blue-600 hover:underline">Scan KTP</a><br>
                              @endif                    
                              @if($sub->appl_letter)
                                📄 <a href="{{ asset('storage/' . $sub->appl_letter) }}" target="_blank" class="text-blue-600 hover:underline">File Pengajuan</a><br>
                              @endif
                              @if($sub->actv_letter)
                                📑 <a href="{{ asset('storage/' . $sub->actv_letter) }}" target="_blank" class="text-blue-600 hover:underline">Proposal Kegiatan</a><br>
                              @endif
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                      <div class="mt-6 text-right">
                        <button onclick="closeModal('modal-{{ $sub->id }}')" 
                                class="bg-gray-600 text-white px-5 py-2 rounded-lg hover:bg-gray-700 transition">
                          Tutup
                        </button>
                      </div>
                </div>
              </div>
            <td class="p-3 text-center">
                <a class="bg-green-500 text-white px-3 py-1 rounded-lg text-sm">{{$sub->status}}</a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="p-4 text-center text-gray-500">Data pengajuan belum tersedia.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</main>

<script>
  function closeModal(id) {
        document.getElementById(id).classList.add("hidden");
      }

      document.querySelectorAll("[data-modal-target]").forEach(btn => {
        btn.addEventListener("click", function() {
          const modalId = this.getAttribute("data-modal-target");
          document.getElementById(modalId).classList.remove("hidden");
        });
      });
</script>
@endsection
