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
}