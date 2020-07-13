import VueRouter from "vue-router";
import Register from "./components/auth/register";
import Login from "./components/auth/login";
import Index from "./components/index";
import Dashboard from "./components/dashboard";
import Buku from "./components/buku";
import tambahBuku from "./components/tambahBuku.vue";
import detailBuku from "./components/detailBuku";
import PinjamBuku from "./components/pinjamBuku";
import Peminjaman from "./components/peminjaman";
import Pengembalian from "./components/pengembalian";
import User from "./components/user";
import userShow from "./components/user_show.vue";
import unAuthorizedLayout from "./components/layouts/unAuthorized";
import Authorized from "./components/layouts/Authorized";
import notFound from "./components/404";

// Routes
export const routes = [
  {
    path: "*/404",
    component: notFound
  },
  {
    path: "/",
    component: unAuthorizedLayout,
    meta: { auth: false },
    children: [
      { 
        path: "",
        name: "index",
        component: Index,
      },
      { path: "login",
        name: "login",
        component: Login,
      },
      {
        path: "register",
        name: "register",
        component: Register,
      }
    ]
  },
  {
    path: "/",
    component: Authorized,
    meta: { auth: true },
    children: [
      {
        path: "dashboard",
        name: "dashboard",
        component: Dashboard
      },
      {
        path: "buku",
        name: "buku",
        component: Buku
      },
      {
        path: "buku/tambah",
        name: "tambahBuku",
        component: tambahBuku
      },
      {
        path: "buku/:id",
        name: "detailBuku",
        component: detailBuku
      },
      {
        path: "buku/pinjam/:id",
        name: "pinjamBuku",
        component: PinjamBuku
      },
      {
        path: "peminjaman",
        name: "peminjaman",
        component: Peminjaman
      },
      {
        path: "pengembalian",
        name: "pengembalian",
        component: Pengembalian
      },
      {
        path: "user",
        name: "user",
        component: User
      },
      {
        path: "user/:id",
        name: "userShow",
        component: userShow,
        props: true
      }
    ]
  }
];
