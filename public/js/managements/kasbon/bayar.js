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
		var totalSisa = 0
		$('#nama_pelanggan').text(response.nama)
		$('#email_pelanggan').text(response.email)
		$('#telp_pelanggan').text(response.no_telp)
		$('#alamat_pelanggan').text(response.alamat)
		if(response.cash_receipts.data.length > 0) {
			response.cash_receipts.data.map(result => {
				totalkasbon += result.jumlah
				var sisa = result.jumlah
				if(result.installments.length > 0) {
					result.installments.map(installment => {
						sisa -= installment.cicilan
					})
				}
				$('#listData').append(`
					<tr>
						<td>${Functions.prototype.formatRupiah(result.jumlah.toString(), 'Rp. ')}</td>
						<td>${moment(result.tgl_kasbon).format('D MMMM YYYY h:mm:ss')}</td>
						<td>${moment(result.jatuh_tempo).format('D MMMM YYYY')}</td>
						<td>${sisa > 0 ? `<span class="badge badge-danger">Belum lunas</span>` : `<span class="badge badge-success">Lunas</span>`}</td>
                        <td align="center">
                            ${sisa > 0 ? 
                                `<button class="btn btn-sm btn-success bayar" data-id="${result.id}" data-toggle="modal" data-target="#bayarKasbon">Pembayaran Kasbon</button>` :
                                `<span class="btn btn-sm btn-success disabled">Lunas</span>`
                            }
                        </td>
					</tr>
				`)
			})
		}
		const { current_page, prev_page_url, next_page_url } = response.cash_receipts
		var paginations = Functions.prototype.createPaginate(current_page, prev_page_url, next_page_url)
		$('.pagination').html(paginations)
		paginations = ""
		$('#totalKasbon').text(Functions.prototype.formatRupiah(response.total_kasbon.toString(), 'Rp. '))
		$('#total_transaksi').text(response.total_trx)
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
			if(response.installments.data.length > 0) {
				response.installments.data.map(result => {
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
			const message = "Haloo, Kamu belum bayar " + Functions.prototype.formatRupiah(sisa.toString(), 'Rp. ') + " di " + NAMA_TOKO + ". Mohon segera selesaikan pembayarannya yah :)"
			// const message = "https://images.unsplash.com/photo-1498629718354-908b63db7fb1?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=667&q=80"
			const phoneNumber = KODE_NOMOR + response.customer.no_telp
			$('#chatWhatsapp').attr('href', Functions.prototype.shareToWhatsapp(phoneNumber, encodeURIComponent(message))).attr('target', '_blank')
			$('#sisa').text(Functions.prototype.formatRupiah(sisa.toString(), 'Rp. '))
			$('.btn-bayar').attr('href', urlPageKasbon + "/bayar/" + response.customer.nama + "/" + response.id)
			if(sisa > 0) {
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