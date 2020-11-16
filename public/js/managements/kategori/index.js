$(document).ready(function () {
    getCategories()
    showDetail()
    addData()
    updateData()
    deleteCategory()
});

function getCategories() {  
    const urlListCategories = URL_API + "/managements/kategori"
    const columns = [
        {data : 'name', name: 'name'},
        {data : 'actions', name: 'actions', orderable: false, searchable: false},
    ]
    Functions.prototype.tableResult("#dataTables", urlListCategories, columns)
}

function showDetail() {  
    $('#dataTables').on('click', 'tbody tr td div .update', function(e) {
        e.preventDefault()
        const id = $(this).data('id')
        getDetail.loadData = id
    })
    const getDetail = {
        set loadData(data) {
            const urlDetail = URL_API + "/managements/kategori/" + data
            Functions.prototype.requestDetail(getDetail, urlDetail)
        },
        set successData(response) {
            $('#update_name').val(response.name);
            $('#id_kategori').val(response.id)
        },
        set errorData(err) {
            toastr.error(err.responseJSON.message, 'error!!')
        }
    }
}

function addData() {  
    $('#formAddKategori').validate({
        rules: {
            name: {
                required: true
            }
        },
        errorClass: "is-invalid",
        validClass: "is-valid",
        errorElement: "small",
        submitHandler: function(form, e) {
            e.preventDefault()
            const urlPost = URL_API + "/managements/add/kategori"
            const data = {
                name : $('#name').val()
            }
            Functions.prototype.httpRequest(urlPost, data, 'post')
            getCategories()
        }
    })
}
function updateData() {  
    $('#formUpdateCategory').validate({
        rules: {
            update_name: {
                required: true
            }
        },
        errorClass: "is-invalid",
        validClass: "is-valid",
        errorElement: "small",
        submitHandler: function(form, e) {
            e.preventDefault()
            const id = $('#id_kategori').val()
            const urlUpdate = URL_API + "/managements/update/kategori/" + id 
            const data = {
                name : $('#update_name').val()
            }
            Functions.prototype.httpRequest(urlUpdate, data, 'put')
            getCategories()
        }
    })
}

function deleteCategory() {
    $('#dataTables').on('click', 'tbody tr td div .delete', function(e) {
        e.preventDefault()
        const id = $(this).data('id');
        const urlDelete = URL_API + "/managements/delete/kategori/" + id
        Swal.fire({
            title: 'Yakin ingin menghapus kategori ini?',
            text: "produk akan ikut terhapus jika kategori produk dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                Functions.prototype.deleteData(urlDelete);
                getCategories()
            }
        })
    })
}