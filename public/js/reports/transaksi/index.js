$(document).ready(function() {
	getTrxPerJam.loadData = ""
	getTrxPerDays.loadData = ""
	getTrxPerMonth.loadData = ""
	getTrxPerYears.loadData = ""
})

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
                    cart.product.stocks.map(stock => {
                        harga_dasar = stock.harga_dasar
                    })
                    totalModal += harga_dasar * cart.qyt
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


const getTrxPerDays = {
    set loadData(data) {
        const url = URL_API + "/managements/transaksi-per-hari"
        Functions.prototype.getRequest(getTrxPerDays, url)
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
                    cart.product.stocks.map(stock => {
                        harga_dasar = stock.harga_dasar
                    })
                    totalModal += harga_dasar * cart.qyt
                })
            })
            const keuntunganTotal = totalPembelian - totalModal
            const pendapatan = totalPembelian
            totalKeuntungan.push(keuntunganTotal)
            totalPendapatan.push(pendapatan)
        })
        var jam = Object.keys(response)
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
        Functions.prototype.createChart($('#jmlTrxDays'), 'line', 'Total Transaksi', totalTrx, jam, optionsTotalTrx)
        Functions.prototype.createChart($('#keuntunganPerHari'), 'line', 'Total Keuntungan', totalKeuntungan, jam, optionsTotal)
        Functions.prototype.createChart($('#pendapatanPerHari'), 'line', 'Total Pendapatan', totalPendapatan, jam, optionsTotal)
    },
    errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}

const getTrxPerMonth = {
    set loadData(data) {
        const url = URL_API + "/managements/transaksi-per-bulan"
        Functions.prototype.getRequest(getTrxPerMonth, url)
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
                    cart.product.stocks.map(stock => {
                        harga_dasar = stock.harga_dasar
                    })
                    totalModal += harga_dasar * cart.qyt
                })
            })
            const keuntunganTotal = totalPembelian - totalModal
            const pendapatan = totalPembelian
            totalKeuntungan.push(keuntunganTotal)
            totalPendapatan.push(pendapatan)
        })
        var jam = Object.keys(response)
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
        Functions.prototype.createChart($('#jmlTrxMonth'), 'line', 'Total Transaksi', totalTrx, jam, optionsTotalTrx)
        Functions.prototype.createChart($('#keuntunganPerBulan'), 'line', 'Total Keuntungan', totalKeuntungan, jam, optionsTotal)
        Functions.prototype.createChart($('#pendapatanPerBulan'), 'line', 'Total Pendapatan', totalPendapatan, jam, optionsTotal)
    },
    errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}

const getTrxPerYears = {
    set loadData(data) {
        const url = URL_API + "/managements/transaksi-per-tahun"
        Functions.prototype.getRequest(getTrxPerYears, url)
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
                    cart.product.stocks.map(stock => {
                        harga_dasar = stock.harga_dasar
                    })
                    totalModal += harga_dasar * cart.qyt
                })
            })
            const keuntunganTotal = totalPembelian - totalModal
            const pendapatan = totalPembelian
            totalKeuntungan.push(keuntunganTotal)
            totalPendapatan.push(pendapatan)
        })
        var jam = Object.keys(response)
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
        Functions.prototype.createChart($('#jmlTrxYears'), 'line', 'Total Transaksi', totalTrx, jam, optionsTotalTrx)
        Functions.prototype.createChart($('#keuntunganPerYears'), 'line', 'Total Keuntungan', totalKeuntungan, jam, optionsTotal)
        Functions.prototype.createChart($('#pendapatanPerYears'), 'line', 'Total Pendapatan', totalPendapatan, jam, optionsTotal)
    },
    errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}