$(document).ready(function () {
  var showAll = false
  $('#addCategory').on('click', function(e) {
    $('#formAdd').slideToggle()
  })

  $('#btnShowOther').on('click', function(e) {
    if(showAll == true) {
      showAll = false
    } else {
      showAll = true
    }
    $('#showOther').slideToggle()
  })

  $('#formAddbarang').validate({
    rules: {
      nama_barang: {
        required : true
      },
      type_barang: {
        required : true
      },
      stok: {
        required : true,
        number : true
      },
      harga_dasar: {
        required : true,
        number : true
      },
      harga_jual: {
        required : true,
        number : true
      },
      kode: {
        required : true
      },
      kategori: {
        required : true
      },
      berat: {
        number: true
      },
      satuan: {
        number: true
      },
      diskon: {
        number: true
      },
    },
    errorClass: "is-invalid",
    validClass: "is-valid",
    errorElement: "small",
    submitHandler: function(form, e) {
      e.preventDefault()
      const data = {
        nama_barang: $('#nama_barang').val(),
        type_barang: $('#type_barang').val(),
        stok: $('#stok').val(),
        kode: $('#kode').val(),
        harga_dasar: $('#harga_dasar').val(),
        harga_jual: $('#harga_jual').val(),
        kategori: $('#kategori').val(),
        berat: showAll ? $('#berat').val() : "",
        satuan: showAll ? $('#satuan').val() : "",
        diskon: showAll ? $('#diskon').val() : "",
        rak: showAll ? $('#rak').val() : "",
        keterangan: showAll ? $('#keterangan').val() : "",
      }

      const sendData = Functions.prototype.httpRequest("", data, 'post')
      console.log(sendData);
    }
  })

  $('#submitCategory').on('click', function(e) {
    e.preventDefault()
    const nameCategory = $('#kategoriAdd').val()
    if(!nameCategory) return toastr.warning("Nama kategori tidak boleh kosong", 'perhatian!')
    const data = {
      name : nameCategory
    }
    const url = URL_API + "/managements/add/kategori"
    Functions.prototype.httpRequest(url, data, "post")
    $('#kategoriAdd').removeClass('is-valid').val('')
  })

  $('#kategori').select2({
    theme:'bootstrap4',
    ajax: {
      url: URL_API + "/managements/categories",
      data: function (params) {
        return {
            name: params.term,
        }
      },
      processResults: function(data, params) {
        return {
          results: data.map(result => {
            return {
              text: result.name,
              id: result.id
            }
          })
        }
      },
    }
  })
});