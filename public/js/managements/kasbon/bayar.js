$(document).ready(function() {
	var query_params = ""

	getDetail.loadData = query_params

	$('.pagination').on('click', '.page-item .page-link', function(e) {
        e.preventDefault()
        const page = $(this).data('id');
		query_params = "?page=" + page
		getDetail.loadData = query_params
		// query_params = ""
    })
	bayar()
})

const getDetail = {
	set loadData(data) {
		const urlDetail = URL_API + "/managements/kasbon-pelanggan/" + id + data
		Functions.prototype.requestDetail(getDetail, urlDetail)
	},
	set successData(response) {
		$('#listData').empty()
		var totalkasbon = 0
		$('#nama_pelanggan').text(response.nama)
		$('#email_pelanggan').text(response.email)
		$('#telp_pelanggan').text(response.no_telp)
		$('#alamat_pelanggan').text(response.alamat)
		if(response.cash_receipts.data.length > 0) {
			response.cash_receipts.data.map(result => {
				totalkasbon += result.jumlah
				$('#listData').append(`
					<tr>
						<td>${Functions.prototype.formatRupiah(result.jumlah.toString(), 'Rp. ')}</td>
						<td>${moment(result.tgl_kasbon).format('D MMMM YYYY h:mm:ss')}</td>
						<td>${moment(result.jatuh_tempo).format('D MMMM YYYY')}</td>
						<td>${result.status == "belum lunas" ? `<span class="badge badge-danger">${result.status}</span>` : `<span class="badge badge-success">${result.status}</span>`}</td>
                        <td align="center">
                            ${result.status == "belum lunas" ? 
                                `<button class="btn btn-sm btn-success bayar" data-id="${result.id}" data-toggle="modal" data-target="#bayarKasbon">Pembayaran Kasbon</button>` :
                                `<span class="btn btn-sm btn-success">Lunas</span>`
                            }
                        </td>
					</tr>
				`)
			})
		}
		const { current_page, last_page, prev_page_url } = response.cash_receipts
		var paginations = Functions.prototype.createPaginate(current_page, last_page, prev_page_url)
		$('.pagination').html(paginations)
		paginations = ""
		$('#totalKasbon').text(Functions.prototype.formatRupiah(response.total_kasbon.toString(), 'Rp. '))
		$('#total_transaksi').text(response.cash_receipts.total)
	},
	set errorData(err) {
		toastr.error(err.responseJSON.message, 'error')
	} 
}

function bayar() {  
	$('#listData').on('click', 'tr td .bayar', function(e) {
		const id = $(this).data('id')
		getDetailData.loadData = id
	})
	const getDetailData = {
		set loadData(data) {
			const urlKasbon = URL_API + "/managements/kasbon/" + data
			Functions.prototype.requestDetail(getDetailData, urlKasbon)
		},
		set successData(response) {
			$('#listCicilan').empty()
			var sisa = response.jumlah
			$('#customerName').text(response.customer.nama)
			$('#tglTransaksi').text(moment(response.tgl_kasbon).format('D MMMM YYYY h:mm:ss'))
			$('#tglTempo').text(moment(response.jatuh_tempo).format('D MMMM YYYY'))
			$('.totalKasbon').text(Functions.prototype.formatRupiah(response.jumlah.toString(), 'Rp. '))
			if(response.installments.length > 0) {
				response.installments.map(result => {
					sisa -= result.cicilan
					$('#listCicilan').append(`
						<tr>
							<td>${Functions.prototype.formatRupiah(result.cicilan.toString(), 'Rp. ')}</td>
							<td>${moment(result.tgl_pembayaran).format('D MMMM YYYY')}</td>
							<td>${Functions.prototype.formatRupiah(sisa.toString(), 'Rp. ')}</td>
						</tr>
					`)
				})
			} else {
				$('#listCicilan').append(`
				<tr>
					<td colspan="3" align="center">Cicilan belum ada</td>
				</tr>
				`)
			}
			$('#sisa').text(Functions.prototype.formatRupiah(sisa.toString(), 'Rp. '))
			if(sisa != 0) {
				$('.status').html(`<span class="badge badge-danger">Belum lunas</span>`)
				$('.btn-bayar').text('Lanjutkan pembayaran').attr('disabled', false).removeClass('disabled btn-success').addClass('btn-primary')
			} else {
				$('.status').html('<span class="badge badge-success">Lunas</span>')
				$('.btn-bayar').text('Sudah Lunas').attr('disabled', true).addClass('btn-success disabled').removeClass('btn-primary')
			}
		},
		set errorData(err) {
			console.log(err);
		}
	}
}