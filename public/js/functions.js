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
}