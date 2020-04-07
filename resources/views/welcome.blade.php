@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-8 col-md-offset-2">
            <div class="" id="perpustakaan" style="margin-top: 130px">
                <div class="title m-b-md">
                    <i class="fa fa-book"></i> Perpustakaan
                </div>
                <div class="panel panel-default" id="flat-search">
                    <div class="panel-body">
                        <form>
                            <div class="input-group">
                                <input id="search" type="text" name="search" class="form-control search-custom" autocomplete="off" placeholder="Tuliskan info buku">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" id="cari"><i class="fa fa-search fa-fw"></i> Cari</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div id="mbuh">
            @isset($Bukus)
                <div class="panel panel-default" id="flat-search">
                    <div class="panel-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">No</th>
                                    <th>Nama Buku</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            @forelse($Bukus as $buku)
                                <tr>
                                    <td style="text-align: center;" class="col-sm-1">{{ ($Bukus ->currentpage()-1) * $Bukus ->perpage() + $loop->index + 1 }}</td>
                                    <td>{{ $buku -> nama_buku }}</td>
                                    <td class="col-sm-1">
                                        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#view-data-{{ $buku->id }}"><span class="fa fa-eye"></span> Lihat</button>
                                        @include('data.modal-view')
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" style="text-align: center;">Maaf data tidak ditemukan</td>
                                </tr>
                            @endforelse
                        </table>
                        {{ $Bukus->links() }}
                    </div>
                </div>
            @endisset
            </div>
            <!-- Selesai -->
        </div>
    </div>
    <script type="text/javascript">
        $(document).on('click', 'button#cari', function(e){
            e.preventDefault();
            var search = $("input[name='search']").val();
            var replaced = search.replace(/ /g, '%20');
            $.ajax({
                type: 'GET',
                url: '{{ route('search') }}',
                success: function(data){
                    console.log(data);
                    $("#mbuh").load("{{ route('search') }}" + "?search=" + replaced + " #mbuh>*", "");
                }
            })
        })

        // Ajax pagination
        $(document).on('click', 'ul.pagination > li > a', function (e) {
            e.preventDefault();
            var a = $(this).attr('href');
            // $('.informasi').attr('id', a);
            $.ajax({
                type: 'GET',
                url: $(this).attr('href'),
                success: function( data ) {
                    var a = data.split('<div id="mbuh">')[1];
                    var b = a.split('<!-- Selesai -->')[0];
                    console.log(b);
                    $('#mbuh').html(b);
                }
            })
        });

    </script>
@endsection
