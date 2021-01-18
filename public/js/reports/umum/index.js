$(document).ready(function () {
    getTransactionsNow.loadData = ""
    getTrxPerJam.loadData = ""
});


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
                        var harga_dasar = 0
                        if(cart.product.stocks.length > 0) {
                            cart.product.stocks.map(stock => {
                                harga_dasar = stock.harga_dasar
                            })
                            modal += harga_dasar * cart.qyt
                        }
                    })  
                }
            })
        }
        const keuntungan = total - modal
        keuntunganHariIni = keuntungan
        pendapatanHariIni = total
        if(keuntunganHariIni < 0) {
            $('#keuntungan').text(Functions.prototype.formatRupiah(keuntunganHariIni.toString(), 'Rp. -'))
        } else {
            $('#keuntungan').text(Functions.prototype.formatRupiah(keuntunganHariIni.toString(), 'Rp. '))
        }
        $('#pendapatan').text(Functions.prototype.formatRupiah(pendapatanHariIni.toString(), 'Rp. '))
        $('#countTransaction').text(response.length)
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}

const getTrxPerJam = {
    set loadData(data) {
        const url = URL_API + "/managements/transaksi-per-jam"
        Functions.prototype.getRequest(getTrxPerJam, url)
    },
    set successData(response) {
        const dataset = Object.values(response)
        var totalTrx = [];
        var totalKeuntungan = [];
        var totalPendapatan = []
        dataset.map(ds => {
            totalTrx.push(ds.length)
            var totalModal = 0
            var totalPembelian = 0
            ds.map(trx => {
                totalPembelian += trx.total
                trx.carts.map(cart => {
                    var harga_dasar = 0
                    if(cart.product.stocks.length > 0) {
                        cart.product.stocks.map(stok => {
                            harga_dasar = stok.harga_dasar
                        })
                        totalModal += harga_dasar * cart.qyt
                    }
                })
            })
            const keuntunganTotal = totalPembelian - totalModal
            const pendapatan = totalPembelian
            totalKeuntungan.push(keuntunganTotal)
            totalPendapatan.push(pendapatan)
        })
        var jam = Object.keys(response)
        var ctx = document.getElementById('myChart').getContext('2d');
        const optionsTotalTrx = {
            responsive: true,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        stepSize : 10
                    },

                }]
            }
        }
        const optionsTotal = {
            responsive: true,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        stepSize : 50000
                    },

                }]
            }
        }
        Functions.prototype.createChart(ctx, 'line', 'Total Transaksi', totalTrx, jam, optionsTotalTrx)
        Functions.prototype.createChart($('#keuntunganChart'), 'line', 'Total Keuntungan', totalKeuntungan, jam, optionsTotal)
        Functions.prototype.createChart($('#pendapatanChart'), 'line', 'Total Pendapatan', totalPendapatan, jam, optionsTotal)
    },
    errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}