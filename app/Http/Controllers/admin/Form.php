<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Forms;
use Illuminate\Http\Request;

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
        $forms = $query->orderBy('created_at', 'DESC')->paginate(10);

        // Mengembalikan view dengan data yang dibutuhkan
        return view('admin.dashboard', [
            'forms' => $forms,
            'totalPengajuan' => $totalPengajuan,
            'totalDiterima' => $totalDiterima,
            'totalDitolak' => $totalDitolak,
        ]);
    }


    public function show($id)
    {
        $form = Forms::find($id);
        if (!$form) {
            return redirect()->route('admin.dashboard')->with('error', 'Form not found');
        }

        // Pisahkan nama, email, dan ponsel ke dalam array
        $form->nama = explode(',', $form->nama);
        $form->email = explode(',', $form->email);
        $form->ponsel = explode(',', $form->ponsel);

        return view('admin.detail', compact('form'));
    }

    public function updateStatus(Request $request, $id)
    {
        $form = Forms::find($id);
        if (!$form) {
            return redirect()->route('admin.dashboard')->with('error', 'Form tidak ditemukan');
        }

        $form->status = $request->status;
        $form->save();

        return redirect()->route('admin.dashboard')->with('success', 'Status berhasil diperbarui');
    }

    public function destroy($id)
    {
        $form = Forms::find($id);

        if (!$form) {
            return redirect()->route('admin.dashboard')->with('error', 'Data tidak ditemukan');
        }

        // Hapus data
        $form->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Data berhasil dihapus');
    }
}
