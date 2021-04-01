$(function () {
    var query_params = ""
    processGetlistRoleAccess.loadData = ""

    $('.paginate').on('click', '.pagination .page-item a', function(e) {
        e.preventDefault()
        const id = $(this).data('id');
        if(query_params == "") {
            query_params = "?page=" + id
        } else {
            query_params += "&page=" + id
        }
        processGetlistRoleAccess.loadData = query_params
    })  

    $('#filterData').on('submit', function(e) {
        e.preventDefault()
        query_params = "?" + $(this).serialize()
        processGetlistRoleAccess.loadData = query_params
    })

    $('#reset').on('click', function(e) {
        e.preventDefault()
        $('#search').val('')
        processGetlistRoleAccess.loadData = ""
    })
});

const processGetlistRoleAccess = {
    set loadData(query_params) {
        const urlGetListRoleAccess = URL_API + "/settings/role-access" + query_params
        Functions.prototype.getRequest(processGetlistRoleAccess, urlGetListRoleAccess)
    },
    set successData(response) {
        const { data, currentPage, pagination } = response
        $('#listRoleAccess').empty()
        if(data.length > 0) {
            data.map((result, i) => {
                const isAdmin = result.role_id == 1 ? "disabled" : ""
                const read = result.read == 1 ? "checked" : ""
                const create = result.create == 1 ? "checked" : ""
                const update = result.update == 1 ? "checked" : ""
                const del = result.delete == 1 ? "checked" : ""
                $('#listRoleAccess').append(`
                    <tr>
                        <td>${result.role.name}</td>
                        <td class="text-center"><input type="checkbox" name="create[]" ${create} ${isAdmin}></td>
                        <td class="text-center"><input type="checkbox" name="read[]" ${read} ${isAdmin}></td>
                        <td class="text-center"><input type="checkbox" name="update[]" ${update} ${isAdmin}></td>
                        <td class="text-center"><input type="checkbox" name="delete[]" ${del} ${isAdmin}></td>
                    </tr>
                `)
            })
        } else {
            $('#listRoleAccess').append(`
                <tr>
                    <td colspan="5" align="center">Role akses tidak ditemukan</td>
                </tr>
            `)
        }
        $('.paginate').html(pagination)
        $('.paginate').find('a').each(function() {
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