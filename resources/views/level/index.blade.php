@extends('layout.app')

@section('title', 'Level')
@section('subtitle', 'Level')

@section('content_header')
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item active">Level</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="container-fluid">
        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Manajemen Level</h2>
            <div>
                <a class="btn btn-primary me-2" href="{{ route('level.export_pdf') }}">
                    <i class="fa-solid fa-file-pdf"></i> Export Data - PDF
                </a>
                <a class="btn btn-primary me-2" href="{{ route('level.export_excel') }}">
                    <i class="fas fa-file-excel"></i> Export Data - Excel
                </a>
                <button class="btn btn-primary me-2" onclick="modalAction('{{ route('level.import') }}')">
                    <i class="fa-solid fa-file-arrow-up"></i> Import Data
                </button>
                <button onclick="modalAction('{{ route('level.create_ajax') }}')" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Data
                </button>
            </div>
        </div>

        {{-- DataTable --}}
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">Daftar Level</h3>
            </div>
            <div class="card-body">
                {{-- Filter --}}
                <div class="mb-3">
                    <label for="id_level" class="form-label">Filter Level:</label>
                    <select class="form-select w-100" name="id_level" id="id_level" required>
                        <option value="">-- Semua Level --</option>
                        @foreach ($id_level as $item)
                            <option value="{{ $item->id_level }}">{{ $item->nama_level }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="table-responsive">
                    {{ $dataTable->table([
                        'id' => 'level-table',
                        'class' => 'table table-hover table-bordered table-striped',
                        'style' => 'width:100%',
                    ]) }}
                </div>
            </div>
        </div>

        {{-- Modal --}}
        <div id="myModal" class="modal fade" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
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
                    $('#myModal').modal('show'); // Cara Bootstrap 4 untuk menampilkan modal

                    // Reset all event listeners
                    $(document).off('submit', '#formCreateLevel, #formEditLevel, #form-import');

                    // Handle create/edit form submit
                    $(document).on('submit', '#formCreateLevel, #formEditLevel', function(e) {
                        e.preventDefault();
                        var form = $(this);

                        $.ajax({
                            url: form.attr('action'),
                            method: form.find('input[name="_method"]').val() || form.attr('method'),
                            data: form.serialize(),
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(res) {
                                $('#myModal').modal(
                                    'hide'); // Cara Bootstrap 4 untuk menyembunyikan modal
                                window.LaravelDataTables["level-table"].ajax.reload();
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
                                window.LaravelDataTables["level-table"].ajax.reload();
                                if (xhr.responseJSON && xhr.responseJSON.alert && xhr.responseJSON
                                    .message) {
                                    Swal.fire({
                                        icon: xhr.responseJSON.alert,
                                        title: xhr.responseJSON.alert === 'success' ?
                                            'Sukses' : 'Error',
                                        text: xhr.responseJSON.message,
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                } else {
                                    Swal.fire('Error!',
                                        'Gagal menyimpan data karena duplikat Kode Level.',
                                        'error');
                                }
                            }
                        });
                    });

                    $(document).off('submit', '#form-import');

                    // Handle import form submit
                    $(document).on('submit', '#form-import', function(e) {
                        e.preventDefault();
                        var form = $(this);
                        var formData = new FormData(form[0]);
                        var submitBtn = form.find('button[type="submit"]');

                        submitBtn.prop('disabled', true).html(
                            '<i class="fas fa-spinner fa-spin me-1"></i> Memproses...');

                        $.ajax({
                            url: form.attr('action'),
                            method: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                $('#myModal').modal('hide');
                                if (response.alert && response.message) {
                                    Swal.fire({
                                        icon: response.alert,
                                        title: response.alert === 'success' ? 'Sukses' :
                                            'Error',
                                        text: response.message,
                                        timer: 2000,
                                        showConfirmButton: false
                                    }).then(() => {
                                        window.LaravelDataTables["level-table"].ajax
                                            .reload();
                                    });
                                }
                            },
                            error: function(xhr) {
                                $('#myModal').modal('hide');
                                if (xhr.responseJSON && xhr.responseJSON.alert && xhr.responseJSON
                                    .message) {
                                    Swal.fire({
                                        icon: xhr.responseJSON.alert,
                                        title: xhr.responseJSON.alert === 'success' ?
                                            'Sukses' : 'Error',
                                        text: xhr.responseJSON.message,
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: xhr.responseJSON.message
                                    });
                                }
                            },
                            complete: function() {
                                submitBtn.prop('disabled', false).html(
                                    '<i class="fas fa-upload me-1"></i> Upload');
                            }
                        });
                    });
                })
                .fail(function(xhr) {
                    Swal.fire('Error!', 'Gagal memuat form: ' + xhr.statusText, 'error');
                });
        }

        $(document).on('submit', '#formDeleteLevel', function(e) {
            e.preventDefault();
            var form = $(this);
            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                success: function(response) {
                    $('#myModal').modal('hide');
                    window.LaravelDataTables["level-table"].ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Level berhasil dihapus.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Tidak dapat menghapus level karena user dengan level ini masih ada.'
                    });
                }
            });
        });

        $(document).ready(function() {
            $('#id_level').change(function() {
                window.LaravelDataTables["level-table"].ajax.reload();
            });

            // Kirim filter ke server sebelum DataTable melakukan AJAX
            $('#level-table').on('preXhr.dt', function(e, settings, data) {
                data.id_level = $('#id_level').val();
            });
        });
    </script>
@endpush
