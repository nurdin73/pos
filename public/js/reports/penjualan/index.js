$(document).ready(function () {
    getDataPenjualan.loadData = ""
});

const getDataPenjualan = {
    set loadData(data) {
        const url = URL_API + "/reports/penjualan-barang"
        Functions.prototype.requestDetail(getDataPenjualan, url)
    },
    set successData(response) {
        const labels = Object.keys(response)
        const datasets = Object.values(response)
        let modal = []
        let pendapatan = []
        let keuntungan = []
        datasets.map(ds => {
            modal.push(ds.modal)
            pendapatan.push(ds.pendapatan)
            keuntungan.push(ds.keuntungan)
        })
        const dataset = [
            {
                label: 'Modal Terpakai',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: modal,
            },
            {
                label: 'Pendapatan',
                backgroundColor: 'rgb(224, 123, 57)',
                borderColor: 'rgb(224, 123, 57)',
                data: pendapatan,
            },
            {
                label: 'Keuntungan',
                backgroundColor: 'rgb(4, 47, 102)',
                borderColor: 'rgb(4, 47, 102)',
                data: keuntungan,
            },
        ]
        const options = {
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
        Functions.prototype.createManyChart($('#budgetSale'), 'bar', dataset, labels, options)
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}