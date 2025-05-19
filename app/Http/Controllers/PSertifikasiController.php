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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function validasi_ajax(Request $request, $id)
    {
        $sertifikasi = PSertifikasiModel::findOrFail($id);

        if ($request->isMethod('post')) {
            $request->validate([
                'status' => 'required|in:Tervalidasi,Tidak Valid',
            ]);

            $sertifikasi->status = $request->input('status');
            $sertifikasi->save();

            return response()->json([
                'status' => true,
                'message' => 'Status berhasil diperbarui',
            ]);
        }

        return view('p_sertifikasi.validasi_ajax', compact('sertifikasi'));
    }

    public function import()
    {
        return view('p_sertifikasi.import');
    }

    public function import_ajax(Request $request)
    {
        $request->validate([
            'file_p_sertifikasi' => 'required|mimes:xlsx,xls|max:2048'
        ]);

        try {
            $file = $request->file('file_p_sertifikasi');
            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, true, true, true);

            $insertData = [];
            $skippedData = [];
            $errors = [];

            $existingCertificates = PSertifikasiModel::pluck('nomor_sertifikat')->toArray();

            foreach ($data as $row => $values) {
                if ($row == 1) continue; // Skip header

                // Skip if certificate number already exists
                if (in_array($values['E'], $existingCertificates)) {
                    $skippedData[] = "Baris $row: Sertifikasi dengan nomor sertifikat {$values['E']} sudah ada dan akan diabaikan";
                    continue;
                }

                $validator = Validator::make([
                    'id_dosen' => $values['A'],
                    'tahun_diperoleh' => $values['B'],
                    'penerbit' => $values['C'],
                    'nama_sertifikasi' => $values['D'],
                    'nomor_sertifikat' => $values['E'],
                    'masa_berlaku' => $values['F'],
                ], [
                    'id_dosen' => 'required|integer|exists:dosen,id',
                    'tahun_diperoleh' => 'required|integer|min:1900|max:' . (date('Y') + 5),
                    'penerbit' => 'required|string|max:255',
                    'nama_sertifikasi' => 'required|string|max:255',
                    'nomor_sertifikat' => 'required|string|max:255|unique:p_sertifikasi,nomor_sertifikat',
                    'masa_berlaku' => 'required|string|max:50', // BUKAN DATE TAPI STRING
                ]);

                if ($validator->fails()) {
                    $errors[] = "Baris $row: " . implode(', ', $validator->errors()->all());
                    continue;
                }

                $insertData[] = [
                    'id_dosen' => $values['A'],
                    'tahun_diperoleh' => $values['B'],
                    'penerbit' => $values['C'],
                    'nama_sertifikasi' => $values['D'],
                    'nomor_sertifikat' => $values['E'],
                    'masa_berlaku' => $values['F'],
                    'status' => 'perlu validasi',
                    'sumber_data' => 'p3m',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $existingCertificates[] = $values['E'];
            }

            $allMessages = array_merge($skippedData, $errors);

            if (empty($insertData)) {
                return response()->json([
                    'status' => false,
                    'alert' => 'error',
                    'message' => 'Tidak ada data baru yang valid untuk diimport',
                    'info' => $allMessages
                ], 422);
            }

            $insertedCount = PSertifikasiModel::insertOrIgnore($insertData);

            $response = [
                'status' => true,
                'alert' => 'success',
                'message' => 'Import data berhasil',
                'inserted_count' => $insertedCount,
                'skipped_count' => count($skippedData),
                'info' => $allMessages
            ];

            if (!empty($errors)) {
                $response['error_count'] = count($errors);
            }

            return response()->json($response, 200, ['Content-Type' => 'application/json']);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'alert' => 'error',
                'message' => 'Terjadi kesalahan saat memproses file',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function export_excel()
    {
        // Join dengan tabel dosen untuk mendapatkan nama lengkap
        $sertifikasi = PSertifikasiModel::join('dosen', 'p_sertifikasi.id_dosen', '=', 'dosen.id_dosen')
            ->select(
                'p_sertifikasi.id_sertifikasi',
                'dosen.nama_lengkap as nama_dosen',
                'p_sertifikasi.tahun_diperoleh',
                'p_sertifikasi.penerbit',
                'p_sertifikasi.nama_sertifikasi',
                'p_sertifikasi.nomor_sertifikat',
                'p_sertifikasi.masa_berlaku',
                'p_sertifikasi.status',
                'p_sertifikasi.sumber_data',
                'p_sertifikasi.created_at',
                'p_sertifikasi.updated_at'
            )
            ->orderBy('p_sertifikasi.id_sertifikasi')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'ID Sertifikasi');
        $sheet->setCellValue('C1', 'Nama Dosen');
        $sheet->setCellValue('D1', 'Tahun Diperoleh');
        $sheet->setCellValue('E1', 'Penerbit');
        $sheet->setCellValue('F1', 'Nama Sertifikasi');
        $sheet->setCellValue('G1', 'Nomor Sertifikat');
        $sheet->setCellValue('H1', 'Masa Berlaku');
        $sheet->setCellValue('I1', 'Status');
        $sheet->setCellValue('J1', 'Sumber Data');
        $sheet->setCellValue('K1', 'Created At');
        $sheet->setCellValue('L1', 'Updated At');

        // Style header
        $sheet->getStyle('A1:L1')->getFont()->setBold(true);

        // Isi data
        $no = 1;
        $row = 2;
        foreach ($sertifikasi as $data) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $data->id_sertifikasi);
            $sheet->setCellValue('C' . $row, $data->nama_dosen);
            $sheet->setCellValue('D' . $row, $data->tahun_diperoleh);
            $sheet->setCellValue('E' . $row, $data->penerbit);
            $sheet->setCellValue('F' . $row, $data->nama_sertifikasi);
            $sheet->setCellValue('G' . $row, $data->nomor_sertifikat);
            $sheet->setCellValue('H' . $row, $data->masa_berlaku);
            $sheet->setCellValue('I' . $row, $data->status);
            $sheet->setCellValue('J' . $row, $data->sumber_data);
            $sheet->setCellValue('K' . $row, $data->created_at);
            $sheet->setCellValue('L' . $row, $data->updated_at);
            $row++;
            $no++;
        }

        // Auto size kolom
        foreach (range('A', 'L') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle("Data Sertifikasi");

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Sertifikasi ' . date("Y-m-d H:i:s") . '.xlsx';

        // Header untuk download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }

    public function export_pdf()
    {
        $query = PSertifikasiModel::with('dosen')->orderBy('id_sertifikasi');

        if ($status = request('filter_status')) {
            $query->where('status', $status);
        }

        if ($sumber = request('filter_sumber')) {
            $query->where('sumber_data', $sumber);
        }

        $sertifikasi = $query->get();

        // Transform data for PDF view
        $data = $sertifikasi->map(function ($item) {
            return [
                'id_sertifikasi' => $item->id_sertifikasi,
                'nama_dosen' => $item->dosen ? $item->dosen->nama_lengkap : '-',
                'tahun_diperoleh' => $item->tahun_diperoleh,
                'penerbit' => $item->penerbit,
                'nama_sertifikasi' => $item->nama_sertifikasi,
                'nomor_sertifikat' => $item->nomor_sertifikat,
                'masa_berlaku' => $item->masa_berlaku,
                'status' => $item->status,
                'sumber_data' => $item->sumber_data,
                'bukti' => $item->bukti,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at
            ];
        });

        $pdf = Pdf::loadView('p_sertifikasi.export_pdf', [
            'sertifikasi' => $data
        ]);

        $pdf->setPaper('a4', 'landscape'); // Landscape for better fit
        $pdf->setOption('isRemoteEnabled', true);
        $pdf->setOption('isHtml5ParserEnabled', true);
        $pdf->setOption('chroot', base_path('public'));

        return $pdf->stream('Data Sertifikasi ' . date('d-m-Y H:i:s') . '.pdf');
    }
}
