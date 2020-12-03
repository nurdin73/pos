$(document).ready(function () {
    var query_params = id
    getDetail.loadData = query_params
    $('.pagination').on('click', '.page-item .page-link', function(e) {
        e.preventDefault()
        const page = $(this).data('id');
		query_params += "?page=" + page
		getDetail.loadData = query_params
		query_params = id
    })
    addData()
});

const getDetail = {
    set loadData(data) {
        const urlDetail = URL_API + "/managements/kasbon/" + data
        Functions.prototype.requestDetail(getDetail, urlDetail)
    },
    set successData(response) {
        var sisa = response.jumlah
        $('#listData').empty()
        $('#id_user').val(response.customer.id)
        $('#nameCust').text(response.customer.nama)
        $('#custEmail').text(response.customer.email)
        $('#custTelp').text(response.customer.no_telp)
        $('#custAddress').text(response.customer.alamat)
        if(response.installments.data.length > 0) {
            response.installments.data.map(result => {
                sisa -= result.cicilan
                $('#listData').append(`
                    <tr>
                        <td>${Functions.prototype.formatRupiah(result.cicilan.toString(), 'Rp. ')}</td>
                        <td>${moment(result.tgl_pembayaran).format('D MMMM YYYY h:mm:ss')}</td>
                        <td>${result.keterangan}</td>
                        <td>${Functions.prototype.formatRupiah(sisa.toString(), 'Rp. ')}</td>
                    </tr>
                `)
            })
            const { current_page, last_page, prev_page_url } = response.installments
            var paginations = Functions.prototype.createPaginate(current_page, last_page, prev_page_url)
            $('.pagination').html(paginations)
            paginations = ""
        }
        if(sisa < 1) {
            $('#paymentForm').remove()
        } 
        $('#custSisa').text(Functions.prototype.formatRupiah(sisa.toString(), 'Rp. '))
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'error')
    }
}

function addData() {  
    
    $('#paymentForm').validate({
        rules: {
            jumlah: {
                required: true,
                number: true,
                min: 100,
            },
            method_payment: {
                required: true
            },
            keterangan: {
                required: true
            },
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
            const data = {
                cicilan: $('#jumlah').val(),
                method_payment: $('#method_payment').val(),
                keterangan: $('#keterangan').val()
            }
            const urlPost = URL_API + "/managements/add/payment-kasbon/" + id
            Functions.prototype.httpRequest(urlPost, data, 'post')
            setTimeout(() => {
                getDetail.loadData = id
                $('#paymentForm')[0].reset()
            }, 2000);

        }
    })
}