class Functions
{
    
    httpRequest(url = null, data = null, method = null) {
        $.ajax({
            type: method,
            url: url,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: data,
            beforeSend: function() {
                $('.loading').show()
            },
            success: function (response) {
                $('.loading').hide()
                toastr.success(response.message, "success")
            },
            error: function(err) {
                $('.loading').hide()
                toastr.error(err.responseJSON.message, "error")
            }
        });
    }
    uploadFile(url = null, data = null, method = null) {
        $.ajax({
            type: method,
            url: url,
            processData: false,
            contentType: false,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: data,
            beforeSend: function() {
                $('.loading').show()
            },
            success: function (response) {
                console.log(response);
                $('.loading').hide()
                toastr.success(response.message, "success")
                setTimeout(() => {
                    window.location.reload()
                }, 3000);
            },
            error: function(err) {
                $('.loading').hide()
                toastr.error(err.responseJSON.message, "error")
            }
        });
    }

    readURL(inputs = []) {
        if(inputs.length > 0) {
            for (let i = 0; i < inputs.length; i++) {
                const element = inputs[i];
                let filename = element.name.split('.')[0]
                const reader = new FileReader()
                reader.onload = function(e) {
                    $('.pgwSlider').append(`
                        <li><img src="${e.target.result}" alt="${filename}" data-large-src="${e.target.result}"></li>
                    `)
                }
                reader.readAsDataURL(element);
            }
            setTimeout(() => {
                $('.pgwSlider').pgwSlider({
                    displayControls: true,
                });
            }, 500);
        }
    }
    uploadImage(inputs, url, id) {
        const data = new FormData()
        data.append('file', inputs)
        data.append('id', id)
        $.ajax({
            url: url,
            method: 'post',
            processData: false,
            contentType: false,
            data: data,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            beforeSend: function() {
                $('.progress').show()
            },
            xhr: function() {
                const xhr = new window.XMLHttpRequest()

                xhr.upload.addEventListener("progress", function(e) {
                    if(e.lengthComputable) {
                        var percentComplete = e.loaded / e.total
                        percentComplete = Math.round(percentComplete * 100)
                        $('.progress-bar').attr('aria-valuenow', percentComplete).css('width', percentComplete + '%').text(percentComplete + '%');
                    }
                }, false)
                return xhr
            },
            success: function(response) {
                $('.progress').hide()
                toastr.success(response.message, "success")
                $('#uploadFile').parent().before(`
                    <div class="col-md-3 col-sm-4 col-6 mb-2">
                        <img src="${URL_IMAGE + "/" + response.create.image}" alt="${URL_IMAGE + "/" + response.create.image}" class="img-responsive img-fluid img-thumbnail">
                        <button class="btn btn-sm btn-danger delImage" data-image-id="${response.create.id}">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `)
            },
            error: function(err) {
                $('.progress').hide()
                toastr.error(err.responseJSON.message, "error")
            }
        })
    }

    deleteData(url) {
        $.ajax({
            method: "DELETE",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: url,
            beforeSend: function() {
                $('.loading').show()
            },
            success: function(response) {
                $('.loading').hide()
                toastr.success(response.message, "success")
            },
            error: function(err) {
                $('.loading').hide()
                toastr.error(err.responseJSON.message, "error")
            }
        })
    }
    
    formatRupiah(angka, prefix){
        var separator = ""
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split   		= number_string.split(','),
            sisa     		= split[0].length % 3,
            rupiah     		= split[0].substr(0, sisa),
            ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
    
        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
    
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    tableResult(field = "#dataTables", url = "", columns = []) {
        $(field).DataTable({
            "destroy"       : true,
            "serverSide"    : true,
            "prosessing"    : true,
            "deferRender"   : true,
            "stateSave"     : true,
            "ajax"          : url,
            "columns"       : columns,
        })
    }

    requestDetail(process, url, data = null) {
        $.ajax({
            type: "get",
            url: url,
            data: data,
            beforeSend: function() {
                $('.loading').show()
            },  
            success: function (response) {
                $('.loading').hide()
                process.successData = response
            },
            error: function(err) {
                $('.loading').hide()
                process.errorData = err
            }
        });
    }

    updateData(url, data, method) {
        $.ajax({
            url: url,
            method: method,
            data: data,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            beforeSend: function() {
                $('.loading').show()
            },
            success: function(response) {
                $('.loading').hide()
                toastr.success(response.message, 'Success!')
            },
            error: function(err) {
                $('.loading').hide()
                toastr.error(err.responseJSON.message)
            }
        })
    }

    getRequest(process, url) {
        $.ajax({
            type: "get",
            url: url,
            beforeSend: function() {
                $('.loading').show()
            },
            success: function (response) {
                $('.loading').hide()
                process.successData = response
            },
            error: function(err) {
                $('.loading').hide()
                process.errorData = err
            }
        });
    }
}