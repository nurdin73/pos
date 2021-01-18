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
                $('.loading').hide()
                toastr.success(response.message, "success")
                setTimeout(() => {
                    window.location.reload()
                }, 500);
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

    prevImage(image, field) {
        const reader = new FileReader()
        reader.onload = function(e) {
            field.attr('src', e.target.result)
        }
        reader.readAsDataURL(image)
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
        try {
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
            return prefix == undefined ? rupiah : (rupiah ? prefix + rupiah + ",-" : '');
        } catch (err) {
            return prefix + angka
        }
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

    postRequest(process, url, data) {
        $.ajax({
            type: "post",
            url: url,
            data: data,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            beforeSend: function() {
                $('.loading').show()
            },
            success: function (response) {
                $('.loading').hide()
                process.successData = response;
            },
            error: function(err) {
                $('.loading').hide()
                process.errorData = err
            }
        });
    }
    putRequest(process, url, data) {
        $.ajax({
            type: "put",
            url: url,
            data: data,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            beforeSend: function() {
                $('.loading').show()
            },
            success: function (response) {
                $('.loading').hide()
                process.successData = response;
            },
            error: function(err) {
                $('.loading').hide()
                process.errorData = err
            }
        });
    }

    createPaginate(current_page, prev_page_url, next_page_url = "") {
        var paginations = ""
        if(prev_page_url == null) {
            paginations += `<li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
            </li>`
        } else {
            paginations += `<li class="page-item">
                <a class="page-link" data-id="${current_page - 1}" href="#">Previous</a>
            </li>`
        }
        if(next_page_url == null) {
            paginations += `<li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" data-id="${current_page}" aria-disabled="true">Next</a>
            </li>`
        } else {
            paginations += `<li class="page-item">
            <a class="page-link" data-id="${current_page + 1}" href="#">Next</a>
          </li>`
        }
        return paginations;
    }

    createChart( field, type = 'line', nameLabel = "", data = [], labels = [], options = {}) {
        var chart = new Chart(field, {
            // The type of chart we want to create
            type: type,
        
            // The data for our dataset
            data: {
                labels: labels,
                datasets: [{
                    label: nameLabel,
                    backgroundColor: '#321fdb',
                    borderColor: 'rgb(255, 99, 132)',
                    data: data,
                }]
            },
        
            // Configuration options go here
            options: options
        });
        return chart
    }
    createManyChart( field, type = 'line', dataset = [], labels = [], options = {}) {
        var chart = new Chart(field, {
            // The type of chart we want to create
            type: type,
        
            // The data for our dataset
            data: {
                labels: labels,
                datasets: dataset
            },
        
            // Configuration options go here
            options: options
        });
        return chart
    }

    createCountingData(from, to, total) {
        return `<span class="text-muted">Menampilan <span>${from}</span> sampai <span>${to}</span> dari <span>${total}</span> data</span>`
    }

    shareToWhatsapp(phone = "", text = "") {
        var url = "https://api.whatsapp.com/send?"
        url += "phone=" + phone
        url += "&text=" + text 
        return url
    }
    validateFile(input) {  
        var fileType = ['.jpg', '.jpeg', '.png']
        var val = $(input).val()
        if (val.length > 0) {
            var fileValid = false
            for (let i = 0; i < fileType.length; i++) {
                const element = fileType[i];
                if(val.substr(val.length - element.length, element.length).toLowerCase() == element.toLowerCase()) {
                    fileValid = true
                    // break
                }
            }
      
            if(!fileValid) {
                toastr.warning("Type file tidak valid", 'perhatian!')
                $('.custom-file-label').text("Choose file")
                $(input).val("")
                return false
            }
        }
        return true
    }
}