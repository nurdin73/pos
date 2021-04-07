$(function () {
    var query_params = ""
    processGetLoyality.loadData = ""
    $('.paginate').on('click', '.pagination .page-item a', function(e) {
        e.preventDefault()
        const id = $(this).data('id');
        if(query_params == "") {
            query_params = "?page=" + id
        } else {
            query_params += "&page=" + id
        }
        processGetLoyality.loadData = query_params
    })
    
    $('#generate').on('click', function(e) {
        e.preventDefault()
        $('#codePoint').val(Functions.prototype.generateCode(8))
    })


    $('#category').select2({
        theme:'bootstrap4',
        ajax: {
            url: URL_API + "/managements/categories",
            data: function (params) {
                return {
                    name: params.term,
                }
            },
            processResults: function(data, params) {
            return {
                results: data.map(result => {
                    return {
                        text: result.name,
                        id: result.id
                    }
                })
            }
            },
        }
    })


    addLoyality()
});

const processGetLoyality = {
    set loadData(query) {
        const urlGetLoyalities = URL_API + "/managements/loyality-program" + query
        Functions.prototype.getRequest(processGetLoyality, urlGetLoyalities)
    },
    set successData(response) {
        const { data, pagination, currentPage } = response
        $('#listLoyality').empty()
        if(data.length > 0) {
            data.map(result => {
                const image = result.image != null ? URL_IMAGE + "/" + result.image : URL_NO_IMAGE
                const title = result.name.length > 20 ? result.name.substr(0, 20) + "..." : result.name
                $('#listLoyality').append(`
                <div class="col-md-3">
                    <div class="card thumbnail-point position-relative" style="overflow: hidden; background-image: url('${image}')">
                        <button class="btn btn-sm btn-danger btn-del-loyal" data-id="${result.id}">
                            <i class="fas fa-times"></i>
                        </button>
                        <div class="bg-dark p-2 captions d-flex justify-content-between align-items-center">
                            <a href="#" class="text-white card-link font-weight-bold stretched-link" data-toggle="modal" data-target="#descriptionVoucher" data-id="${data.id}">${title}</a>
                            <small>${result.point} Point</small>
                        </div>
                    </div>
                </div>
                `)
            })
        } else {
            $('#listLoyality').html(`
                <div class="col-md-12">
                    <div class="alert alert-warning">
                        Loyality tidak ditemukan
                    </div>
                </div>
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

function addLoyality() {
    $('#addLoyalityForm').validate({
        rules: {
            name: {
                required: true,
            },
            stock: {
                required: true,
            },
            point: {
                required: true,
            },
            codePoint: {
                required: true,
            },
            category: {
                required: true,
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
            const data = new FormData()
            const files = $('.custom-file-input')[0].files
            data.append('name', $('#name').val())
            data.append('stock', $('#stock').val())
            data.append('point', $('#point').val())
            data.append('codePoint', $('#codePoint').val())
            data.append('category_id', $('#category').val())
            if(files.length > 0) {
                data.append('image', files[0])
            }
            const urlAddRoyality = URL_API + "/managements/add/loyality-program"
            Functions.prototype.addRequest(processAddLoyality, urlAddRoyality, data)
        }
    })
}

const processAddLoyality = {
    set successData(response) {
        toastr.success(response.message, 'Success')
        processGetLoyality.loadData = ""
    },
    set errorData(err) {
        toastr.error(err.responseJSON.message, 'error')
    }
}

$('.custom-file-input').on('change', function(e) {
    if(Functions.prototype.validateFile($(this))) {
        const files = $('.custom-file-input')[0].files
        const nextSibling = e.target.nextElementSibling
        if(files.length > 1) {
        nextSibling.innerHTML = `${files.length} photo dipilih`
        } else {
        nextSibling.innerHTML = files[0].name
        }
        const reader = new FileReader()
        reader.onload = function(e) {
            $('#preview').attr('src', e.target.result)
        }
        reader.readAsDataURL(files[0]);
        // Functions.prototype.readURL(files)
    }
})