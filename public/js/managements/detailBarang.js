$(document).ready(function() {
	getDetail.loadData = id
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
})

const getDetail = {
    set loadData(data) {
        const urlDetail = URL_API + "/managements/barang/" + data
        Functions.prototype.requestDetail(getDetail, urlDetail)
    },
    set successData(response) {
        $('#nama_barang').val(response.nama_barang)
        $('#type_barang').val(response.type_barang).trigger('change').attr('disabled', true)
        $('#stok').val(response.stok)
        $('#kode-barang').text(response.kode_barang)
        $('#harga_dasar').val(response.harga_dasar)
        $('#harga_jual').val(response.harga_jual)
        $('#kategori').val(response.kategori_id)
        $('#berat').val(response.berat)
        $('#satuan').val(response.satuan).trigger('change').attr('disabled', true)
        $('#diskon').val(response.diskon)
        $('#rak').val(response.rak)
        $('#keterangan').val(response.keterangan)
        getKategoriById.loadData = response.kategori_id
        if(response.images.length > 0) {
            var listImage = ""
            response.images.map(image => {
                listImage += `
                    <div class="col-md-3 col-sm-4 col-6 mb-2">
                        <img src="${URL_IMAGE + "/" + image.image}" alt="${URL_IMAGE + "/" + image.image}" class="img-responsive img-fluid img-thumbnail">
                    </div>`
            })
            $('#fieldImage').html(listImage)
        }
    },
    set errorData(err) {
        console.log(err);
    }
}

const getKategoriById = {
    set loadData(data) {
        var url_local = URL_API + "/managements/kategori/" + data
        Functions.prototype.requestDetail(getKategoriById, url_local)
    }, 
    set successData(result) {
        var option = new Option(result.name, result.id, true, true)
        $("#kategori").append(option).trigger('change').attr('disabled', true)

        $("#kategori").trigger({
            type: 'select2:select',
            params: {
                data : data
            }
        })
    },
    set errorData(err) {
        console.log(err);
    }
}

