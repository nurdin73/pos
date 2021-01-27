$(document).ready(function () {
    getTrx.loadData = ""
    $('.timeBtn').on('click', function(e) {
        e.preventDefault()
        const query = $(this).data('query')
        getTrx.loadData = "?query=" + query
    })
});

const getTrx = {
    set loadData(data) {
        const url = URL_API + "/reports/pajak"
        Functions.prototype.getRequest(getTrx, url)
    },
    set successData(response) {
        $('#totalPenjualan').text(Functions.prototype.formatRupiah(response.totalPenjualan.toString(), 'Rp. '))
        $('#totalPajak').text(Functions.prototype.formatRupiah(response.totalPajak.toString(), 'Rp. '))
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}