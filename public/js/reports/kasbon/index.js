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
        const url = URL_API + "/reports/kasbon" + data
        Functions.prototype.getRequest(getChart, url)
    },
    set successData(response) {
        const labels = Object.keys(response.data)
        const datasets = Object.values(response.data)
        let totalKasbon = response.totalKasbon
        let totalSisa = response.totalSisaKasbon
        let totalDibayar = response.totalDibayar
        let dibayar = []
        let sisa = []
        let jumlah = []
        datasets.map(ds => {
            let terbayar = 0
            let tersisa = 0
            let total = 0
            ds.map(result => {
                terbayar += result.dibayar
                tersisa += result.sisa
                total += result.jumlah
            })
            dibayar.push(terbayar)
            jumlah.push(total)
            sisa.push(tersisa)
        })

        $('#totalKasbon').text(Functions.prototype.kFormatter(totalKasbon, 'Rp. '))
        $('#totalDibayar').text(Functions.prototype.kFormatter(totalDibayar, 'Rp. '))
        $('#totalSisa').text(Functions.prototype.kFormatter(totalSisa, 'Rp. '))

        const data = [
            {
                label: 'Total Kasbon',
                backgroundColor: coreui.Utils.hexToRgba(coreui.Utils.getStyle('--info', document.getElementsByClassName('c-app')[0]), 10),
                borderColor: coreui.Utils.getStyle('--info', document.getElementsByClassName('c-app')[0]),
                pointHoverBackgroundColor: '#fff',
                borderWidth: 2,
                data: jumlah,
            },
            {
                label: 'Telah dibayar',
                backgroundColor: 'transparent',
                borderColor: coreui.Utils.getStyle('--success', document.getElementsByClassName('c-app')[0]),
                pointHoverBackgroundColor: '#fff',
                borderWidth: 2,
                data: dibayar,
            },
            {
                label: 'Belum dibayar',
                backgroundColor: 'transparent',
                borderColor: coreui.Utils.getStyle('--danger', document.getElementsByClassName('c-app')[0]),
                pointHoverBackgroundColor: '#fff',
                borderWidth: 1,
                borderDash: [8, 5],
                data: sisa,
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