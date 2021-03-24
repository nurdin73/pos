$(document).ready(function () {
    getTransactions.loadData = ""
    getChartTransactions.loadData = ""
    listBestSeller.loadData = ""
    listNewTransactions.loadData = ""
    $('.waktu').on('click', function(e) {
        e.preventDefault()
        const label = $(this).data('show')
        $('#labelGrafik').text(label)
        const waktu = $(this).data('waktu')
        const query_params = "?time=" + waktu
        getChartTransactions.loadData = query_params 
    })
});

const getTransactions = {
    set loadData(data) {
        const url = URL_API + "/dashboard/transaksi"
        Functions.prototype.requestDetail(getTransactions, url)
    },
    set successData(response) {
        $('#countTransaction').text(response.total_trx)
        $('#countPendapatan').text(Functions.prototype.formatRupiah(response.total.toString(), 'Rp. '))
        if(response.keuntungan < 0) {
            $('#countKeuntungan').text(Functions.prototype.formatRupiah(response.keuntungan.toString(), 'Rp. -'))
        } else {
            $('#countKeuntungan').text(Functions.prototype.formatRupiah(response.keuntungan.toString(), 'Rp. '))
        }
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}

const getChartTransactions = {
    set loadData(data) {
        const url = URL_API + "/dashboard/chart-transactions" + data
        Functions.prototype.requestDetail(getChartTransactions, url)
    },
    set successData(response) {
        // resetCanvas()
        const labels = Object.keys(response)
        const datasets = Object.values(response)
        let modal = []
        let pendapatan = []
        let keuntungan = []
        datasets.map(ds => {
            let totalModal = 0
            let totalPendapatan = 0
            let totalKeuntungan = 0
            ds.map(dataset => {
                totalModal += dataset.modal
                totalPendapatan += dataset.pendapatan
                totalKeuntungan += dataset.keuntungan
            })
            modal.push(totalModal)
            pendapatan.push(totalPendapatan)
            keuntungan.push(totalKeuntungan)
        })
        const dataset = [
            {
                label: 'Modal Terpakai',
                fill: false,
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: modal,
            },
            {
                label: 'Pendapatan',
                fill: false,
                backgroundColor: 'rgb(224, 123, 57)',
                borderColor: 'rgb(224, 123, 57)',
                data: pendapatan,
            },
            {
                label: 'Keuntungan',
                fill: false,
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
                        stepSize : 50000
                    },

                }]
            }
        }
        Functions.prototype.createManyChart(resetCanvas(), 'bar', dataset, labels, options)
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}

var resetCanvas = function () {
    $('#grafikTrx').remove(); // this is my <canvas> element
    $('#grafik-field').append('<canvas id="grafikTrx"><canvas>');
    canvas = document.querySelector('#grafikTrx'); // why use jQuery?
    ctx = canvas.getContext('2d');
    return ctx
};

const listBestSeller = {
    set loadData(data) {
        const url = URL_API + "/dashboard/best-seller"
        Functions.prototype.getRequest(listBestSeller, url)
    },
    set successData(response) {
        if(response.length > 0) {
            response.map(result => {
                $('#listBestSeller').append(`
                    <tr>
                        <td>${result.nama_barang.substr(0, 20)}</td>
                        <td>${result.selled}</td>
                        <td>${Functions.prototype.formatRupiah(result.harga_jual.toString(), 'Rp. ')}</td>
                    </tr>
                `)
            })
        } else {
            $('#listBestSeller').append(`
                <tr>
                    <td colspan="4" align="center">Tidak ada produk terlaris</td>
                </tr>
            `)
        }
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}

const listNewTransactions = {
    set loadData(data) {
        const url = URL_API + "/dashboard/new-transactions"
        Functions.prototype.getRequest(listNewTransactions, url)
    },
    set successData(response) {
        if(response.length > 0) {
            response.map(result => {
                $('#listNewTransactions').append(`
                    <tr>
                        <td>${result.no_invoice}</td>
                        <td>${result.customer == null ? `<span class="badge badge-info">Umum</span>` : `<span class="badge badge-info">${result.customer.nama}</span>`}</td>
                        <td>${moment(result.tgl_transaksi).format('D MMM YYYY')}</td>
                        <td>${Functions.prototype.formatRupiah(result.total.toString(), 'Rp. ')}</td>
                    </tr>
                `)
            })
        } else {
            $('#listNewTransactions').append(`
                <tr>
                    <td colspan="4" align="center">Tidak ada transaksi</td>
                </tr>
            `)
        }
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}