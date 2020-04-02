<template>
  <div class="row justify-content-center min-vh-100">
    <div class="col-lg-4 align-self-center">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Login</h5>
        </div>
        <div class="card-body">
          <template v-if="error">
            <div class="alert alert-danger">
              <a
                href="#"
                class="close"
                data-dismiss="alert"
                aria-label="close"
                @click="errors = false"
                >&times;</a
              >
              {{ errorMsg }}
            </div>
          </template>
          <form autocomplete="off" @submit.prevent="login" method="post">
            <div class="form-group">
              <label for="email">E-mail</label>
              <input
                type="email"
                id="email"
                class="form-control"
                v-model="email"
                required
              />
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input
                type="password"
                id="password"
                class="form-control"
                v-model="password"
                required
              />
            </div>
            <button type="submit" class="btn btn-primary">
              {{ !isLoading ? "Sign in" : "Loading" }}
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      email: null,
      password: null
    };
  },
  computed: {
    isLoading() {
      return this.$store.getters.isLoading;
    },
    error() {
      return this.$store.getters.error;
    },
    errorMsg() {
      return this.$store.getters.errorMsg;
    }
  },
  methods: {
    login() {
      this.$store.commit("TOGGLE_LOADING", true);
      this.$auth.login({
        data: {
          email: this.email,
          password: this.password
        },
        success: function(resp) {
          this.$store.commit("TOGGLE_LOADING", false);
          this.$store.commit("TOGGLE_ERROR", false);
          this.$router.push({ name: "dashboard" });
        },
        error: function(err) {
          this.$store.commit("TOGGLE_LOADING", false);
          this.$store.commit("TOGGLE_ERROR", true);
          this.$store.commit("SET_ERRORMSG", err.response.data.errors);
        },
        rememberMe: true,
        fetchUser: true
      });
    }
  }
};
</script>
