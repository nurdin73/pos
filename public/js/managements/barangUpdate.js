$(document).ready(function () {
    getDetail.loadData = id
});

// functions

const getDetail = {
    set loadData(data) {
        const urlDetail = URL_API + "/managements/barang/" + data
        Functions.prototype.requestDetail(getDetail, urlDetail)
    },
    set successData(response) {
        $('#nama_barang').val(response.nama_barang)
        $('#type_barang').val(response.type_barang).trigger('change')
        $('#stok').val(response.stok)
        $('#harga_dasar').val(response.harga_dasar)
        $('#harga_jual').val(response.harga_jual)
        $('#kategori').val(response.kategori_id)
        $('#berat').val(response.berat)
        $('#satuan').val(response.satuan).trigger('change')
        $('#diskon').val(response.diskon)
        $('#rak').val(response.rak)
        $('#keterangan').val(response.keterangan)
        getKategoriById.loadData = response.kategori_id
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
        $("#kategori").append(option).trigger('change')

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

$('.upload').on('change', function(e) {
    e.preventDefault()
    const files = document.getElementById('upload').files
    if(files.length > 1) {
        $('.labelFile').html(`${files.length} File dipilih`)
    } else {
        $('.labelFile').html(files[0].name)
        Functions.prototype.readURLOnlyOne(files)
    }
})