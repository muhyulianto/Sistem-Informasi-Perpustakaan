<template>
  <div class="row justify-content-around align-items-center min-vh-100">
    <div class="col-lg-4">
      <h1 class="mb-3">
        SELAMAT DATANG DI PERPUSTAKAAN SDN 02 GONILAN
      </h1>
      <router-link :to="{ name: 'login' }" class="btn btn-primary px-3">
        login
      </router-link>
      <router-link :to="{ name: 'register' }" class="btn btn-secondary px-3">
        register
      </router-link>
    </div>
    <div class="col-lg-4">
      <img src="fonts/school.svg" alt="" />
    </div>
  </div>
</template>

<script>
export default {};
</script>
