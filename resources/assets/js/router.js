import VueRouter from "vue-router";
import Register from "./components/register";
import Login from "./components/login";
import Index from "./components/index";
import Dashboard from "./components/dashboard";
import Buku from "./components/buku";
import Peminjaman from "./components/peminjaman";
import Pengembalian from "./components/pengembalian";
import Denda from "./components/denda";

// Routes
const routes = [
  { path: "/", name: "index", component: Index, meta: { auth: false } },
  {
    path: "/register",
    name: "register",
    component: Register,
    meta: { auth: false }
  },
  { path: "/login", name: "login", component: Login, meta: { auth: false } },
  {
    path: "/dashboard",
    name: "dashboard",
    component: Dashboard,
    meta: { auth: true }
  },
  {
    path: "/peminjaman",
    name: "peminjaman",
    component: Peminjaman,
    meta: { auth: true }
  },
  {
    path: "/pengembalian",
    name: "pengembalian",
    component: Pengembalian,
    meta: { auth: true }
  },
  { path: "/buku", name: "buku", component: Buku, meta: { auth: true } },
  { path: "/denda", name: "denda", component: Denda, meta: { auth: true } }
];

const router = new VueRouter({
  base: "/Sistem-Informasi-Perpustakaan/public",
  history: true,
  mode: "history",
  routes
});

export default router;
