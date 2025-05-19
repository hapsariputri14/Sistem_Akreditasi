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
            ->addColumn('aksi', 'psertifikasi.aksi')
            ->setRowId('id_sertifikasi');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(PSertifikasiModel $model): QueryBuilder
    {
        return $model->newQuery()
            ->select('p_sertifikasi.*', 'dosen.nama_lengkap as dosen_name')
            ->leftJoin('dosen', 'p_sertifikasi.id_dosen', '=', 'dosen.id_dosen');
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
            Column::make('dosen_name')->title('Nama Dosen'),
            Column::make('tahun_diperoleh')->title('Tahun Diperoleh'),
            Column::make('penerbit')->title('Penerbit'),
            Column::make('nama_sertifikasi')->title('Nama Sertifikasi'),
            Column::make('nomor_sertifikat')->title('Nomor Sertifikat'),
            Column::make('masa_berlaku')->title('Masa Berlaku'),
            Column::make('status')->title('Status'),
            Column::make('sumber_data')->title('Sumber Data'),
            Column::make('created_at')->title('Created At'),
            Column::make('updated_at')->title('Updated At'),
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
