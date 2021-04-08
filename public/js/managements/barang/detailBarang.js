$(document).ready(function() {
	getDetail.loadData = id
	$('#kategori').select2({
        theme:'bootstrap4',
        ajax: {
            url: URL_API + "/managements/categories",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Authorization' : "Bearer " + sessionStorage.getItem('token')
            },
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

    $('.pagination').on('click', '.page-item .page-link', function(e) {
        e.preventDefault()
        const page = $(this).data('id');
		var query_params = id + "?page=" + page
		getDetail.loadData = query_params
    })
})

const getDetail = {
    set loadData(data) {
        const urlDetail = URL_API + "/managements/barang/" + data
        Functions.prototype.requestDetail(getDetail, urlDetail)
    },
    set successData(response) {
        var harga_dasar = 0
        var stocks = 0
        response.stocks.map(resultStok => {
            stocks += resultStok.stok
            harga_dasar = resultStok.harga_dasar
        })
        $('#nama_barang').val(response.nama_barang)
        var option = response.suplier != null ? new Option(response.suplier.nama_suplier, response.suplier.id, true, true) : new Option("", null, true, true)
        $("#suplier").append(option).trigger('change')

        $("#suplier").trigger({
            type: 'select2:select',
            params: {
                data : response.suplier != null ? response.suplier.nama_suplier : ""
            }
        })
        var option2 = response.branch != null ? new Option(response.branch.nama_cabang, response.branch.id, true, true) : new Option("", null, true, true)
        $("#cabang").append(option2).trigger('change')

        $("#cabang").trigger({
            type: 'select2:select',
            params: {
                data : response.branch != null ? response.branch.nama_cabang : ""
            }
        })
        $('#type_barang').val(response.type_barang).trigger('change').attr('disabled', true)
        $('#stok').val(stocks)
        $('#harga_dasar').val(Functions.prototype.formatRupiah(harga_dasar.toString(), 'Rp. '))
        $('#harga_jual').val(Functions.prototype.formatRupiah(response.harga_jual.toString(), 'Rp. '))
        $('#kategori').val(response.kategori_id)
        $('#berat').val(response.berat)
        $('#satuan').val(response.satuan).attr('disabled', true)
        $('#diskon').val(response.diskon)
        $('#rak').val(response.rak)
        $('#keterangan').val(response.keterangan)
        $('#point').val(response.point)
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
        if(response.type_prices.length > 0) {
            $('#listTypeHarga').empty()
            response.type_prices.map(price => {
                $('#listTypeHarga').append(`
                <div class="border rounded p-2 mb-2 listTypeHarga">
                    <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted">Type : ${price.nama_agen}</span>
                    <input type="hidden" name="nama_agent[]" value="${price.nama_agen}" />
                    </div>
                    <div class="dropdown-divider"></div>
                    <div class="row">
                    <div class="col-3">
                        1
                    </div>
                    <div class="col-9">
                        <span id="harga">${Functions.prototype.formatRupiah(price.harga.toString(), 'Rp. ')}</span>
                        <input type="hidden" name="type_harga[]" value="${price.harga}" />
                    </div>
                    </div>
                </div>
                `)
            })
        }
        if(response.isRetail == 1) {
            $('#infoEceran').text(`Barang ini bisa dijual eceran`)
        } else {
            $('#infoEceran').text(`Barang ini tidak bisa dijual eceran`)
        }
        if(response.code_products.data.length > 0) {
            $('#listCodeProduct').empty()
            const { data, current_page, prev_page_url, next_page_url } = response.code_products
            response.code_products.data.map(result => {
                $('#listCodeProduct').append(`
                    <tr>
                        <td>${result.kode_barang}</td>
                    </tr>
                `)
            })
            $('.pagination').empty()
            const pagination = Functions.prototype.createPaginate(current_page, prev_page_url, next_page_url)
            $('.pagination').html(pagination)
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

