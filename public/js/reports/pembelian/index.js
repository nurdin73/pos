$(document)/ready(function() {
	
})

const getDataPembelian = {
	set loadData(data) {
		
	},
	set successData(response) {
		console.log(response)
	},
	set errorData(err) {
		toastr.error(err.responseJSON.message, 'Error')
	}
}