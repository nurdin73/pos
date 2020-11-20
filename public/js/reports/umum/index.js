$(document).ready(function () {
    var ctx = document.getElementById('myChart').getContext('2d');
    var ctx2 = document.getElementById('myChart2').getContext('2d');
    var ctx3 = document.getElementById('myChart3').getContext('2d');
    createChart(ctx, 'Jumlah Transaksi')
    createChart(ctx2, 'Pendapatan')
    createChart(ctx3, 'Keuntungan')

    getTransactionsNow.loadData = ""
    getTransactionsYesterday.loadData = "?date=kemarin"
});
function createChart(field, nameLabel) {  
    var chart = new Chart(field, {
        // The type of chart we want to create
        type: 'line',
    
        // The data for our dataset
        data: {
            labels: ['00:00', '01:00', '02:00', '03:00', '04:00', '05:00', '06:00', '07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00'],
            datasets: [{
                label: nameLabel,
                backgroundColor: '#321fdb',
                borderColor: 'rgb(255, 99, 132)',
                data: [0, 10, 5, 2, 20, 30, 45]
            }]
        },
    
        // Configuration options go here
        options: {}
    });
}


const getTransactionsNow = {
    set loadData(data) {
        const url = URL_API + "/managements/transaksi"
        Functions.prototype.getRequest(getTransactionsNow, url)
    },
    set successData(response) {
        var total = 0
        var modal = 0
        if(response.length > 0) {
            response.map(result => {
                total += result.total
                if(result.carts.length > 0) {
                    result.carts.map(cart => {
                        modal += cart.product.harga_dasar * cart.qyt
                    })  
                }
            })
        }
        const keuntungan = total - modal
        $('#keuntungan').text(Functions.prototype.formatRupiah(keuntungan.toString(), 'Rp. '))
        $('#pendapatan').text(Functions.prototype.formatRupiah(total.toString(), 'Rp. '))
        $('#countTransaction').text(response.length)
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}
const getTransactionsYesterday = {
    set loadData(data) {
        const url = URL_API + "/managements/transaksi" + data
        Functions.prototype.getRequest(getTransactionsYesterday, url)
    },
    set successData(response) {
        var total = 0
        var modal = 0
        if(response.length > 0) {
            response.map(result => {
                total += result.total
                if(result.carts.length > 0) {
                    result.carts.map(cart => {
                        modal += cart.product.harga_dasar * cart.qyt
                    })  
                }
            })
        }
        const keuntungan = total - modal
        const totalTransaksiHariIni = parseInt($('#countTransaction').text()) - response.length
        const totalTransaksiKemarin = response.length
        var percenseharian = Math.floor((totalTransaksiKemarin / totalTransaksiHariIni) * 100)
        if(totalTransaksiKemarin == 0 && totalTransaksiHariIni == 0) {
            percenseharian = 0
        }
        $('#percentaseTotalTrx').text(percenseharian + '%')
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}