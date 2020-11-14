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
            }, 100);
        }
    }
    readURLOnlyOne(inputs) {
        if(inputs.length > 0) {
            for (let i = 0; i < inputs.length; i++) {
                const element = inputs[i];
                const reader = new FileReader()
                reader.onload = function(e) {
                    $('.labelUpload').css('background-image', `url(${e.target.result})`)
                }
                reader.readAsDataURL(element);
            }
        }
    }
    
    formatRupiah(angka, prefix){
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
            "serverSide"    : true,
            "prosessing"    : true,
            "deferRender"   : true,
            "stateSave"     : true,
            "ajax"          : url,
            "columns"       : columns   
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
                process.errorData = err
            }
        });
    }
}