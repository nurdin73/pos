$(document).ready(function () {
    updateLogo()
});

function updateLogo() {
    $('#logo').on('change', function (e) {
        e.preventDefault()
        const file = $(this)[0].files
        console.log(file);
        $('.logo').text(file.name)
    })
}