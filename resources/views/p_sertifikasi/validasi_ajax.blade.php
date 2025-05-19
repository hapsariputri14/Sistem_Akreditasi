<div class="modal-header bg-primary text-white">
    <h5 class="modal-title">Validasi Sertifikasi</h5>
    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>Nama Dosen</th>
                <td>{{ $sertifikasi->dosen->nama_lengkap ?? '-' }}</td>
            </tr>
            <tr>
                <th>Tahun Diperoleh</th>
                <td>{{ $sertifikasi->tahun_diperoleh }}</td>
            </tr>
            <tr>
                <th>Penerbit</th>
                <td>{{ $sertifikasi->penerbit }}</td>
            </tr>
            <tr>
                <th>Nama Sertifikasi</th>
                <td>{{ $sertifikasi->nama_sertifikasi }}</td>
            </tr>
            <tr>
                <th>Nomor Sertifikat</th>
                <td>{{ $sertifikasi->nomor_sertifikat }}</td>
            </tr>
            <tr>
                <th>Masa Berlaku</th>
                <td>{{ $sertifikasi->masa_berlaku }}</td>
            </tr>
        </tbody>
    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
</div>

