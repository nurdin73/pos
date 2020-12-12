$(document).ready(function () {
    getAll.loadData = ""
});

const getAll = {
    set loadData(data) {
        const url = URL_API + "/settings/staffs" + data
        Functions.prototype.getRequest(getAll, url)
    },
    set successData(response) {
        $('#listStaffs').empty()
        const { current_page, last_page, data, prev_page_url } = response
        if(data.length > 0) {
            data.map(result => {
                $('#listStaffs').append(`
                    <tr>
                        <td>${result.nama_staff}</td>
                        <td>${result.no_telp}</td>
                        <td><span class="badge badge-primary">${result.jabatan}</span></td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-info"><i class="fas fa-book"></i></button>
                                <button class="btn btn-sm btn-info"><i class="fas fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                `)
            })
            var paginations = ""
            paginations = Functions.prototype.createPaginate(current_page, last_page, prev_page_url)
            $('.pagination').html(paginations)
            paginations = ""
        } else {
            $('#listStaffs').append(`
                <tr>
                    <td align="center" colspan="4">Staff masih kosong</td>
                </tr>
            `)
        }
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}