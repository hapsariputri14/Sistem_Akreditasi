<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PSertifikasiModel;
use App\Models\DosenModel;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\DataTables\PSertifikasiDataTable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PSertifikasiController extends Controller
{
    public function index(PSertifikasiDataTable $dataTable)
    {
        return $dataTable->render('p_sertifikasi.index');
    }

    public function create_ajax()
    {
        $dosens = DosenModel::all();
        return view('p_sertifikasi.create_ajax', compact('dosens'));
    }


    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'tahun_diperoleh' => 'required|integer',
                'penerbit' => 'required|string|max:255',
                'nama_sertifikasi' => 'required|string|max:255',
                'nomor_sertifikat' => 'required|string|max:255',
                'masa_berlaku' => 'required|string|max:50',
                'bukti' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'alert' => 'error',
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            try {
                /** @var UserModel|null $user */
                $user = Auth::user();
                $id_dosen = $user->id_dosen; // sesuaikan sesuai relasi user ke dosen

                if (!$id_dosen) {
                    return response()->json([
                        'status' => false,
                        'alert' => 'error',
                        'message' => 'ID dosen tidak ditemukan. Pastikan akun user terkait dosen.',
                    ]);
                }

                $data = $request->only([
                    'tahun_diperoleh',
                    'penerbit',
                    'nama_sertifikasi',
                    'nomor_sertifikat',
                    'masa_berlaku',
                ]);

                $data['id_dosen'] = $id_dosen;

                // Set status otomatis berdasarkan role user
                if ($user->hasRole('DOS')) {
                    $data['status'] = 'Tervalidasi';
                    $data['sumber_data'] = 'dosen';
                } elseif ($user->hasRole('ADM')) {
                    // Bisa kamu set default "Perlu Validasi" atau bisa ambil dari input request kalau kamu mau
                    $data['status'] = 'Perlu Validasi';
                    $data['sumber_data'] = 'p3m';
                } else {
                    // fallback kalau ada role lain
                    $data['status'] = $request->input('status', 'Perlu Validasi');
                    $data['sumber_data'] = $request->input('sumber_data', 'p3m');
                }

                if ($request->hasFile('bukti')) {
                    $file = $request->file('bukti');
                    $path = $file->store('public/p_sertifikasi');
                    $data['bukti'] = basename($path);
                }

                PSertifikasiModel::create($data);

                return response()->json([
                    'status' => true,
                    'alert' => 'success',
                    'message' => 'Data sertifikasi berhasil disimpan'
                ]);
            } catch (\Exception $e) {
                Log::error('Exception in store_ajax: ' . $e->getMessage());
                return response()->json([
                    'status' => false,
                    'alert' => 'error',
                    'message' => 'Gagal menyimpan data sertifikasi',
                ]);
            }
        }

        return response()->json([
            'status' => false,
            'alert' => 'error',
            'message' => 'Request tidak valid'
        ], 400);
    }

    public function edit_ajax($id)
    {
        $sertifikasi = PSertifikasiModel::findOrFail($id);
        return view('p_sertifikasi.edit_ajax', compact('sertifikasi'));
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'tahun_diperoleh' => 'required|integer',
                'penerbit' => 'required|string|max:255',
                'nama_sertifikasi' => 'required|string|max:255',
                'nomor_sertifikat' => 'required|string|max:255',
                'masa_berlaku' => 'required|string|max:50',
                'bukti' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'alert' => 'error',
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            $sertifikasi = PSertifikasiModel::findOrFail($id);

            try {
                $data = $request->only([
                    'tahun_diperoleh',
                    'penerbit',
                    'nama_sertifikasi',
                    'nomor_sertifikat',
                    'masa_berlaku',
                    'bukti',
                ]);

                if ($request->hasFile('bukti')) {
                    // Delete old file if exists
                    if ($sertifikasi->bukti && Storage::exists('public/p_sertifikasi/' . $sertifikasi->bukti)) {
                        Storage::delete('public/p_sertifikasi/' . $sertifikasi->bukti);
                    }
                    $file = $request->file('bukti');
                    $path = $file->store('public/p_sertifikasi');
                    $data['bukti'] = basename($path);
                }

                $sertifikasi->update($data);

                return response()->json([
                    'status' => true,
                    'alert' => 'success',
                    'message' => 'Data sertifikasi berhasil diupdate'
                ]);
            } catch (\Exception $e) {
                Log::error('Exception in update_ajax: ' . $e->getMessage());
                return response()->json([
                    'status' => false,
                    'alert' => 'error',
                    'message' => 'Gagal mengupdate data sertifikasi',
                ]);
            }
        }

        return response()->json([
            'status' => false,
            'alert' => 'error',
            'message' => 'Request tidak valid'
        ], 400);
    }

    public function confirm_ajax($id)
    {
        $sertifikasi = PSertifikasiModel::findOrFail($id);
        return view('p_sertifikasi.confirm_ajax', compact('sertifikasi'));
    }

    public function delete_ajax(Request $request, $id)
    {
        $sertifikasi = PSertifikasiModel::findOrFail($id);

        try {
            if ($sertifikasi->bukti && Storage::exists('public/p_sertifikasi/' . $sertifikasi->bukti)) {
                Storage::delete('public/p_sertifikasi/' . $sertifikasi->bukti);
            }
            $sertifikasi->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            Log::error('Exception in delete_ajax: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data'
            ]);
        }
    }

    public function detail_ajax($id)
    {
        $sertifikasi = PSertifikasiModel::with('dosen')->findOrFail($id);
        return view('p_sertifikasi.detail_ajax', compact('sertifikasi'));
    }
}
