@extends('layouts.app')

@section('content')
{{-- Anggap aja ini session --}}
<div class="informasi" id=""></div>
{{-- end --}}
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default" id="flat-search">
                <div class="panel-heading clearfix">
                    <label>Data Buku</label>
                    <a class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#input-data"><span class="fa fa-plus-circle"></span> Tambah data</a>
                    <span class="pull-right">&nbsp;</span>
                    <button data-toggle="collapse" data-target="#excel" class="btn btn-success btn-sm pull-right">Import</button>
                    <div id="input-data" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <label>Tambahkan data</label>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal" id="buat">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="Judul" class="control-label col-sm-2">Judul buku:</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="nama_buku" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="pengarang" class="control-label col-sm-2">Pengarang:</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="pengarang" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="tahun_terbit" class="control-label col-sm-2">Tahun terbit:</label>
                                            <div class="col-sm-2">
                                                <input type="number" name="tahun_terbit" class="form-control">
                                            </div>
                                            <label for="penerbit" class="control-label col-sm-2">Penerbit:</label>
                                            <div class="col-sm-6">
                                                <input type="text" name="penerbit" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="nomor_rak" class="control-label col-sm-2">Nomor rak:</label>
                                            <div class="col-sm-2">
                                                <input type="text" name="rak" class="form-control">
                                            </div>
                                            <label for="jenis_buku" class="control-label col-sm-2">Jenis Buku:</label>
                                            <div class="col-sm-6">
                                                <input type="text" name="jenis_buku" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button id="create-data" type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div id="excel" class="collapse">
                        <form method="POST" action="{{ url('/import_excel') }}" enctype="multipart/form-data" class="form-horizontal">
                            {{ csrf_field() }}
                            <!-- <div class="input-group">
                                <input type="file" name="excel" required id="excel" class="form-control">
                                <span class="input-group-addon" style="border:0px;background-color: transparent;"></span>
                                <button id="excel-submit" class="btn btn-primary btn-block form-control">Submit</button>
                            </div> -->
                            <div class="input-group">
                                <label class="input-group-btn">
                                    <span class="btn btn-default">
                                        Browse&hellip; <input type="file" name="excel" required style="display: none;" multiple>
                                    </span>
                                </label>
                                <input type="text" class="form-control" readonly>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </span>
                            </div>
                        </form>
                        <form style="float: left" class="form-horizontal" action="{{ route("template") }}" method="post">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-link">
                                Download template
                            </button>
                        </form>
                    </div>
                </div>
                <div class="panel-body">
                    <form id="form-search" class="form-horizontal">
                        <div class="input-group">
                            <input id="search" type="text" name="search" class="form-control search-custom" autocomplete="off" placeholder="Tuliskan info buku">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" id="search"><i class="fa fa-search fa-fw"></i> Cari</button>
                            </span>
                        </div>
                    </form>
                </div>
                <div class="panel-body" id="body-list-buku">
                    <table class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th style="text-align: center;">No</th>
                                <th>Nama Buku</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($Bukus as $buku)
                            <tr id="{{ $buku -> id }}">
                                <td class="col-sm-1" style="text-align: center;" id="no">{{ ($Bukus ->currentpage()-1) * $Bukus ->perpage() + $loop->index + 1 }}</td>
                                <td>
                                    {{ $buku->nama_buku }}
                                </td>
                                <td class="col-md-2">

                                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#view-data-{{ $buku->id }}"><span class="fa fa-eye"> </span></button>
                                    @include('data.modal-view')
                                    <button id="edit" data-id="{{ $buku->id }}" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit-data-{{ $buku->id }}"><span class="fa fa-edit"></span> </button>
                                    @include('data.modal-edit')
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete-data"><span class="fa fa-trash"></span> </button>

                                    {{-- modal delete start --}}
                                    <div class="modal fade" id="delete-data" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="">Delete</h4>
                                                </div>
                                                <div class="modal-body">
                                                    Apa anda yakin ingin menghapus data ini?
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="col-sm-2 pull-right">
                                                        <button type="button" class="btn btn-success btn-block btn-sm" id="delete" data-id="{{ $buku->id }}" data-dismiss="modal">Iya</button>
                                                    </div>
                                                    <div class="col-sm-2 pull-right">
                                                        <button type="button" class="btn btn-danger btn-block btn-sm" data-dismiss="modal">Tidak</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- modal delete end --}}

                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" style="text-align: center">Data tidak ditemukan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div id="pagination">
                        {{ $Bukus->links() }}
                    </div>
                </div>
                <!-- Selesai -->
            </div>
        </div>
    </div>
</div>
@include('data.ajax')
@endsection
