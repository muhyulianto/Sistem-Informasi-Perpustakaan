<template>
  <div class="container">
    <div class="row justify-content-center align-items-center vh-100">
      <div class="col-lg-8">
        <div class="d-flex justify-content-center align-items-center mb-4">
          <h1 class="font-weight-bold">404</h1>
          <h2 class="mx-4">|</h2>
          <h3>Halaman yang anda cari tidak ditemukan</h3>
        </div>
        <div class="text-center">
          <router-link
            :to="{ name: 'dashboard' }"
            class="btn btn-primary shadow-sm"
          >
            <span class="fa fa-home"></span> Kembali ke dashboard
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>
