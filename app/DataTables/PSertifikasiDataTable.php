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

class PSertifikasiDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('aksi', function ($row) {
                $validasiUrl = route('p_sertifikasi.validasi_ajax', $row->id_sertifikasi);
                $detailUrl = route('p_sertifikasi.detail_ajax', $row->id_sertifikasi);
                $editUrl = route('p_sertifikasi.edit_ajax', $row->id_sertifikasi);
                $deleteUrl = route('p_sertifikasi.confirm_ajax', $row->id_sertifikasi);

                return '
                    <div class="d-flex justify-content-center gap-2" style="white-space: nowrap;">
                        <button onclick="modalAction(\'' . $validasiUrl . '\')" class="btn btn-sm btn-warning" style="margin-left: 5px;">
                            <i class="fas fa-check-circle"></i> Validasi
                        </button>
                        <button onclick="modalAction(\'' . $detailUrl . '\')" class="btn btn-sm btn-info" style="margin-left: 5px;">
                            <i class="fas fa-info-circle"></i> Detail
                        </button>
                        <button onclick="modalAction(\'' . $editUrl . '\')" class="btn btn-sm btn-primary" style="margin-left: 5px;">
                            <i class="fas fa-edit"></i> Ubah
                        </button>
                        <button onclick="modalAction(\'' . $deleteUrl . '\')" class="btn btn-sm btn-danger" style="margin-left: 5px;">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </div>
                ';
            })

            ->addColumn('nama_lengkap', function ($row) {
                return $row->dosen->nama_lengkap ?? '-';
            })

            // Tambahkan badge untuk status dan sumber data (GUNAKAN EDITCOLUMN AGAR BISA DI SORT DAN SEARCH)
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
        $query = $model->newQuery()->with('dosen');

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
        return $this->builder()
            ->setTableId('p_sertifikasi-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id_sertifikasi')->title('ID'),
            Column::make('nama_lengkap')->title('Nama Dosen'),
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
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'PSertifikasi_' . date('YmdHis');
    }
}
