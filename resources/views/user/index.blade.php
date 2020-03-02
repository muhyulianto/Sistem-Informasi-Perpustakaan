@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">User Setting</h3>
              </div>

              <div class="panel-body">
                  @foreach($Users as $user)
                  <form class="form-horizontal" method="POST" action="{{ route('user.update', $user->id) }}">
                      {{ csrf_field() }}
                      {{ method_field('PUT') }}
                      <div class="form-group">
                          <label for="" class="control-label col-sm-2">Name</label>
                          <div class="col-sm-10">
                              <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="" class="control-label col-sm-2">E-mail</label>
                          <div class="col-sm-10">
                              <input type="text" name="email" value="{{ $user->email }}" class="form-control" required>
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="col-sm-10 col-sm-offset-2">
                              <button class="btn btn-primary btn-sm" id="update-user" value="{{ $user->id }}">Update</button>
                              {{-- &nbsp;
                              <a href="#deleteaccountmodal" data-toggle="modal" class="btn btn-danger btn-sm">Hapus akun</a> --}}
                              &nbsp;
                              <a href="#changepasswordmodal" data-toggle="modal">Ganti Password</a>
                          </div>
                      </div>
                  </form>

                  {{-- modal hapus akun --}}
                  <div class="modal fade" id="deleteaccountmodal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title" id="">Warning!!!</h4>
                        </div>
                        <div class="modal-body">
                            Apa anda yakin ingin menghapus akun ini?
                        </div>
                        <div class="modal-footer">
                            <div class="col-sm-6">
                                <form class="form-horizontal" action="{{ route('user.destroy', $user->id) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('delete') }}
                                    <button type="submit" class="btn btn-success btn-block btn-sm">Iya</button>
                                </form>
                            </div>
                            <div class="col-sm-6">
                                <button type="button" class="btn btn-danger btn-block btn-sm" data-dismiss="modal">Tidak</button>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  {{-- modal ganti password start --}}
                  <div class="modal fade" id="changepasswordmodal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title" id="">Mengganti password</h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" action="{{ route('update_password', $user->id) }}" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="" class="control-label col-sm-2">Password baru</label>
                                    <div class="col-sm-10">
                                        <input type="password" name="password" class="form-control" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="control-label col-sm-2">Konfirmasi Password baru</label>
                                    <div class="col-sm-10">
                                        <input type="password" name="password_confirmation" class="form-control" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-8 col-sm-offset-2">
                                        <button id="update_password" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                      </div>
                    </div>
                  </div>
                  {{-- modal ganti password end --}}

                  @endforeach
              </div>

            </div>
        </div>
    </div>
@endsection
