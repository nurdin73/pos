$(document).ready(function () {
    getDetail.loadData = id
    addData()
});

const getDetail = {
    set loadData(data) {
        const urlDetail = URL_API + "/managements/kasbon/" + data
        Functions.prototype.requestDetail(getDetail, urlDetail)
    },
    set successData(response) {
        var sisa = response.jumlah
        $('#nameCust').text(response.customer.nama)
        $('#custEmail').text(response.customer.email)
        $('#custTelp').text(response.customer.no_telp)
        $('#custAddress').text(response.customer.alamat)
        if(response.installments.length > 0) {
            response.installments.map(result => {
                sisa -= result.jumlah
            })
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
                min: 100
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
        submitHandler: function(form, e) {
            e.preventDefault()
            
        }
    })
}