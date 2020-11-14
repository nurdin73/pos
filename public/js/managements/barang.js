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
      files: {
        required: true,
        accept: "image/jpeg, image/png, image/jpg"
      },
      kategori: {
        required : true
      },
      berat: {
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
      const urlPostBarang = URL_API + "/managements/add/barang"
      const formData = new FormData()
      const data = {
        nama_barang: $('#nama_barang').val(),
        type_barang: $('#type_barang').val(),
        stok: $('#stok').val(),
        harga_dasar: $('#harga_dasar').val(),
        harga_jual: $('#harga_jual').val(),
        kategori: $('#kategori').val(),
        berat: showAll ? $('#berat').val() : "",
        satuan: showAll ? $('#satuan').val() : "",
        diskon: showAll ? $('#diskon').val() : "",
        rak: showAll ? $('#rak').val() : "",
        keterangan: showAll ? $('#keterangan').val() : "",
      }
      const files = $('.custom-file-input')[0].files
      formData.append('nama_barang', data.nama_barang)
      formData.append('type_barang', data.type_barang)
      formData.append('stok', data.stok)
      formData.append('harga_dasar', data.harga_dasar)
      formData.append('harga_jual', data.harga_jual)
      formData.append('kategori', data.kategori)
      formData.append('berat', data.berat)
      formData.append('satuan', data.satuan)
      formData.append('diskon', data.diskon)
      formData.append('rak', data.rak)
      formData.append('keterangan', data.keterangan)
      for (let i = 0; i < files.length; i++) {
        const element = files[i];
        formData.append('files[]', element)
      }
      const sendData = Functions.prototype.uploadFile(urlPostBarang, formData, 'post')
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

  
  $('.custom-file-input').on('change', function(e) {
    $('.pgwSlider').empty()
    if(validateFile($(this))) {
      const files = document.getElementById('inputGroupFile01').files
      const nextSibling = e.target.nextElementSibling
      if(files.length > 1) {
        nextSibling.innerHTML = `${files.length} photo dipilih`
      } else {
        nextSibling.innerHTML = files[0].name
      }
      Functions.prototype.readURL(files)
    }
  })

  function validateFile(input) {  
    var fileType = ['.jpg', '.jpeg', '.png']
    var val = $(input).val()
    if (val.length > 0) {
        var fileValid = false
        for (let i = 0; i < fileType.length; i++) {
            const element = fileType[i];
            if(val.substr(val.length - element.length, element.length).toLowerCase() == element.toLowerCase()) {
                fileValid = true
                // break
            }
        }

        if(!fileValid) {
            toastr.warning("Type file tidak valid", 'perhatian!')
            $('.custom-file-label').text("Choose file")
            $(input).val("")
            return false
        }
    }
    return true
  }

  // get data
  const urlListProduct = URL_API + "/managements"
  const columns = [
    { data : 'checkbox', name: 'checkbox', orderable: false, searchable: false },
    {data : 'kode_barang', name: 'kode_barang'},
    {data : 'nama_barang', name: 'nama_barang'},
    {data : 'stok', name: 'stok'},
    {data : 'harga_dasar', name: 'harga_dasar'},
    {data : 'harga_jual', name: 'harga_jual'},
    {data : 'actions', name: 'actions', orderable: false, searchable: false},
  ]
  Functions.prototype.tableResult("#dataTables", urlListProduct, columns)
});