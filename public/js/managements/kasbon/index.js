$(document).ready(function () {
    var query_params = ""
    getDataList.loadData = query_params
    $('#filterData').on('submit', function(e) {
        e.preventDefault()
        query_params = ""
        query_params += $(this).serialize()
        getDataList.loadData = query_params
    })

    $('.paginate').on('click', '.pagination .page-item a', function(e) {
        e.preventDefault()
        const id = $(this).data('id');
        query_params += "&page=" + id
        getDataList.loadData = query_params
    })
    $('#jatuh_tempo').datepicker({
        format: 'yyyy-mm-dd',
    })
    $('#add_jatuh_tempo').datepicker({
        format: 'yyyy-mm-dd',
        startDate: '+7d'
    })
    $('.reset').on('click', function(e) {
        e.preventDefault()
        $('#filterData')[0].reset()
        getDataList.loadData = ""
        query_params = ""
    })
    searchCustomers()
    addKasbon()
});


const getDataList = {
    set loadData(data) {
        const urlKasbonList = URL_API + "/managements/kasbon?" + data
        Functions.prototype.getRequest(getDataList, urlKasbonList)
    },
    set successData(response) {
        var paginations = ""
        $('#listData').empty()
        if(response.data.length > 0) {
            response.data.map(result => {
                $('#listData').append(`
                    <tr>
                        <td>${result.nama}</td>
                        <td>${result.email}</td>
                        <td>${result.no_telp}</td>
                        <td>${Functions.prototype.formatRupiah(result.jumlah.toString(), 'Rp. ')}</td>
                        <td>${Functions.prototype.formatRupiah(result.sisa.toString(), 'Rp. ')}</td>
                        <td align="center">
                            <a href="${window.location.href + '/bayar/' + result.id}" class="btn btn-sm btn-success">Bayar</a>
                        </td>
                    </tr>
                `)
            })
        } else {
            $('#listData').append(`
                <tr>
                    <td colspan="6" align="center">Data not found</td>
                </tr>
            `)
        }
        const { currentPage, pagination } = response.dataset.original
        var paginations = pagination
        $('.paginate').html(paginations)
        $('.paginate').find('a').each(function() {
            if($(this).text() === '‹'){
                $(this).attr('data-id', currentPage - 1);
            }else if($(this).text() === '›'){
                $(this).attr('data-id', currentPage + 1);
            }else{
                $(this).attr('data-id', $(this).html());
            }
        })
        paginations = ""
        $('#totalKasbon').text(Functions.prototype.formatRupiah(response.totalKasbon.toString(), 'Rp. '))
        $('#totalTransaksi').text(response.totalTrx)
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'error')
    }
}

function searchCustomers() {
    $('#nama_pelanggan').select2({
        theme:'bootstrap4',
        ajax: {
            url: URL_API + "/managements/search-pelanggan",
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
                            text: result.nama,
                            id: result.id
                        }
                    })
                }
            },
        }
    })
}

function addKasbon() {
    $('#formAddKasbon').validate({
        rules: {
            nama_pelanggan: {
                required: true
            },
            jumlah: {
                required: true,
                number: true,
                min: 1000
            },
            add_jatuh_tempo: {
                required: true,
            },
            keterangan: {
                required: true
            }
        },
        errorClass: "is-invalid",
        validClass: "is-valid",
        errorElement: "small",
        errorPlacement: function errorPlacement(error, element) {
            error.addClass('invalid-feedback');
        
            if (element.prop('type') === 'checkbox') {
              error.insertAfter(element.parent('label'));
            } else {
              error.insertAfter(element);
            }
        },
        // eslint-disable-next-line object-shorthand
        highlight: function highlight(element) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        // eslint-disable-next-line object-shorthand
        unhighlight: function unhighlight(element) {
            $(element).addClass('is-valid').removeClass('is-invalid');
        },
        submitHandler: function(form, e) {
            e.preventDefault()
            const urlPostKasbon = URL_API + "/managements/add/kasbon"
            const data = {
                pelanggan_id : $('#nama_pelanggan').val(),
                jumlah: $('#jumlah').val(),
                jatuh_tempo: $('#add_jatuh_tempo').val(),
                keterangan: $('#keterangan').val()
            }
            Functions.prototype.httpRequest(urlPostKasbon, data, 'post')
            setTimeout(() => {
                window.location.reload()
            }, 3000);
        }
    })
}