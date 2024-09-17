<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Form</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-r from-purple-200 to-blue-100 min-h-screen flex items-center justify-center">
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-4xl font-semibold mb-8 text-center text-gray-800">Edit Form</h2>

        <form action="{{ route('account.history.update', $form->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="bg-white p-8 rounded-lg shadow-xl max-w-lg mx-auto">
                <!-- Tanggal Mulai -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Tanggal Mulai:</label>
                    <input type="date" name="tgl_mulai" value="{{ $form->tgl_mulai }}"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-300">
                </div>

                <!-- Tanggal Akhir -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Tanggal Akhir:</label>
                    <input type="date" name="tgl_akhir" value="{{ $form->tgl_akhir }}"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-300">
                </div>

                <!-- Asal Sekolah -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Asal Sekolah:</label>
                    <input type="text" name="asal_sekolah" value="{{ $form->asal_sekolah }}"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-300"
                        placeholder="Masukkan Asal Sekolah">
                </div>

                <!-- Jurusan -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Jurusan:</label>
                    <input type="text" name="jurusan" value="{{ $form->jurusan }}"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-300"
                        placeholder="Masukkan Jurusan">
                </div>

                <!-- Nama Anggota -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Nama Siswa:</label>
                    @foreach ($form->nama as $index => $nama)
                        <input type="text" name="nama[]" value="{{ $nama }}"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-300 mb-3"
                            placeholder="Nama Siswa {{ $index + 1 }}">
                    @endforeach
                </div>

                <!-- Email Anggota -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Email Siswa:</label>
                    @foreach ($form->email as $index => $email)
                        <input type="email" name="email[]" value="{{ $email }}"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-300 mb-3"
                            placeholder="Email Siswa {{ $index + 1 }}">
                    @endforeach
                </div>

                <!-- Ponsel Anggota -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Ponsel Siswa:</label>
                    @foreach ($form->ponsel as $index => $ponsel)
                        <input type="text" name="ponsel[]" value="{{ $ponsel }}"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-300 mb-3"
                            placeholder="Ponsel Siswa {{ $index + 1 }}">
                    @endforeach
                </div>

                <!-- Status -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Status:</label>
                    <input type="text" name="status" value="{{ $form->status }}"
                        class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg" readonly>
                </div>

                <!-- Upload Surat -->
                <div class="mb-6">
                    <label for="surat" class="block text-sm font-medium text-gray-700 mb-2">Surat Pengantar
                        (Opsional)</label>
                    <input type="file" name="surat" id="surat"
                        class="w-full rounded-md border border-gray-300 bg-gray-50 py-2 px-4 text-base focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" />
                    @if ($form->surat)
                        <p class="mt-2">File saat ini:
                            @if (in_array(pathinfo($form->surat, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                                <img src="{{ asset('storage/uploads/' . $form->surat) }}" alt="Surat Pengantar"
                                    class="w-32 h-32 object-cover mt-2" />
                            @elseif (pathinfo($form->surat, PATHINFO_EXTENSION) === 'pdf')
                                <a href="{{ asset('storage/uploads/' . $form->surat) }}"
                                    class="text-blue-500 hover:underline" target="_blank">Lihat PDF</a>
                            @else
                                <a href="{{ asset('storage/uploads/' . $form->surat) }}"
                                    class="text-blue-500 hover:underline" target="_blank">Lihat File</a>
                            @endif
                        </p>
                    @endif
                </div>

                <!-- Submit Button -->
                <div class="flex justify-between items-center">
                    <a href="{{ route('account.history') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-6 rounded-lg transition duration-300">Kembali</a>
                    <button type="submit"
                        class="bg-indigo-500 hover:bg-indigo-600 text-white py-2 px-6 rounded-lg transition duration-300">Update</button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>
