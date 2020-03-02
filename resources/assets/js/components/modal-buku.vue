<template>
  <div class="modal__data">
    <!-- Modal -->
    <div :id="'info__buku' + parentData.buku.id" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <div class="modal-title">Informasi lengkap buku</div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table class="table table-borderless table-sm">
              <tbody>
                <tr>
                  <th class="align-middle">Judul buku</th>
                  <th class="align-middle">:</th>
                  <td class="col-lg-8 align-middle">{{ parentData.buku.judul_buku }}</td>
                </tr>
                <tr>
                  <th class="align-middle">Pengarang</th>
                  <th class="align-middle">:</th>
                  <td class="col-lg-8 align-middle">{{ parentData.buku.pengarang}}</td>
                </tr>
                <tr>
                  <th class="align-middle">Tahun terbit</th>
                  <th class="align-middle">:</th>
                  <td class="col-lg-8 align-middle">{{ parentData.buku.tahun_terbit}}</td>
                </tr>
                <tr>
                  <th class="align-middle">Penerbit</th>
                  <th class="align-middle">:</th>
                  <td class="col-lg-8 align-middle">{{ parentData.buku.penerbit}}</td>
                </tr>
                <tr>
                  <th class="align-middle">Jenis buku</th>
                  <th class="align-middle">:</th>
                  <td class="col-lg-8 align-middle">{{ parentData.buku.jenis_buku}}</td>
                </tr>
                <tr>
                  <th class="align-middle">Lokasi rak</th>
                  <th class="align-middle">:</th>
                  <td class="col-lg-8 align-middle">{{ parentData.buku.lokasi_rak}}</td>
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
