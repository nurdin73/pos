$(document).ready(function() {
	var query_params = ""
	getDataPembelian.loadData = ""
	$('.paginate').on('click', '.pagination .page-item a', function(e) {
		e.preventDefault()
		const id = $(this).data('id');
		if(query_params == "") {
		  	query_params = "?page=" + id
		} else {
		  	query_params += "&page=" + id
		}
		getDataPembelian.loadData = query_params
	})  
	$('#filterExport').on('submit', function(e) {
		e.preventDefault()
		query_params = ""
		query_params += "?" + $(this).serialize()
		getDataPembelian.loadData =  query_params
	})
	$('.btn-reset').on('click', function(e) {
		e.preventDefault()
		$('#filterExport')[0].reset()
		getDataPembelian.loadData = ""
	})
})

const getDataPembelian = {
	set loadData(data) {
		const url = URL_API + "/reports/pembelian-barang" + data
		Functions.prototype.getRequest(getDataPembelian, url)
	},
	set successData(response) {
		$('#listProducts').empty()
		const { data, currentPage, pagination } = response
		if(data.length > 0) {
			data.map(result => {
				var stocks = 0
				var harga_dasar = 0
				var tgl_input = ""
                result.stocks.map(dataStok => {
                    stocks += dataStok.stok
					harga_dasar = dataStok.harga_dasar
					tgl_input = dataStok.updated_at
                })
				$('#listProducts').append(`
					<tr>
						<td>${result.nama_barang}</td>
						<td>${moment(tgl_input).format('D MMM YYYY')}</td>
						<td>${stocks + result.selled}</td>
						<td>${Functions.prototype.formatRupiah(harga_dasar.toString(), 'Rp. ')}</td>
					</tr>
				`)
			})
			var paginations = ""
            paginations = pagination
			$('.paginate').html(paginations)
			$('.paginate').find('a').each(function() {
                if($(this).text() === '‹'){
                    $(this).attr('data-id', currentPage - 1);
                }else if($(this).text() === '›'){
                    $(this).attr('data-id', currentPage + 1);
                }else{
                    $(this).attr('data-id', $(this).html());
                }
            })
            paginations = ""
		} else {
			$('#listProducts').append(`
				<tr>
					<td colspan="5" align="center">Barang Kosong</td>
				</tr>
			`)
		}
	},
	set errorData(err) {
		toastr.error(err.responseJSON.message, 'Error')
	}
}