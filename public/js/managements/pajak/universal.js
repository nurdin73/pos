$(document).ready(function () {
  layananPajak()
  getDetailPajak.loadData = ""
});

const getDetailPajak = {
  set loadData(query_params) {
    const url = URL_API + "/managements/pajak/1"
    Functions.prototype.getRequest(getDetailPajak, url)
  },
  set successData(response) {
    $('#persentasePajak').val(response.persentasePajak)
    $('#biaya_layanan').val(response.persentaseLayanan)
    $('#nama_pajak').val(response.nama_pajak)
    response.hargaBarang ? $('#hargaBarang').attr('checked', true) : $('#hargaBarang').attr('checked', false)
    response.pajakAktif ? $('#pajakAktif').attr('checked', true) : $('#pajakAktif').attr('checked', false)
    response.layananAktif ? $('#biaya_ditiadakan').attr('checked', true) : $('#biaya_ditiadakan').attr('checked', false)
  },
  set errorData(err) {
    toastr.error(err.responseJSON.message, 'Error')
  }
}

function layananPajak() {
  $('#rincianPajak').submit(function(e) {
    e.preventDefault()
    const hargaBarang = document.getElementById('hargaBarang').checked ? 1 : 0
    const pajakAktif = document.getElementById('pajakAktif').checked ? 1 : 0
    const data = {
      nama_pajak: $('#nama_pajak').val(),
      persentasePajak: $('#persentasePajak').val(),
      hargaBarang: hargaBarang,
      pajakAktif: pajakAktif
    }
    const url = URL_API + "/managements/update/pajak/1"
    Functions.prototype.putRequest(postLayananPajak, url, data)
  })

  $('#layananPajak').submit(function(e) {
    e.preventDefault()
    const biaya_ditiadakan = document.getElementById('biaya_ditiadakan').checked ? 1 : 0
    const data = {
      persentaseLayanan: $('#biaya_layanan').val(),
      layananAktif: biaya_ditiadakan
    }
    const url = URL_API + "/managements/update/pajak/1"
    Functions.prototype.putRequest(postLayananPajak, url, data)
  })
}

const postLayananPajak = {
  set successData(response) {
    toastr.success(response.message, 'Success')
  },
  set errorData(err) {
    toastr.error(err.responseJSON.message, 'Error')
  }
}