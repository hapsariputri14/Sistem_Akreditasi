<?php

namespace App\DataTables;

use App\Models\PSertifikasiModel;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Auth;

class PSertifikasiDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        /** @var UserModel|null $user */
        $user = Auth::user();
        $role = $user->getRole();
        $isDos = $user->hasRole('DOS');
        $isAdm = $user->hasRole('ADM');
        $isAng = preg_match('/^ANG[1-9]$/', $role);

        return (new EloquentDataTable($query))
            ->addColumn('aksi', function ($row) use ($user, $isDos, $isAdm) {
                $buttons = [];
                $detailUrl = route('p_sertifikasi.detail_ajax', $row->id_sertifikasi);

                // Button detail - muncul untuk semua role
                $buttons[] = '<button onclick="modalAction(\'' . $detailUrl . '\')" class="btn btn-sm btn-info">
                    <i class="fas fa-info-circle"></i> Detail
                </button>';

                // Button validasi - hanya untuk DOS
                if ($isDos) {
                    $validasiUrl = route('p_sertifikasi.validasi_ajax', $row->id_sertifikasi);
                    $buttons[] = '<button onclick="modalAction(\'' . $validasiUrl . '\')" class="btn btn-sm btn-warning">
                        <i class="fas fa-check-circle"></i> Validasi
                    </button>';
                }

                // Button ubah dan hapus - hanya untuk DOS
                if ($isDos || $isAdm) {
                    $editUrl = route('p_sertifikasi.edit_ajax', $row->id_sertifikasi);
                    $deleteUrl = route('p_sertifikasi.confirm_ajax', $row->id_sertifikasi);

                    $buttons[] = '<button onclick="modalAction(\'' . $editUrl . '\')" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit"></i> Ubah
                    </button>';

                    $buttons[] = '<button onclick="modalAction(\'' . $deleteUrl . '\')" class="btn btn-sm btn-danger">
                        <i class="fas fa-trash"></i> Hapus
                    </button>';
                }

                return '<div class="d-flex justify-content-center gap-2" style="white-space: nowrap;">' .
                    implode('', $buttons) .
                    '</div>';
            })
            ->addColumn('nama_lengkap', function ($row) use ($isDos) {
                // Kolom nama_lengkap tidak ditampilkan untuk DOS
                return $isDos ? '-' : ($row->dosen->nama_lengkap ?? '-');
            })
            ->editColumn('status', function ($row) {
                $badgeClass = [
                    'tervalidasi' => 'badge-success',
                    'perlu validasi' => 'badge-warning',
                    'tidak valid' => 'badge-danger'
                ];
                return '<span class="badge p-2 ' . ($badgeClass[$row->status] ?? 'badge-secondary') . '">'
                    . strtoupper($row->status) . '</span>';
            })
            ->editColumn('sumber_data', function ($row) {
                $badgeClass = [
                    'p3m' => 'badge-primary',
                    'dosen' => 'badge-secondary'
                ];
                return '<span class="badge p-2 ' . ($badgeClass[$row->sumber_data] ?? 'badge-dark') . '">'
                    . strtoupper($row->sumber_data) . '</span>';
            })
            ->rawColumns(['aksi', 'status', 'sumber_data'])
            ->setRowId('id_sertifikasi');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(PSertifikasiModel $model): QueryBuilder
    {
        /** @var UserModel|null $user */
        $user = Auth::user();
        $query = $model->newQuery()->with('dosen');

        // Jika role DOS, hanya tampilkan data dosen tersebut
        if ($user->hasRole('DOS') && $user->id_dosen) {
            $query->where('id_dosen', $user->id_dosen);
        }

        if ($status = request('filter_status')) {
            $query->where('status', $status);
        }

        if ($sumber = request('filter_sumber')) {
            $query->where('sumber_data', $sumber);
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        /** @var UserModel|null $user */
        $user = Auth::user();
        $role = $user->getRole();
        $isAdm = $user->hasRole('ADM');
        $isAng = preg_match('/^ANG[1-9]$/', $role);

        $builder = $this->builder()
            ->setTableId('p_sertifikasi-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle();

        // Button untuk ADM hanya import dan export
        if ($isAdm) {
            $builder->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
        }
        // Button untuk ANG hanya detail
        elseif ($isAng) {
            $builder->buttons([
                Button::make('reset'),
                Button::make('reload')
            ]);
        }
        // Button default untuk role lainnya
        else {
            $builder->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
        }

        return $builder;
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        /** @var UserModel|null $user */
        $user = Auth::user();
        $role = $user->getRole();
        $isDos = $user->hasRole('DOS');

        $columns = [
            Column::make('id_sertifikasi')->title('ID'),
            Column::make('tahun_diperoleh')->title('Tahun Diperoleh'),
            Column::make('penerbit')->title('Penerbit'),
            Column::make('nama_sertifikasi')->title('Nama Sertifikasi'),
            Column::make('nomor_sertifikat')->title('Nomor Sertifikat'),
            Column::make('masa_berlaku')->title('Masa Berlaku'),
            Column::make('status')->title('Status')->addClass('text-center'),
            Column::make('sumber_data')->title('Sumber Data')->addClass('text-center'),
            Column::computed('aksi')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];

        // Tambahkan kolom nama_lengkap jika bukan DOS
        if (!$isDos) {
            array_splice($columns, 1, 0, [
                Column::make('nama_lengkap')->title('Nama Dosen')
            ]);
        }

        return $columns;
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'PSertifikasi_' . date('YmdHis');
    }
}
