<template>
  <div class="templateRoot min-vh-100">
    <div v-if="$auth.ready()" class="authReady">
      <div v-if="$auth.check()" class="authCheck">
        <div class="sidenav shadow-sm">
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
            <a class="menu__item" href="#" @click.prevent="$auth.logout()"
              >Logout</a
            >
          </div>
        </div>
      </div>
      <!-- Unauthorized -->
      <div v-if="!$auth.check()" class="authCheck">
        <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
          <div class="container">
            <span class="fa fa-2x fa-book mr-2"></span>
            <button
              class="navbar-toggler"
              type="button"
              data-toggle="collapse"
              data-target="#navbarTogglerDemo02"
              aria-controls="navbarTogglerDemo02"
              aria-expanded="false"
              aria-label="Toggle navigation"
            >
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
              <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item">
                  <router-link to="/" class="nav-link">Home</router-link>
                </li>
              </ul>
              <ul class="navbar-nav">
                <li class="nav-item">
                  <router-link to="/register" class="nav-link">
                    <span class="fa fa-user" /> Register
                  </router-link>
                </li>
                <li class="nav-item">
                  <router-link to="/login" class="nav-link">
                    <span class="fa fa-key" /> Login
                  </router-link>
                </li>
              </ul>
            </div>
          </div>
        </nav>
      </div>
      <div :class="$auth.check() ? 'main' : ''">
        <div class="container">
          <transition name="fade">
            <router-view></router-view>
          </transition>
        </div>
      </div>
    </div>
  </div>
</template>
