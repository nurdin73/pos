$(document).ready(function () {
    getTrx.loadData = ""
    $('.timeBtn').on('click', function(e) {
        e.preventDefault()
        const query = $(this).data('query')
        getChartPajak.loadData = "?query=" + query
    })

    getChartPajak.loadData = ""
});

const getTrx = {
    set loadData(data) {
        const url = URL_API + "/reports/pajak"
        Functions.prototype.getRequest(getTrx, url)
    },
    set successData(response) {
        const totalBersih = response.totalPenjualan - response.totalPajak
        $('#totalPenjualan').text(Functions.prototype.formatRupiah(response.totalPenjualan.toString(), 'Rp. '))
        $('#totalPajak').text(Functions.prototype.formatRupiah(response.totalPajak.toString(), 'Rp. '))
        $('#totalBersih').text(Functions.prototype.formatRupiah(totalBersih.toString(), 'Rp. '))
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
} 

const getChartPajak = {
    set loadData(query_params) {
        const url = URL_API + "/managements/chart-pajak" + query_params
        Functions.prototype.getRequest(getChartPajak, url)
    },
    set successData(response) {
        const dataset = Object.values(response)
        const keys = Object.keys(response)
        const totalTrx = []
        const totalPajak = []
        dataset.map(result => {
            totalPajak.push(result.total_pajak)
            totalTrx.push(result.total_transaksi)
        })

        const data = [
            {
                label: 'Total Transaksi',
                backgroundColor: coreui.Utils.hexToRgba(coreui.Utils.getStyle('--info', document.getElementsByClassName('c-app')[0]), 10),
                borderColor: coreui.Utils.getStyle('--info', document.getElementsByClassName('c-app')[0]),
                pointHoverBackgroundColor: '#fff',
                borderWidth: 2,
                data: totalTrx,
            },
            {
                label: 'Total Pajak',
                backgroundColor: 'transparent',
                borderColor: coreui.Utils.getStyle('--success', document.getElementsByClassName('c-app')[0]),
                pointHoverBackgroundColor: '#fff',
                borderWidth: 2,
                data: totalPajak,
            },
        ]
        const options = {
            responsive: true,
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
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        stepSize : 1000000
                    },
                }]
            }
        }

        Functions.prototype.createManyChart(resetCanvas(), 'line', data, keys, options)
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'error');
    }
}

var resetCanvas = function () {
    $('#grafikPajak').remove(); // this is my <canvas> element
    $('#grafik-field').append('<canvas id="grafikPajak"><canvas>');
    canvas = document.querySelector('#grafikPajak'); // why use jQuery?
    ctx = canvas.getContext('2d');
    return ctx
};