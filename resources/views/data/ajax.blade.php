<script type="text/javascript">
    // Ajax add data
    $(document).on('click', 'button#create-data', function(e) {
        e.preventDefault();

        var _token = $("input[name='_token']").val();
        var pengarang = $("input[name='pengarang']").val();
        var tahun_terbit = $("input[name='tahun_terbit']").val();
        var penerbit = $("input[name='penerbit']").val();
        var rak = $("input[name='rak']").val();
        var jenis_buku = $("input[name='jenis_buku']").val();
        var nama_buku = capitalize_Words($("input[name='nama_buku']").val());

        function capitalize_Words(str) {
            return str.replace(/\w\S*/g, function(txt) {
                return txt.charAt(0).toUpperCase() + txt.substr(1);
            });
        }


        $.ajax({
            datatype: 'text',
            type: "POST",
            url: '{{ route("data.store") }}',
            data: {
                _token: _token,
                nama_buku: nama_buku,
                pengarang: pengarang,
                tahun_terbit: tahun_terbit,
                penerbit: penerbit,
                rak: rak,
                jenis_buku: jenis_buku
            },
            success: function(data) {
                if (data.errors) {
                    for (var k in data.errors) {
                        $.notify({
                            message: data.errors[k]
                        }, {
                            type: 'danger',
                            z_index: 99999,
                            delay: 1000,
                        });
                    }
                } else {
                    //Reset form
                    $('form#buat').trigger('reset');
                    // Refresh specific div
                    $("#body-list-buku").load('{{ url("/data") }}' + " #body-list-buku>*", "");
                    // reset link untuk refresh data
                    $('.informasi').attr('id', '');
                    // Bootstrap notify
                    $.notify({
                        message: 'Data telah ditambahkan'
                    }, {
                        type: 'success',
                        z_index: 99999,
                        delay: 1000,
                    });
                }
            }
        })
    })

    // Ajax edit
    var id;

    $(document).on('click', 'button#edit', function(e) {
        return id = $(this).attr('data-id');
    });

    $(document).on('submit', 'form#edit-data', function(e) {
        e.preventDefault();

        var _token = $('input[name="_token"]').val();
        var nama_buku = $('#nama_buku_' + id).val();
        var pengarang = $('#pengarang_' + id).val();
        var tahun_terbit = $('#tahun_terbit_' + id).val();
        var penerbit = $('#penerbit_' + id).val();
        var rak = $('#rak_' + id).val();
        var jenis_buku = $('#jenis_buku_' + id).val();

        $.ajax({
            type: 'POST',
            url: '{{ url("/data") }}' + '/' + id,
            data: {
                _method: 'PUT',
                _token: _token,
                nama_buku: nama_buku,
                pengarang: pengarang,
                tahun_terbit: tahun_terbit,
                penerbit: penerbit,
                rak: rak,
                jenis_buku: jenis_buku
            },
            success(data) {
                // Bootstrap notify
                $.notify({
                    message: 'Data telah diupdate'
                }, {
                    type: 'success',
                    z_index: 99999,
                    delay: 1000
                });
                // link untuk refresh data
                var jeruk = $('div.informasi').attr('id');
                // Refresh specific div on modal close
                $('#edit-data-' + data.id).on('hide.bs.modal', function() {
                    $("#body-list-buku").load(jeruk + " #body-list-buku>*", "");
                })
            }
        })
    });

    // Ajax delete
    $(document).on('click', '#delete', function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var _token = $('input[name="_token"]').val();
        $.ajax({
            type: 'POST',
            url: '{{ url("/data") }}' + '/' + id,
            data: {
                _method: 'DELETE',
                _token: _token,
                id: id
            },
            success(data) {
                // Bootstrap notify
                $.notify({
                    message: 'Data telah dihapus'
                }, {
                    type: 'success',
                    z_index: 99999,
                    delay: 1000
                });
                // link untuk refresh data
                var jeruk = $('div.informasi').attr('id');
                // Refresh specific div on modal close
                $("#body-list-buku").load(jeruk + " #body-list-buku>*", "");
            }
        })
    });

    // Ajax pagination
    $(document).on('click', 'ul.pagination > li > a', function(e) {
        e.preventDefault();
        var a = $(this).attr('href');
        $('.informasi').attr('id', a);
        $.ajax({
            type: 'GET',
            url: $(this).attr('href'),
            success: function(data) {
                var a = data.split('<div class="panel-body" id="body-list-buku">')[1];
                var b = a.split('<!-- Selesai -->')[0];
                $('#body-list-buku').html(b);
            }
        })
    });

    // ajax search
    $(document).on('click', '#search', function(e) {
        e.preventDefault();
        var search = $("input[name='search']").val();
        console.log(search);
        // replace space with %20
        var replaced = search.replace(/ /g, '%20');
        $('.informasi').attr('id', '{{ url("/data") }}' + '?search=' + replaced);
        $.ajax({
            type: 'GET',
            url: '{{ url("/data") }}' + '?search=' + replaced,
            success: function(data) {
                $("#body-list-buku").load('{{ url("/data") }}' + '?search=' + replaced + " #body-list-buku>*", "");
            }
        })
    });

    // Prevent enter button to submit data
    // $(document).on("keypress", 'form#form-search', function (e) {
    //     var code = e.keyCode || e.which;
    //     // console.log(code);
    //     if (code == 13) {
    //         e.preventDefault();
    //     }
    // });
</script>
