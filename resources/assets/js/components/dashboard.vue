<template>
  <div class="container">
    <template v-if="$auth.check(2)">
      <adminDashboard />
    </template>
    <template v-if="$auth.check(1)">
      <userDashboard />
    </template>
  </div>
</template>

<script>
import userDashboard from "./dashboard/user.vue";
import adminDashboard from "./dashboard/admin.vue";

export default {
  components: {
    userDashboard,
    adminDashboard
  },

  data() {
    return {};
  },

  mounted() {},

  methods: {}
};
</script>
