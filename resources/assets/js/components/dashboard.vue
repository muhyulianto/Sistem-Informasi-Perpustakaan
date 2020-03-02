<template>
  <div>
    <!--<div v-if="loading" class="loading">-->
      <!--<label class="align-self-center">-->
        <!--<div class="sk-chase">-->
          <!--<div class="sk-chase-dot"></div>-->
          <!--<div class="sk-chase-dot"></div>-->
          <!--<div class="sk-chase-dot"></div>-->
          <!--<div class="sk-chase-dot"></div>-->
          <!--<div class="sk-chase-dot"></div>-->
          <!--<div class="sk-chase-dot"></div>-->
        <!--</div>-->
      <!--</label>-->
    <!--</div>-->
    <div class="fadeMe">
      <div v-if="$auth.check(['roles', 2])" class="row">
        <div class="col-md-3">
          <div class="card bg-info text-white shadow-sm mb-4">
            <div class="card-header bg-info">
              Jumlah buku yang di pinjam hari ini
            </div>
            <div class="card-body">
              <h5>10 Buku</h5>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card bg-success text-white shadow-sm mb-4">
            <div class="card-header bg-success">
              Jumlah user yang meminjam buku hari ini
            </div>
            <div class="card-body">
              <h5>15 Orang</h5>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card bg-warning text-white shadow-sm mb-4">
            <div class="card-header bg-warning">
              Buku yang paling sering di pinjam
            </div>
            <div class="card-body">
              <h5 class="text-truncate">
                Si kancil anak nakal
              </h5>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card bg-danger text-white shadow-sm mb-4">
            <div class="card-header bg-danger">
              User yang paling sering meminjam buku
            </div>
            <div class="card-body">
              <h5 class="text-truncate">Muhammad yulianto</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <div class="card shadow-sm">
          <div class="card-body">
          Selamat datang <a href="#">{{ $auth.user().name }}</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
