@extends('layouts.sidebar')

@section('content')
<main class="p-6 bg-gray-50 flex-1">
  <div class="flex justify-between items-center mb-4">
    <h3 class="text-lg font-semibold">Daftar Pengajuan</h3>
    <form action="{{ route('submission.index') }}" method="GET">
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
          <th class="p-3">Aksi</th>
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
                {{-- Approve --}}
                <form action="{{ route('submission.approved', $sub->id) }}" method="POST" class="inline-block form-approve-{{ $sub->id }}">
                    @csrf
                    @method('PUT')
                    <button type="button" onclick="confirmApprove({{ $sub->id }})" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg text-sm">
                    Approve
                    </button>
                </form>

                {{-- Reject --}}
               <form action="{{ route('submission.rejected', $sub->id) }}" method="POST" class="hidden" id="form-reject-{{ $sub->id }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="notes" id="notes-{{ $sub->id }}">
                </form>

                <!-- Tombol Trigger -->
                <button 
                    type="button" 
                    onclick="confirmReject({{ $sub->id }})" 
                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm"
                >
                    Reject
                </button>
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

      // Fungsi Approve
      function confirmApprove(id) {
          Swal.fire({
              title: 'Setujui Pengajuan?',
              text: "Pastikan data pengajuan sudah benar.",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#28a745',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Ya, setujui'
          }).then((result) => {
              if (result.isConfirmed) {
                  document.querySelector('.form-approve-' + id).submit();
              }
          });
        }

      // Fungsi Reject
      function confirmReject(id) {
          Swal.fire({
              title: 'Tolak Pengajuan?',
              input: 'textarea',
              inputLabel: 'Catatan (Notes)',
              inputPlaceholder: 'Tulis alasan penolakan di sini...',
              inputAttributes: {
                  'aria-label': 'Tulis alasan di sini'
              },
              showCancelButton: true,
              confirmButtonText: 'Selesai',
              cancelButtonText: 'Kembali',
              reverseButtons: false,
              preConfirm: (notes) => {
                  if (!notes) {
                      Swal.showValidationMessage('Catatan wajib diisi')
                  }
                  return notes;
              }
          }).then((result) => {
              if (result.isConfirmed) {
                  document.getElementById('notes-' + id).value = result.value;
                  document.getElementById('form-reject-' + id).submit();
                }
              });
            }

      window.addEventListener('pageshow', function (event) {
          const fromCache = event.persisted || performance.getEntriesByType("navigation")[0]?.type === "back_forward";
          if (fromCache) return;

          @if(session('error'))
          Swal.fire({
              title: "Gagal!",
              text: @json(session('error')),
              icon: "error",
              confirmButtonColor: "#d33"
          });
          @endif

          @if(session('success'))
          Swal.fire({
              title: "Berhasil!",
              text: @json(session('success')),
              icon: "success",
              confirmButtonColor: "#3085d6"
          });
          @endif
      });
  </script>

@endsection
