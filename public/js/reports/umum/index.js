$(document).ready(function () {
    getTransactionsNow.loadData = ""
    getTransactionsYesterday.loadData = "?date=kemarin"
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
                        modal += cart.product.harga_dasar * cart.qyt
                    })  
                }
            })
        }
        const keuntungan = total - modal
        keuntunganHariIni = keuntungan
        pendapatanHariIni = total
        $('#keuntungan').text(Functions.prototype.formatRupiah(keuntunganHariIni.toString(), 'Rp. '))
        $('#pendapatan').text(Functions.prototype.formatRupiah(pendapatanHariIni.toString(), 'Rp. '))
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
        var percenseharian = 0
        var persentaseKeuntungan = 0
        var persentasePendapatan = 0
        if(totalTransaksiKemarin <= 0) {
            percenseharian = 100
        } else {
            percenseharian = Math.floor((totalTransaksiHariIni / totalTransaksiKemarin) * 100)
        }

        if (keuntungan <= 0) {
            persentaseKeuntungan = 100
        } else {
            persentaseKeuntungan = Math.floor(((keuntunganHariIni - keuntungan) / keuntungan) * 100)
        }
        if (total <= 0) {
            persentasePendapatan = 100
        } else {
            persentasePendapatan = Math.floor(((pendapatanHariIni - total) / total) * 100)
        }

        $('#percentaseTotalTrx').text(percenseharian + '%')
        $('#percentaseTotalKeuntungan').text(persentaseKeuntungan + '%')
        $('#percentaseTotalPendapatan').text(persentasePendapatan + '%')
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
                    totalModal += cart.product.harga_dasar * cart.qyt
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
                        stepSize : 5000
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