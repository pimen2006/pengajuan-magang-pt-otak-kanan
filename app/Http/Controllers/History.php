<?php

namespace App\Http\Controllers;

use App\Models\Forms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class History extends Controller
{
    public function index()
    {
        $user_id = Auth::id(); // Mendapatkan ID user yang sedang login

        // Mengambil data forms yang milik user yang sedang login
        $forms = Forms::where('user_id', $user_id)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('history', ['forms' => $forms]);
    }

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

        return view('detailhistory', compact('form'));
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

        return view('edithistory', compact('form'));
    }


    // app/Http/Controllers/Form.php

    public function update(Request $request, $id)
    {
        $form = Forms::find($id);

        // Cek apakah form ada dan apakah user yang mengakses adalah pemilik form
        if (!$form || $form->user_id != Auth::id()) {
            return redirect()->route('account.history')->with('error', 'Anda tidak memiliki izin untuk mengubah form ini.');
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

        return redirect()->route('account.history')->with('success', 'Form berhasil diperbarui');
    }


    // app/Http/Controllers/Form.php

    public function destroy($id)
    {
        $form = Forms::find($id);

        // Cek apakah form ada dan apakah user yang mengakses adalah pemilik form
        if (!$form || $form->user_id != Auth::id()) {
            return redirect()->route('account.history')->with('error', 'Anda tidak memiliki izin untuk menghapus form ini.');
        }

        // Hapus data
        $form->delete();

        return redirect()->route('account.history')->with('success', 'Form berhasil dihapus');
    }
}
