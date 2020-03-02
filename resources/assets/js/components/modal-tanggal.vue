<template>
  <div class="modal__data">
    <!-- Modal -->
    <div :id="'info__tanggal' + parentData.id" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <div class="modal-title"></div>
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
            <table class="table table-borderless table-sm"></table>
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
