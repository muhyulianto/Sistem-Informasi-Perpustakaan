@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default" id="flat-search">
            <div class="panel-heading">
                <h3 class="panel-title">Export data to Excel</h3>
            </div>
            <form class="" action="{{ route('export_excel') }}" method="POST">
                <div class="panel-body">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="">Urut berdasarkan</label>
                        <select class="form-control" name="sort" required>
                            <option value=""></option>
                            <option value="nama_buku">Nama Buku</option>
                            <option value="pengarang">Pengarang</option>
                            <option value="tahun_terbit">Tahun terbit</option>
                            <option value="penerbit">Penerbit</option>
                            <option value="rak">Rak</option>
                            <option value="jenis_buku">Jenis Buku</option>
                        </select>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="submit" class="btn btn-primary">Export</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
