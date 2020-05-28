import VueRouter from "vue-router";
import Register from "./components/auth/register";
import Login from "./components/auth/login";
import Index from "./components/index";
import Dashboard from "./components/dashboard";
import Buku from "./components/buku";
import Peminjaman from "./components/peminjaman";
import Pengembalian from "./components/pengembalian";
import unAuthorizedLayout from "./components/layouts/unAuthorized";
import Authorized from "./components/layouts/Authorized";
import notFound from "./components/404";

// Routes
export const routes = [
  {
    path: "*/404",
    component: notFound,
  },
  {
    path: "/",
    component: unAuthorizedLayout,
    meta: { auth: false },
    children: [
      { path: "", name: "index", component: Index, meta: { auth: false } },
      { path: "login", name: "login", component: Login, meta: { auth: false } },
      {
        path: "register",
        name: "register",
        component: Register,
        meta: { auth: false },
      },
    ],
  },
  {
    path: "/",
    component: Authorized,
    meta: { auth: true },
    children: [
      {
        path: "dashboard",
        name: "dashboard",
        component: Dashboard,
        meta: { auth: true },
      },
      { path: "buku", name: "buku", component: Buku, meta: { auth: true } },
      {
        path: "peminjaman",
        name: "peminjaman",
        component: Peminjaman,
        meta: { auth: true },
      },
      {
        path: "pengembalian",
        name: "pengembalian",
        component: Pengembalian,
        meta: { auth: true },
      },
    ],
  },
];
