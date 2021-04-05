$(function () {
    var query_params = "",
        query_params2 = ""
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

    $('#listRoleAccess').on('click', 'tr td .checkAkses', function(e) {
        e.preventDefault()
        const roleId = $(this).data('id')
        $('#roleName').text($(this).data('role'))
        const urlListRole = URL_API + "/settings/sub-menus/" + roleId
        Functions.prototype.getRequest(processGetMenuAccess, urlListRole)
    })
    granted()
});

const processGetMenuAccess = {
    set successData(response) {
        $('#listMenu').empty()
        if(response.length > 0) {
            response.map((result, i) => {
                const checked = result.role_acceses[0].isGranted == 1 ? "checked" : "";
                const roleAdmin = result.role_acceses[0].role_id == 1 ? "disabled" : ""
                $('#listMenu').append(`
                    <tr>
                        <td>${result.name}</td>
                        <td class="text-center">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input granted" data-id="${result.role_acceses[0].id}" name="isGranted${result.role_acceses[0].id}" id="isGranted${result.role_acceses[0].id}" ${checked} ${roleAdmin}>
                                <label class="custom-control-label" for="isGranted${result.role_acceses[0].id}">Ya</label>
                            </div>
                        </td>
                    </tr>
                `)
            })
        } else {
            $('#listMenu').append(`
                <tr>
                    <td colspan="2" align="center">Akses belum ada</td>
                </tr>
            `)
        }
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}

const processGetlistRoleAccess = {
    set loadData(query_params) {
        const urlGetListRoleAccess = URL_API + "/settings/roles" + query_params
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
                        <td>${result.name}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-primary checkAkses" data-id="${result.id}" data-role="${result.name}" data-target="#checkAksesModal" data-toggle="modal">Check akses</button>
                        </td>
                    </tr>
                `)
            })
        } else {
            $('#listRoleAccess').append(`
                <tr>
                    <td colspan="2" align="center">Role akses tidak ditemukan</td>
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

function granted() {
    $('#listMenu').on('change', 'tr td div .granted', function(e) {
        e.preventDefault()
        const id = $(this).data('id')
        const checked = $(`input[name=isGranted${id}]:checked`).length
        const urlUpdateIsGranted = URL_API + "/settings/update/role-access/" + id
        Functions.prototype.putRequest(processIsGranted, urlUpdateIsGranted, {
            granted: checked
        })
    })
}


const processIsGranted = {
    set successData(response) {
        console.log(response);
    },
    set errorData(err) {
        console.log(err);
    }
}