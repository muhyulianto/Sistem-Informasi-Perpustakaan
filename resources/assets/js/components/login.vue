<template>
  <div class="col-lg-4 offset-lg-4">
    <div class="card shadow-sm mtb-10vh">
      <div class="card-header">
        <h5 class="card-title mb-0">Login</h5>
      </div>
      <div class="card-body">
        <div class="alert alert-danger" v-if="error == true">
          <a
            href="#"
            class="close"
            data-dismiss="alert"
            aria-label="close"
            @click="errors = false"
            >&times;</a
          >
          <p>{{ errors }}</p>
        </div>
        <form autocomplete="off" @submit.prevent="login" method="post">
          <div class="form-group">
            <label for="email">E-mail</label>
            <input
              type="email"
              id="email"
              class="form-control"
              placeholder="user@example.com"
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
          <button type="submit" class="btn btn-primary">Sign in</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      email: null,
      password: null,
      success: false,
      error: false,
      errors: ""
    };
  },
  mounted() {
    //
  },
  methods: {
    login() {
      var redirect = this.$auth.redirect();
      var app = this;
      this.$auth.login({
        data: {
          email: app.email,
          password: app.password
        },
        success: function(resp) {
          app.success = true;
          this.$router.push({ name: "dashboard" });
        },
        rememberMe: true,
        fetchUser: true
      });
    }
  }
};
</script>
