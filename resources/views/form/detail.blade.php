<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Form</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-indigo-100 to-blue-100 min-h-screen font-sans antialiased">

    <div class="max-w-4xl mx-auto p-8 bg-white shadow-lg rounded-lg mt-10">
        <h1 class="text-4xl font-bold text-gray-800 mb-8 text-center">Detail Form</h1>

        <!-- Tanggal Pelaksanaan -->
        <div class="mb-6">
            <span class="block text-xl font-semibold text-gray-700">Tanggal Pelaksanaan:</span>
            <p class="mt-1 text-gray-600">{{ $form->tgl_mulai ?? 'Tidak ada data' }} sampai
                {{ $form->tgl_akhir ?? 'Tidak ada data' }}</p>
        </div>

        <!-- Asal Sekolah -->
        <div class="mb-6">
            <span class="block text-xl font-semibold text-gray-700">Asal Sekolah:</span>
            <p class="mt-1 text-gray-600">{{ $form->asal_sekolah ?? 'Tidak ada data' }}</p>
        </div>

        <!-- Jurusan -->
        <div class="mb-6">
            <span class="block text-xl font-semibold text-gray-700">Jurusan:</span>
            <p class="mt-1 text-gray-600">{{ $form->jurusan ?? 'Tidak ada data' }}</p>
        </div>

        <!-- Jumlah Siswa -->
        <div class="mb-6">
            <span class="block text-xl font-semibold text-gray-700">Jumlah Siswa:</span>
            <p class="mt-1 text-gray-600">{{ $form->jumlah_siswa ?? 'Tidak ada data' }}</p>
        </div>

        <!-- Daftar Siswa -->
        <div class="mb-8">
            <span class="block text-xl font-semibold text-gray-700">Daftar Siswa:</span>
            <div class="overflow-x-auto mt-4">
                <table class="min-w-full bg-white rounded-lg shadow-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b">
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Nama</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Ponsel</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Email</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($form->nama as $index => $nama)
                            <tr class="bg-white hover:bg-gray-100 transition duration-300">
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $nama }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $form->ponsel[$index] ?? 'Tidak ada data' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $form->email[$index] ?? 'Tidak ada data' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada data
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Surat (Foto yang diupload) -->
                <div class="mb-6">
                    <span class="block text-xl font-semibold text-gray-700">Surat:</span>
                    @if ($form->surat)
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Surat Pengantar:</label>
                            @php
                                $filePath = 'storage/uploads/' . $form->surat;
                                $fileExtension = pathinfo($form->surat, PATHINFO_EXTENSION);
                            @endphp

                            @if (in_array($fileExtension, ['jpg', 'jpeg', 'png']))
                                <img src="{{ asset($filePath) }}" alt="Surat Pengantar" class="w-full h-auto mb-4">
                                <a href="{{ asset($filePath) }}" class="text-blue-500 hover:underline"
                                    download="{{ $form->surat }}">
                                    Download Gambar
                                </a>
                            @elseif ($fileExtension === 'pdf')
                                <embed src="{{ asset($filePath) }}" type="application/pdf" width="100%"
                                    height="600px" />
                            @else
                                <a href="{{ asset($filePath) }}" class="text-blue-500 hover:underline"
                                    download="{{ $form->surat }}">
                                    Download File
                                </a>
                            @endif


                        </div>
                    @else
                        <p>Tidak ada surat pengantar diunggah.</p>
                    @endif
                </div>

            </div>
        </div>

        <!-- Tombol Kembali -->
        <div class="text-center">
            <a href="{{ route('account.dashboard') }}"
                class="inline-block px-6 py-3 bg-blue-500 text-white font-semibold rounded-lg shadow-lg hover:bg-blue-600 transition duration-300">
                Kembali
            </a>
        </div>
    </div>

</body>

</html>
