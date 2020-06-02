<template>
  <div v-if="$auth.check()">
    <nav class="sidenav shadow-sm">
      <div class="sidenav__img">
        <img
          width="200"
          height="75"
          class="w-50 object-cover img--rounded"
          src="https://picsum.photos/500/250"
          alt
        />
        <a href="#" class="img__overlay">
          <i class="fa fa-cog overlay--center" aria-hidden="true"></i>
        </a>
      </div>
      <div class="sidenav__menu">
        <router-link class="menu__item" :to="{ name: 'dashboard' }"
          >Dashboard</router-link
        >
        <router-link class="menu__item" :to="{ name: 'buku' }"
          >Data buku</router-link
        >
        <router-link class="menu__item" :to="{ name: 'peminjaman' }"
          >Peminjaman</router-link
        >
        <router-link
          class="menu__item"
          v-if="$auth.user().role == 2"
          :to="{ name: 'pengembalian' }"
          >Pengembalian</router-link
        >
        <router-link
          class="menu__item"
          v-if="$auth.user().role == 2"
          :to="{ name: 'user' }"
          >User</router-link
        >
        <a class="menu__item" href="#" @click.prevent="$auth.logout()"
          >Logout</a
        >
      </div>
    </nav>
    <div class="main">
      <template v-if="isLoading">
        <transition name="fade">
          <div class="loading">
            <label class="align-self-center">
              <div class="sk-chase">
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
              </div>
            </label>
          </div>
        </transition>
      </template>
      <router-view></router-view>
    </div>
  </div>
</template>
<script>
export default {
  computed: {
    isLoading() {
      return this.$store.getters.isLoading;
    }
  }
};
</script>
