$(document).ready(function () {
    moment.locale('id');  
    var query_params = ""
    getListDataExport.loadData = query_params
    $('#exportDB').on('submit', function(e) {
        e.preventDefault();
        const data = {
            namefile: $('#namefile').val()
        }
        Functions.prototype.postRequest(requestExport, urlExport, data)
    })    
    $('#search_waktu_export').daterangepicker({
        locale: {
            format: 'Y-MM-DD'
        }
    })

    $('#filteringData').on('submit', function(e) {
        e.preventDefault()
        query_params = ""
        query_params += "?" + $(this).serialize()
        getListDataExport.loadData = query_params
    })

    $('#pagination').on('click', '.pagination .page-item a', function(e) {
        e.preventDefault()
        const id = $(this).data('id');
        if(query_params == "") {
            query_params = "?page=" + id
        } else {
            query_params += "&page=" + id
        }
        getListDataExport.loadData = query_params
    })
});

const requestExport = {
    set successData(response) {
        toastr.success(response.message, 'Success')
        getListDataExport.loadData = ""
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}

const getListDataExport = {
    set loadData(query_params) {
        const urlGetList = urlListExport + query_params
        Functions.prototype.getRequest(getListDataExport, urlGetList)
    },
    set successData(response) {
        $('#listExported').empty()
        $('#pagination').empty()
        const { data, currentPage, pagination } = response
        if(data.length > 0) {
            data.map(result => {
                $('#listExported').append(`
                    <tr>
                        <td>${result.whoExport}</td>
                        <td>${result.nama_file}</td>
                        <td>${moment(result.created_at).format('DD MMMM YYYY')}</td>
                        <td>
                            <a class="btn btn-sm btn-primary" href="${baseUrl}/${result.nama_file}">Download</a>
                        </td>
                    </tr>
                `)
            })
        } else {
            $('#listExported').append(`
                <tr>
                    <td colspan="5" align="center">Belum ada data yang terexport</td>
                </tr>
            `)
        }
        $('#pagination').html(pagination)
        $('#pagination').find('a').each(function() {
            if($(this).text() === '‹'){
                $(this).attr('data-id', currentPage - 1);
            }else if($(this).text() === '›'){
                $(this).attr('data-id', currentPage + 1);
            }else{
                $(this).attr('data-id', $(this).html());
            }
        })
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}
