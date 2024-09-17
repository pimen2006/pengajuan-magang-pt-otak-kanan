<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Formulir Anggota</title>
    <style>
        .hidden {
            display: none;
        }

        .kurangi-anggota {
            margin-top: 10px;
        }

        .tambah-anggota {
            margin-top: 10px;
        }

        .hover\:bg-blue-800:hover {
            background-color: #2b6cb0;
        }

        .hover\:bg-red-800:hover {
            background-color: #c53030;
        }

        /* Customizing transition for hover effects */
        .transition-all {
            transition: all 0.3s ease;
        }
    </style>
</head>

<body class="bg-gradient-to-r from-blue-100 via-blue-200 to-purple-100 min-h-screen flex items-center justify-center">
    <div class="container mx-auto p-4">
        <div class="w-full max-w-lg mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="py-6 px-8">
                <form action="{{ route('account.form.store') }}" method="post" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="tgl_mulai" class="block text-sm font-medium text-gray-700 mb-2">Tgl
                                Mulai</label>
                            <input type="date" name="tgl_mulai" id="tgl_mulai" value="{{ old('tgl_mulai') }}"
                                class="@error('tgl_mulai') is-invalid @enderror w-full rounded-md border border-gray-300 bg-gray-50 py-2 px-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" />
                            @error('tgl_mulai')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="tgl_akhir" class="block text-sm font-medium text-gray-700 mb-2">Tgl
                                Berakhir</label>
                            <input type="date" name="tgl_akhir" id="tgl_akhir" value="{{ old('tgl_akhir') }}"
                                class="@error('tgl_akhir') is-invalid @enderror w-full rounded-md border border-gray-300 bg-gray-50 py-2 px-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" />
                            @error('tgl_akhir')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div id="anggota-container" class="space-y-4">
                        <div class="anggota" data-index="1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Anggota 1*</label>
                            <input type="text" name="nama[]" placeholder="Nama Anggota 1*"
                                value="{{ old('nama') }}"
                                class="@error('nama') is-invalid @enderror w-full mb-2 rounded-md border border-gray-300 bg-gray-50 py-2 px-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" />
                            @error('nama')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror

                            <label class="block text-sm font-medium text-gray-700 mb-2">No WhatsApp</label>
                            <input type="text" name="ponsel[]" placeholder="No WhatsApp" value="{{ old('ponsel') }}"
                                class="@error('ponsel') is-invalid @enderror w-full mb-2 rounded-md border border-gray-300 bg-gray-50 py-2 px-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" />
                            @error('ponsel')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror

                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="text" name="email[]" placeholder="Email" value="{{ old('email') }}"
                                class="@error('email') is-invalid @enderror w-full rounded-md border border-gray-300 bg-gray-50 py-2 px-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" />
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror

                            <div class="flex space-x-4">
                                <button type="button"
                                    class="kurangi-anggota rounded-md bg-red-500 py-2 px-4 text-white font-semibold hidden hover:bg-red-700 transition-all">
                                    Kurangi
                                </button>
                                <button type="button" id="tambah-anggota"
                                    class="tambah-anggota rounded-md bg-blue-500 py-2 px-4 text-white font-semibold hover:bg-blue-600 transition-all">
                                    Tambah Anggota
                                </button>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="asal_sekolah" class="block text-sm font-medium text-gray-700 mb-2">Asal
                            Sekolah/Kampus</label>
                        <input type="text" name="asal_sekolah" id="asal_sekolah" value="{{ old('asal_sekolah') }}"
                            class="@error('asal_sekolah') is-invalid @enderror w-full rounded-md border border-gray-300 bg-gray-50 py-2 px-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" />
                        @error('asal_sekolah')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jurusan" class="block text-sm font-medium text-gray-700 mb-2">Jurusan</label>
                        <input type="text" name="jurusan" id="jurusan" value="{{ old('jurusan') }}"
                            class="@error('jurusan') is-invalid @enderror w-full rounded-md border border-gray-300 bg-gray-50 py-2 px-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" />
                        @error('jurusan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="surat" class="block text-sm font-medium text-gray-700 mb-2">Surat Pengantar
                            (Opsional)</label>
                        <input type="file" name="surat" id="surat"
                            class="w-full rounded-md border border-gray-300 bg-gray-50 py-2 px-4 text-base focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                            accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" />

                    </div>


                    <div class="flex justify-between items-center">
                        <a href="{{ route('account.dashboard') }}"
                            class="rounded-md bg-gray-500 py-2 px-6 text-white font-semibold hover:bg-gray-600 transition-all">Back</a>
                        <button type="submit"
                            class="rounded-md bg-blue-500 py-2 px-6 text-white font-semibold hover:bg-blue-600 transition-all">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let index = 1;

        function updateIndex() {
            const anggotaList = document.querySelectorAll('.anggota');
            anggotaList.forEach((anggota, idx) => {
                anggota.setAttribute('data-index', idx + 1);
                anggota.querySelectorAll('input').forEach(input => {
                    const placeholder = input.placeholder.replace(/\d+/, idx + 1);
                    input.placeholder = placeholder;
                });
                const kurangiButton = anggota.querySelector('.kurangi-anggota');
                if (kurangiButton) {
                    kurangiButton.classList.toggle('hidden', idx === 0);
                }
                const tambahButton = anggota.querySelector('#tambah-anggota');
                if (tambahButton) {
                    tambahButton.classList.toggle('hidden', idx !== 0);
                }
            });
            index = anggotaList.length;
        }

        document.getElementById('tambah-anggota').addEventListener('click', function() {
            const container = document.getElementById('anggota-container');
            const anggotaList = container.querySelectorAll('.anggota');
            const anggotaBaru = anggotaList[0].cloneNode(true);
            index++;

            anggotaBaru.setAttribute('data-index', index);
            anggotaBaru.querySelectorAll('input').forEach(input => {
                input.value = '';
                const placeholder = input.placeholder;
                input.placeholder = placeholder.replace(/\d+/, index);
            });

            anggotaBaru.querySelector('.kurangi-anggota').classList.remove('hidden');

            container.appendChild(anggotaBaru);
            updateIndex();
        });

        document.getElementById('anggota-container').addEventListener('click', function(event) {
            if (event.target.classList.contains('kurangi-anggota')) {
                const anggotaList = document.querySelectorAll('.anggota');
                if (anggotaList.length > 1) {
                    event.target.closest('.anggota').remove();
                    updateIndex();
                }
            }
        });

        updateIndex();
    </script>
</body>

</html>
