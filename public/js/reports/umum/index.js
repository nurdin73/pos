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
        $('#keuntungan').text(Functions.prototype.kFormatter(response.keuntungan, 'Rp. '))
        $('#pendapatan').text(Functions.prototype.kFormatter(response.total, 'Rp. '))
        $('#countTransaction').text(response.total_trx)
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
                    }
                    if(cart.eceran == 1) {
                        var hargaEcerModal = Math.floor(harga_dasar / cart.product.jumlahEceranPermanent)
                        totalModal += Math.floor(hargaEcerModal * cart.qyt)
                    } else {
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
            },
            maintainAspectRatio: false,
			spanGaps: false,
			elements: {
				line: {
					tension: 0.000001
				}
			},
			plugins: {
				filler: {
					propagate: false
				}
			},
        }
        const optionsTotal = {
            responsive: true,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        stepSize : 1000000
                    },

                }]
            },
        }
        Functions.prototype.createChart(ctx, 'line', 'Total Transaksi', totalTrx, jam, optionsTotalTrx)
        Functions.prototype.createChart($('#keuntunganChart'), 'line', 'Total Keuntungan', totalKeuntungan, jam, optionsTotal)
        Functions.prototype.createChart($('#pendapatanChart'), 'line', 'Total Pendapatan', totalPendapatan, jam, optionsTotal)
    },
    errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}