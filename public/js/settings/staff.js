$(document).ready(function () {
    getAll.loadData = ""
    var query_params = ""

    $('.paginate').on('click', '.pagination .page-item a', function(e) {
        e.preventDefault()
        const id = $(this).data('id');
        if(query_params == "") {
            query_params = "?page=" + id
        } else {
            query_params += "&page=" + id
        }
        getAll.loadData = query_params
    })  

    $('#filterData').on('submit', function(e) {
        e.preventDefault()
        query_params = "?" + $(this).serialize()
        getAll.loadData = query_params
    })

    $('#reset').on('click', function(e) {
        e.preventDefault()
        $('#search').val('')
        getAll.loadData = ""
    })

    addStaff()

    $('#jabatan').select2({
        theme:'bootstrap4',
        ajax: {
            url: URL_API + "/settings/roles",
            data: function (params) {
                return {
                    search: params.term,
                }
            },
            processResults: function(response, params) {
                return {
                    results: response.data.map(result => {
                        return {
                            text: result.name,
                            id: result.id
                        }
                    })
                }
            },
        }
    })

    $('#update_jabatan').select2({
        theme:'bootstrap4',
        ajax: {
            url: URL_API + "/settings/roles",
            data: function (params) {
                return {
                    search: params.term,
                }
            },
            processResults: function(response, params) {
                return {
                    results: response.data.map(result => {
                        return {
                            text: result.name,
                            id: result.id
                        }
                    })
                }
            },
        }
    })

    updateStaff()
    deleteStaff()
    putUpdateStaff()
});

const getAll = {
    set loadData(data) {
        const url = URL_API + "/settings/staffs" + data
        Functions.prototype.getRequest(getAll, url)
    },
    set successData(response) {
        $('#listStaffs').empty()
        const { data, currentPage, pagination } = response
        if(data.length > 0) {
            data.map(result => {
                $('#listStaffs').append(`
                    <tr>
                        <td>${result.nama_staff}</td>
                        <td>${result.email}</td>
                        <td>${result.no_telp}</td>
                        <td><span class="badge badge-primary">${result.role.name}</span></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-info update" data-toggle="modal" data-target="#updateStaff" data-id="${result.id}"><i class="fas fa-book"></i></button>
                                <button class="btn btn-sm btn-danger delete" data-id="${result.id}"><i class="fas fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                `)
            })
        } else {
            $('#listStaffs').append(`
                <tr>
                    <td align="center" colspan="5">Staff tidak ditemukan</td>
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

function addStaff() {  
    $('#no_telp_staff').mask('0000-0000-0000')
    $('#addStaffForm').validate({
        rules: {
            email_staff: {
                required: true,
                email: true
            },
            nama_staff: {
                required: true
            },
            no_telp_staff: {
                required: true
            },
            jabatan: {
                required: true
            },
        },
        errorClass: "is-invalid",
        validClass: "is-valid",
        errorElement: "small",
        errorPlacement: function errorPlacement(error, element) {
            error.addClass('invalid-feedback');
        
            if (element.prop('type') === 'checkbox') {
                error.insertAfter(element.parent('label'));
            } else {
                error.insertAfter(element);
            }
        },
        // eslint-disable-next-line object-shorthand
        highlight: function highlight(element) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        // eslint-disable-next-line object-shorthand
        unhighlight: function unhighlight(element) {
            $(element).addClass('is-valid').removeClass('is-invalid');
        },
        submitHandler: function(form, e) {
            e.preventDefault()
            const urlAddStaff = URL_API + "/settings/add/staff"
            const dataStaff = {
                nama_staff: $('#nama_staff').val(),
                email: $('#email_staff').val(),
                no_telp: $('#no_telp_staff').val(),
                role_id: $('#jabatan').val(),
                alamat: $('#alamat').val()
            }
            Functions.prototype.postRequest(processAddStaff, urlAddStaff, dataStaff)
        }
    })
}

const processAddStaff = {
    set successData(response) {
        toastr.success(response.message, 'Success')
        setTimeout(() => {
            window.location.reload()
        }, 2000);
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}

function updateStaff() {
    $('#listStaffs').on('click', 'tr td div .update', function(e) {
        e.preventDefault()
        const id = $(this).data('id')
        const urlGetStaff = URL_API + "/settings/staff/" + id
        Functions.prototype.getRequest(processGetStaff, urlGetStaff)
    })
}


const processGetStaff = {
    set successData(response) {
        $('#idStaff').val(response.id)
        $('#update_email_staff').val(response.email)
        $('#update_nama_staff').val(response.nama_staff)
        $('#update_no_telp_staff').val(response.no_telp)
        $('#update_alamat').val(response.alamat)
        var option2 = response.role != null ? new Option(response.role.name, response.role.id, true, true) : new Option("", "", true, true)
        $("#update_jabatan").append(option2).trigger('change')
        $("#update_jabatan").trigger({
            type: 'select2:select',
            params: {
                data : response.role != null ? response.role.name : ""
            }
        })
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}


function putUpdateStaff() {
    $('#update_no_telp_staff').mask('0000-0000-0000')
    $('#updateStaffForm').validate({
        rules: {
            update_email_staff: {
                required: true,
                email: true
            },
            update_nama_staff: {
                required: true
            },
            update_no_telp_staff: {
                required: true
            },
            update_jabatan: {
                required: true
            },
        },
        errorClass: "is-invalid",
        validClass: "is-valid",
        errorElement: "small",
        errorPlacement: function errorPlacement(error, element) {
            error.addClass('invalid-feedback');
        
            if (element.prop('type') === 'checkbox') {
                error.insertAfter(element.parent('label'));
            } else {
                error.insertAfter(element);
            }
        },
        // eslint-disable-next-line object-shorthand
        highlight: function highlight(element) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        // eslint-disable-next-line object-shorthand
        unhighlight: function unhighlight(element) {
            $(element).addClass('is-valid').removeClass('is-invalid');
        },
        submitHandler: function(form, e) {
            e.preventDefault()
            const urlPutStaff = URL_API + "/settings/update/staff/" + $('#idStaff').val()
            const dataStaff = {
                nama_staff: $('#update_nama_staff').val(),
                email: $('#update_email_staff').val(),
                no_telp: $('#update_no_telp_staff').val(),
                role_id: $('#update_jabatan').val(),
                alamat: $('#update_alamat').val()
            }
            Functions.prototype.putRequest(processUpdateStaff, urlPutStaff, dataStaff)
        }
    })
}

const processUpdateStaff = {
    set successData(response) {
        toastr.success(response.message, 'Success')
        setTimeout(() => {
            window.location.reload()
        }, 2000);
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}


function deleteStaff() {
    $('#listStaffs').on('click', 'tr td div .delete', function(e) {
        e.preventDefault()
        const id = $(this).data('id')
        Swal.fire({
            title: 'Yakin?',
            text: 'staff akan terhapus permanen',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then(result => {
            if(result.isConfirmed) {
                const urlDeleteStaff = URL_API + "/settings/delete/staff/" + id
                Functions.prototype.deleteingData(processDeleteStaff, urlDeleteStaff)
            }
        })
    })
}

const processDeleteStaff = {
    set successData(response) {
        toastr.success(response.message, 'Success')
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'Error')
    }
}