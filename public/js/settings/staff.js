$(document).ready(function () {
    getAll.loadData = ""

    addStaff()
});

const getAll = {
    set loadData(data) {
        const url = URL_API + "/settings/staffs" + data
        Functions.prototype.getRequest(getAll, url)
    },
    set successData(response) {
        $('#listStaffs').empty()
        const { current_page, data, prev_page_url, next_page_url } = response
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
            paginations = Functions.prototype.createPaginate(current_page, prev_page_url, next_page_url)
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
            password: {
                required: true,
                minlength: 8
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
            
        }
    })
}