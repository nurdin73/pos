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
        const gettingData = gettingCharts(response)
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
                        stepSize : 1000000
                    },

                }]
            }
        }
        Functions.prototype.createChart(ctx, 'line', 'Total Transaksi', gettingData.totalTrx, jam, optionsTotalTrx)
        Functions.prototype.createChart($('#keuntunganChart'), 'line', 'Total Keuntungan', gettingData.totalKeuntungan, jam, optionsTotal)
        Functions.prototype.createChart($('#pendapatanChart'), 'line', 'Total Pendapatan', gettingData.totalPendapatan, jam, optionsTotal)
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
        const gettingData = gettingCharts(response)
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
                        stepSize : 1500000
                    },

                }]
            }
        }
        Functions.prototype.createChart($('#jmlTrxDays'), 'line', 'Total Transaksi', gettingData.totalTrx, jam, optionsTotalTrx)
        Functions.prototype.createChart($('#keuntunganPerHari'), 'line', 'Total Keuntungan', gettingData.totalKeuntungan, jam, optionsTotal)
        Functions.prototype.createChart($('#pendapatanPerHari'), 'line', 'Total Pendapatan', gettingData.totalPendapatan, jam, optionsTotal)
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
        const gettingData = gettingCharts(response)
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
                        stepSize : 2000000
                    },

                }]
            }
        }
        Functions.prototype.createChart($('#jmlTrxMonth'), 'line', 'Total Transaksi', gettingData.totalTrx, jam, optionsTotalTrx)
        Functions.prototype.createChart($('#keuntunganPerBulan'), 'line', 'Total Keuntungan', gettingData.totalKeuntungan, jam, optionsTotal)
        Functions.prototype.createChart($('#pendapatanPerBulan'), 'line', 'Total Pendapatan', gettingData.totalPendapatan, jam, optionsTotal)
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
        const gettingData = gettingCharts(response)
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
                        stepSize : 5000000
                    },

                }]
            }
        }
        Functions.prototype.createChart($('#jmlTrxYears'), 'line', 'Total Transaksi', gettingData.totalTrx, jam, optionsTotalTrx)
        Functions.prototype.createChart($('#keuntunganPerYears'), 'line', 'Total Keuntungan', gettingData.totalKeuntungan, jam, optionsTotal)
        Functions.prototype.createChart($('#pendapatanPerYears'), 'line', 'Total Pendapatan', gettingData.totalPendapatan, jam, optionsTotal)
    },
    errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}




function gettingCharts(data = {}) {
    const dataset = Object.values(data)
    var totalTrx = [];
    var totalKeuntungan = [];
    var totalPendapatan = []
    dataset.map(ds => {
        totalTrx.push(ds.totalTrx)
        totalKeuntungan.push(ds.totalKeuntungan)
        totalPendapatan.push(ds.totalPendapatan)
    })
    return {
        totalTrx,
        totalKeuntungan,
        totalPendapatan
    }
}