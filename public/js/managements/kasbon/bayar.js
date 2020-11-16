$(document).ready(function() {
	getDetail.loadData = id
})

const getDetail = {
	set loadData(data) {
		const urlDetail = URL_API + "/managements/kasbon-pelanggan/" + data
		Functions.prototype.requestDetail(getDetail, urlDetail)
	},
	set successData(response) {
		var totalkasbon = 0
		$('#nama_pelanggan').text(response.nama)
		$('#email_pelanggan').text(response.email)
		$('#telp_pelanggan').text(response.no_telp)
		$('#alamat_pelanggan').text(response.alamat)
		if(response.cash_receipts.length > 0) {
			response.cash_receipts.map(result => {
				totalkasbon += result.jumlah
				$('#listData').append(`
					<tr>
						<td>${Functions.prototype.formatRupiah(result.jumlah.toString(), 'Rp. ')}</td>
						<td>${moment(result.tgl_kasbon).format('D MMMM YYYY')}</td>
						<td>${moment(result.jatuh_tempo).format('D MMMM YYYY')}</td>
						<td>${result.status == "belum lunas" ? `<span class="badge badge-danger">${result.status}</span>` : `<span class="badge badge-success">${result.status}</span>`}</td>
                        <td align="center">
                            ${result.status == "belum lunas" ? 
                                `<button class="btn btn-sm btn-success bayar" data-id="${result.id}">Bayar</button>` :
                                `<span class="btn btn-sm btn-success">Lunas</span>`
                            }
                        </td>
					</tr>
				`)
			})
		}
		$('#totalKasbon').text(Functions.prototype.formatRupiah(totalkasbon.toString(), 'Rp. '))
		$('#total_transaksi').text(response.cash_receipts.length)
	},
	set errorData(err) {
		console.log(err)
	} 
}