<template>
  <div class="modal__data">
    <!-- Modal -->
    <div :id="'info__user' + parentData.id_user" class="modal" role="dialog">
      <div class="modal-dialog modal-dialog-centered">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <div class="modal-title">Informasi lengkap user</div>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table class="table table-borderless table-sm">
              <tbody>
                <tr>
                  <th class="align-middle">Nama</th>
                  <td class="w-75">
                    {{ parentData.user.name }}
                  </td>
                </tr>
                <tr>
                  <th class="align-middle">Email</th>
                  <td class="w-75">
                    {{ parentData.user.email }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    parentData: Object
  },

  data() {
    return {};
  },

  mounted() {},

  methods: {}
};
</script>
