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
        const url = URL_API + "/reports/customer" + data
        Functions.prototype.getRequest(getChart, url)
    },
    set successData(response) {
        const labels = Object.keys(response.data)
        const datasets = Object.values(response.data)
        let total = response.total
        let totalCustYesterday = response.totalCustYesterday
        let totalCustNow = response.totalCustNow

        $('#totalCustomer').text(total)
        $('#totalCustYesterday').text(totalCustYesterday)
        $('#totalCustNow').text(totalCustNow)

        const data = [
            {
                label: 'Pelanggan',
                backgroundColor: coreui.Utils.hexToRgba(coreui.Utils.getStyle('--info', document.getElementsByClassName('c-app')[0]), 10),
                borderColor: coreui.Utils.getStyle('--info', document.getElementsByClassName('c-app')[0]),
                pointHoverBackgroundColor: '#fff',
                borderWidth: 2,
                data: datasets,
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