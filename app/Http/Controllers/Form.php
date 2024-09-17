<?php

namespace App\Http\Controllers;

use App\Models\Forms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class Form extends Controller
{
    public function index(Request $request)
    {
        // Perhitungan total pengajuan
        $totalPengajuan = Forms::count();

        // Perhitungan total diterima
        $totalDiterima = Forms::where('status', 'Terima')->count();

        // Perhitungan total ditolak
        $totalDitolak = Forms::where('status', 'Tolak')->count();

        // Mendapatkan term pencarian dari request
        $searchTerm = $request->input('search');

        // Query model Forms dengan atau tanpa filter pencarian
        $query = Forms::query();

        if ($searchTerm) {
            // Jika ada input search, filter berdasarkan 'asal_sekolah'
            $query->where('asal_sekolah', 'like', '%' . $searchTerm . '%');
        }

        // Mengambil data form dan melakukan paginasi
        $forms = $query->orderBy('created_at', 'DESC')->paginate(5);

        // Mengembalikan view dengan data yang dibutuhkan
        return view('dashboard', [
            'forms' => $forms,
            'totalPengajuan' => $totalPengajuan,
            'totalDiterima' => $totalDiterima,
            'totalDitolak' => $totalDitolak,
        ]);
    }

    public function create()
    {
        return view('form.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'tgl_mulai' => 'required|date',
            'tgl_akhir' => 'required|date',
            'nama.*' => 'required',
            'ponsel.*' => 'required',
            'email.*' => 'required|email',
            'asal_sekolah' => 'required',
            'jurusan' => 'required',
            'surat' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx',
        ];

        $messages = [
            'tgl_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tgl_akhir.required' => 'Tanggal akhir wajib diisi.',
            'nama.*.required' => 'Nama setiap anggota wajib diisi.',
            'ponsel.*.required' => 'Nomor ponsel setiap anggota wajib diisi.',
            'email.*.required' => 'Email setiap anggota wajib diisi.',
            'email.*.email' => 'Format email tidak valid.',
            'asal_sekolah.required' => 'Nama sekolah wajib diisi.',
            'jurusan.required' => 'Jurusan wajib diisi.',
            'surat.mimes' => 'File harus berupa gambar (jpg, jpeg, png) atau dokumen (pdf, doc, docx).',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->route('account.form.create')
                ->withInput()
                ->withErrors($validator);
        }


        $dataPerSekolah = [];

        foreach ($request->nama as $key => $namaAnggota) {
            $asalSekolah = $request->asal_sekolah;

            if (!isset($dataPerSekolah[$asalSekolah])) {
                $dataPerSekolah[$asalSekolah] = [
                    'tgl_mulai' => $request->tgl_mulai,
                    'tgl_akhir' => $request->tgl_akhir,
                    'nama' => [],
                    'ponsel' => [],
                    'email' => [],
                    'jurusan' => $request->jurusan,
                ];
            }

            $dataPerSekolah[$asalSekolah]['nama'][] = $namaAnggota;
            $dataPerSekolah[$asalSekolah]['ponsel'][] = $request->ponsel[$key];
            $dataPerSekolah[$asalSekolah]['email'][] = $request->email[$key];
        }

        foreach ($dataPerSekolah as $asalSekolah => $data) {
            $form = new Forms();
            $form->user_id = Auth::id();
            $form->tgl_mulai = $data['tgl_mulai'];
            $form->tgl_akhir = $data['tgl_akhir'];
            $form->nama = implode(',', $data['nama']);
            $form->ponsel = implode(',', $data['ponsel']);
            $form->email = implode(',', $data['email']);
            $form->asal_sekolah = $asalSekolah;
            $form->jurusan = $data['jurusan'];
            $form->jumlah_siswa = count($data['nama']);
            $form->status = 'WAIT';
            $form->save();


            if ($request->hasFile('surat')) {
                $file = $request->file('surat');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads', $fileName, 'public');
                
                $form->surat = $fileName;  
            }          
        }
        $form->save();  

        return redirect()->route('account.dashboard')->with('success', 'Data berhasil disimpan');
    }

    // app/Http/Controllers/Form.php

    public function show($id)
    {
        $form = Forms::find($id);

        // Cek apakah form ada dan apakah user yang mengakses adalah pemilik form
        if (!$form || $form->user_id != Auth::id()) {
            return redirect()->route('account.dashboard')->with('error', 'Anda tidak memiliki izin untuk melihat form ini.');
        }

        // Pisahkan nama, email, dan ponsel ke dalam array
        $form->nama = explode(',', $form->nama);
        $form->email = explode(',', $form->email);
        $form->ponsel = explode(',', $form->ponsel);

        return view('form.detail', compact('form'));
    }


    // app/Http/Controllers/Form.php

    public function edit($id)
    {
        $form = Forms::find($id);

        // Cek apakah form ada dan apakah user yang mengakses adalah pemilik form
        if (!$form || $form->user_id != Auth::id()) {
            return redirect()->route('account.dashboard')->with('error', 'Anda tidak memiliki izin untuk mengedit form ini.');
        }

        // Pisahkan nama, email, dan ponsel ke dalam array
        $form->nama = explode(',', $form->nama);
        $form->email = explode(',', $form->email);
        $form->ponsel = explode(',', $form->ponsel);

        return view('form.edit', compact('form'));
    }


    // app/Http/Controllers/Form.php

    public function update(Request $request, $id)
    {
        $form = Forms::find($id);

        // Cek apakah form ada dan apakah user yang mengakses adalah pemilik form
        if (!$form || $form->user_id != Auth::id()) {
            return redirect()->route('account.dashboard')->with('error', 'Anda tidak memiliki izin untuk mengubah form ini.');
        }

        // Validasi data yang diubah
        $rules = [
            'tgl_mulai' => 'required|date',
            'tgl_akhir' => 'required|date',
            'nama.*' => 'required',
            'ponsel.*' => 'required',
            'email.*' => 'required|email',
            'asal_sekolah' => 'required',
            'jurusan' => 'required',
            'surat' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update data
        $form->tgl_mulai = $request->tgl_mulai;
        $form->tgl_akhir = $request->tgl_akhir;
        $form->nama = implode(',', $request->nama);
        $form->ponsel = implode(',', $request->ponsel);
        $form->email = implode(',', $request->email);
        $form->asal_sekolah = $request->asal_sekolah;
        $form->jurusan = $request->jurusan;
        $form->surat = $request->surat;
        $form->status = $request->status;

        if ($request->hasFile('surat')) {
            // Hapus file yang lama
            if ($form->surat) {
                Storage::delete('public/uploads/' . $form->surat);
            }

            $file = $request->file('surat');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/uploads', $filename);
            $form->surat = $filename;
        }
        $form->save();

        return redirect()->route('account.dashboard')->with('success', 'Form berhasil diperbarui');
    }


    // app/Http/Controllers/Form.php

    public function destroy($id)
    {
        $form = Forms::find($id);

        // Cek apakah form ada dan apakah user yang mengakses adalah pemilik form
        if (!$form || $form->user_id != Auth::id()) {
            return redirect()->route('account.dashboard')->with('error', 'Anda tidak memiliki izin untuk menghapus form ini.');
        }

        // Hapus data
        $form->delete();

        return redirect()->route('account.dashboard')->with('success', 'Form berhasil dihapus');
    }
}
