<div id="view-data-{{ $buku->id }}" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <label><i class="fa fa-tasks"></i> Data lengkap</label>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <table class="table table-responsive">
                    <tr>
                        <th class="col-sm-2">Judul buku</th>
                        <td>:</td>
                        <td>{{ $buku->nama_buku }}</td>
                    </tr>
                    <tr>
                        <th class="col-sm-2">Pengarang</th>
                        <td>:</td>
                        <td>{{ $buku->pengarang }}</td>
                    </tr>
                    <tr>
                        <th class="col-sm-2">Tahun terbit</th>
                        <td>:</td>
                        <td>{{ $buku->tahun_terbit }}</td>
                    </tr>
                    <tr>
                        <th class="col-sm-2">Penerbit</th>
                        <td>:</td>
                        <td>{{ $buku->penerbit }}</td>
                    </tr>
                    <tr>
                        <th class="col-sm-2">Nomor rak</th>
                        <td>:</td>
                        <td>{{ $buku->rak }}</td>
                    </tr>
                    <tr>
                        <th class="col-sm-2">Jenis buku</th>
                        <td>:</td>
                        <td>{{ $buku->jenis_buku }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>