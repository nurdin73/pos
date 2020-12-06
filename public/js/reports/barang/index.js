$(document).ready(function () {
    getChart.loadData = ""
    $('.timeBtn').on('click', function(e) {
        e.preventDefault()
        const query = $(this).data('query')
        getChart.loadData = "?query=" + query
    })
});

const getChart = {
    set loadData(data) {
        const url = URL_API + "/reports/barang" + data
        Functions.prototype.getRequest(getChart, url)
    },
    set successData(response) {
        const labels = Object.keys(response.data)
        const datasets = Object.values(response.data)
        let totalStok = response.totalStok
        let totalProductIn = response.totalProductIn
        let totalProductOut = response.totalProductOut
        let stokProdIn = []
        let stokProdOut = []
        datasets.map(ds => {
            let prodIn = 0,
                prodOut = 0
            ds.map(result => {
                prodIn += result.totalProductIn
                prodOut += result.totalProductOut
            })
            stokProdIn.push(prodIn)
            stokProdOut.push(prodOut)
        })


        $('#totalBarang').text(totalStok)
        $('#totalBarangMasuk').text(totalProductIn)
        $('#totalBarangKeluar').text(totalProductOut)

        const data = [
            {
                label: 'Barang Tersedia',
                backgroundColor: 'transparent',
                borderColor: coreui.Utils.getStyle('--success', document.getElementsByClassName('c-app')[0]),
                pointHoverBackgroundColor: '#fff',
                borderWidth: 2,
                data: stokProdIn,
            },
            {
                label: 'Barang Terjual',
                backgroundColor: 'transparent',
                borderColor: coreui.Utils.getStyle('--danger', document.getElementsByClassName('c-app')[0]),
                pointHoverBackgroundColor: '#fff',
                borderWidth: 1,
                borderDash: [8, 5],
                data: stokProdOut,
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
        Functions.prototype.createManyChart(resetCanvas(), 'line', data, labels, options)
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