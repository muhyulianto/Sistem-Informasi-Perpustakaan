<template>
  <div class="row justify-content-center min-vh-100">
    <div class="col-lg-4 align-self-center">
      <div class="card shadow-sm">
        <div class="card-header">
          <h5 class="card-title mb-0">Sign up</h5>
        </div>
        <div class="card-body">
          <div class="alert alert-danger" v-if="error && !success">
            <p>There was an error, unable to complete registration.</p>
          </div>
          <div class="alert alert-success" v-if="success">
            <p>
              Registration completed.
              <br />
              You now can
              <router-link :to="{ name: 'login' }">sign in.</router-link>
            </p>
          </div>
          <form
            autocomplete="off"
            @submit.prevent="register"
            v-if="!success"
            method="post"
          >
            <div
              class="form-group"
              v-bind:class="{ 'has-error': error && errors.name }"
            >
              <label for="name">Name</label>
              <input
                type="text"
                id="name"
                class="form-control"
                v-model="name"
                required
              />
              <small class="text-danger" v-if="error && errors.name">{{
                errors.name
              }}</small>
            </div>
            <div class="form-group">
              <label for="kelas">
                Kelas
              </label>
              <input
                v-model="kelas"
                class="form-control"
                type="text"
                required
              />
            </div>
            <div
              class="form-group"
              v-bind:class="{ 'has-error': error && errors.email }"
            >
              <label for="email">E-mail</label>
              <input
                type="email"
                id="email"
                class="form-control"
                v-model="email"
                required
              />
              <small class="text-danger" v-if="error && errors.email">{{
                errors.email
              }}</small>
            </div>
            <div
              class="form-group"
              v-bind:class="{ 'has-error': error && errors.password }"
            >
              <label for="password">Password</label>
              <input
                type="password"
                id="password"
                class="form-control"
                v-model="password"
                required
              />
              <small class="text-danger" v-if="error && errors.password">{{
                errors.password
              }}</small>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
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
      name: "",
      email: "",
      password: "",
      kelas: "",
      error: false,
      errors: "",
      success: false
    };
  },

  methods: {
    register() {
      var app = this;
      this.$auth.register({
        data: {
          name: app.name,
          email: app.email,
          password: app.password,
          kelas: app.kelas
        },
        success: function() {
          app.success = true;
        },
        error: function(err) {
          app.error = true;
          app.errors = err.response.data.errors;
        }
      });
    }
  }
};
</script>
