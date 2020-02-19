<template>
  <div>
    <div class="cek_role" v-if="$auth.user().role == 1">
      <h5>Ini dashboard User</h5>
    </div>
    <div class="cek_role" v-if="$auth.user().role == 2">
      <h5>Ini dashboard Admin</h5>
    </div>
  </div>
</template>
