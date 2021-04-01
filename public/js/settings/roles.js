$(function () {
    processGetListRoles.loadData = ""

    var query_params = ""

    $('.paginate').on('click', '.pagination .page-item a', function(e) {
        e.preventDefault()
        const id = $(this).data('id');
        if(query_params == "") {
            query_params = "?page=" + id
        } else {
            query_params += "&page=" + id
        }
        processGetListRoles.loadData = query_params
    })  

    $('#filterData').on('submit', function(e) {
        e.preventDefault()
        query_params = "?" + $(this).serialize()
        processGetListRoles.loadData = query_params
    })

    $('#reset').on('click', function(e) {
        e.preventDefault()
        $('#search').val('')
        processGetListRoles.loadData = ""
    })

    $('#addRoleForm').on('submit', function(e) {
        e.preventDefault()
        const urlAddRole = URL_API + "/settings/add/role"
        Functions.prototype.postRequest(processAddRole, urlAddRole, $(this).serialize())
    })

    $('#listRoles').on('click', 'tr td div .update', function(e) {
        e.preventDefault()
        const id = $(this).data('id')
        const urlDetailRole = URL_API + "/settings/role/" + id
        Functions.prototype.getRequest(processDetailRole, urlDetailRole)
    })

    $('#listRoles').on('click', 'tr td div .delete', function(e) {
        e.preventDefault()
        const id = $(this).data('id')
        Swal.fire({
            title: 'Yakin ingin hapus?',
            text: "Penghapusan role akan menghapus data user juga!!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            showLoaderOnConfirm: true,
            confirmButtonText: 'Yakin',
            cancelButtonText: 'Tidak',
            preConfirm: () => {
                return fetch(URL_API + "/settings/delete/role/" + id, {
                    method: 'DELETE',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                }).then(response => {
                    if(!response.ok) {
                        throw new Error(response.statusText)
                    }
                    return response.json()
                }).catch(error => {
                    toastr.error(error, 'Error')
                })
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'berhasil!',
                    result.value.message,
                    'success'
                )
                processGetListRoles.loadData = ""
            }
        })
    })

    $('#updateRoleForm').on('submit', function(e) {
        e.preventDefault()
        const id = $('#idRole').val()
        const urlUpdateRole = URL_API + "/settings/update/role/" + id
        const data = {
            name: $('#update_name').val()
        }
        Functions.prototype.putRequest(processUpdateRole, urlUpdateRole, data)
    })
});


const processUpdateRole = {
    set successData(response) {
        toastr.success(response.message, 'Success')
        processGetListRoles.loadData = ""
        $('#updateRole').modal('hide')
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}

const processDetailRole = {
    set successData(response) {
        $('#update_name').val(response.name)
        $('#idRole').val(response.id)
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}


const processAddRole = {
    set successData(response) {
        toastr.success(response.message, 'Success')
        processGetListRoles.loadData = ""
        $('#name').val('')
        $('#addRoles').modal('hide')
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}


const processGetListRoles = {
    set loadData(query_params) {
        const getListRoleUrl = URL_API + "/settings/roles" + query_params
        Functions.prototype.getRequest(processGetListRoles, getListRoleUrl)
    },
    set successData(response) {
        const { data, currentPage, pagination } = response
        $('#listRoles').empty()
        if(data.length > 0) {
            data.map(result => {
                $('#listRoles').append(`
                    <tr>
                        <td>${result.name}</td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-info ${result.id == 1 ? "disabled" : ""} update" data-toggle="modal" data-target="#updateRole" data-id="${result.id}" ${result.id == 1 ? "disabled" : ""}>Edit</button>
                                <button class="btn btn-sm btn-danger ${result.id == 1 ? "disabled" : ""} delete" data-id="${result.id}" ${result.id == 1 ? "disabled" : ""}>Hapus</button>
                            </div>
                        </td>
                    </tr>
                `)
            })

        } else {
            $('#listRoles').append(`
                <tr>
                    <td colspan="6" align="center">Role tidak ditemukan</td>
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