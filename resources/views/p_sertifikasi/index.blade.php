@extends('layout.app')

@section('title', 'Sertifikasi')
@section('subtitle', 'Sertifikasi')

@section('content_header')
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item active">Sertifikasi</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="container-fluid">
        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Manajemen Sertifikasi</h2>
            <div>
                <button onclick="modalAction('{{ route('p_sertifikasi.create_ajax') }}')" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Data
                </button>
            </div>
        </div>

        {{-- DataTable --}}
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">Daftar Sertifikasi</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    {{ $dataTable->table([
                        'id' => 'p_sertifikasi-table',
                        'class' => 'table table-hover table-bordered table-striped',
                        'style' => 'width:100%',
                    ]) }}
                </div>
            </div>
        </div>

        {{-- Modal --}}
        <div id="myModal" class="modal fade" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- Konten modal akan diisi secara dinamis -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}
    <script>
        function modalAction(url) {
            $.get(url)
                .done(function(response) {
                    $('#myModal .modal-content').html(response);
                    $('#myModal').modal('show');

                    $(document).off('submit', '#formCreateSertifikasi, #formEditSertifikasi');

                    $(document).on('submit', '#formCreateSertifikasi, #formEditSertifikasi', function(e) {
                        e.preventDefault();
                        var form = $(this);
                        var formData = new FormData(form[0]);

                        $.ajax({
                            url: form.attr('action'),
                            method: form.find('input[name="_method"]').val() || form.attr('method'),
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(res) {
                                $('#myModal').modal('hide');
                                window.LaravelDataTables["p_sertifikasi-table"].ajax.reload();
                                if (res.alert && res.message) {
                                    Swal.fire({
                                        icon: res.alert,
                                        title: res.alert === 'success' ? 'Sukses' : 'Error',
                                        text: res.message,
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                }
                            },
                            error: function(xhr) {
                                $('#myModal').modal('hide');
                                window.LaravelDataTables["p_sertifikasi-table"].ajax.reload();
                                if (xhr.responseJSON && xhr.responseJSON.alert && xhr.responseJSON.message) {
                                    Swal.fire({
                                        icon: xhr.responseJSON.alert,
                                        title: xhr.responseJSON.alert === 'success' ? 'Sukses' : 'Error',
                                        text: xhr.responseJSON.message,
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                } else {
                                    Swal.fire('Error!', 'Gagal menyimpan data.', 'error');
                                }
                            }
                        });
                    });
                })
                .fail(function(xhr) {
                    Swal.fire('Error!', 'Gagal memuat form: ' + xhr.statusText, 'error');
                });
        }

        $(document).on('submit', '#formDeleteSertifikasi', function(e) {
            e.preventDefault();
            var form = $(this);
            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                success: function(response) {
                    $('#myModal').modal('hide');
                    window.LaravelDataTables["p_sertifikasi-table"].ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Data sertifikasi berhasil dihapus.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Tidak dapat menghapus data sertifikasi.'
                    });
                }
            });
        });
    </script>
@endpush
