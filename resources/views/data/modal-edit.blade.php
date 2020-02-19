<div id="edit-data-{{ $buku->id }}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <label>Mengedit data</label>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="edit-data">
                    <div class="form-group">
                        <label for="Judul" class="control-label col-sm-2">Judul buku:</label>
                        <div class="col-sm-10">
                            <input type="text" id="nama_buku_{{ $buku->id }}" class="form-control" required="" autocomplete="off" value="{{ $buku->nama_buku }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pengarang" class="control-label col-sm-2" >Pengarang:</label>
                        <div class="col-sm-10">
                            <input type="text" id="pengarang_{{ $buku->id }}" class="form-control"  autocomplete="off" value="{{ $buku->pengarang }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tahun_terbit" class="control-label col-sm-2" >Tahun terbit:</label>
                        <div class="col-sm-2">
                            <input type="number" id="tahun_terbit_{{ $buku->id }}" class="form-control"  autocomplete="off" value="{{ $buku->tahun_terbit }}">
                        </div>
                        <label for="penerbit" class="control-label col-sm-2" >Penerbit:</label>
                        <div class="col-sm-6">
                            <input type="text" id="penerbit_{{ $buku->id }}" class="form-control"  autocomplete="off" value="{{ $buku->penerbit }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nomor_rak" class="control-label col-sm-2" >Nomor rak:</label>
                        <div class="col-sm-2">
                            <input type="text" id="rak_{{ $buku->id }}" class="form-control"  autocomplete="off" value="{{ $buku->rak }}">
                        </div>
                        <label for="jenis_buku" class="control-label col-sm-2" >Jenis Buku:</label>
                        <div class="col-sm-6">
                            <input type="text" id="jenis_buku_{{ $buku->id }}" class="form-control"  autocomplete="off" value="{{ $buku->jenis_buku }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>