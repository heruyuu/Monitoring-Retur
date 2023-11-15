<script>
    $(document).ready(function(){
        $('#Dtable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{ asset('toko') }}",
                "type": "GET",
            },
            columns: [
                { data: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'kd_toko' },
                { data: 'nm_toko' },
                { data: 'alamat' },
                { data: 'act', sClass: 'text-center', orderable: false, searchable: false }
            ],
            order: []
        });
    });

    // Create Data
    $('#Addform').on('submit', function(e) {
        e.preventDefault();
        idata = new FormData($('#Addform')[0]);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ asset('toko/store') }}",
            data: idata,
            processData: false,
            contentType: false,
            cahce: false,
            beforeSend: function() {
                in_load();
            },
            success: function(data) {
                Swal.fire(''+data.status+'',''+data.messages+'','success').then((value) => {
                    window.location.href = "{{ asset('toko') }}";
                });
                out_load();
            },
            error: function(error) {
                error_detail(error);
                out_load();
            }
        });
    });

    // Edit Data
    function edit_data(id) {
        let token = $('#input[name="_token"]').val();
        $('#swal-update-button').attr('data-id',id);
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{ asset('toko/edit') }}/"+id,
            data: {
                id: id,
                _token: token
            },
            beforeSend: function() {
                in_load();
            },
            success: function(data) {
                $('#kd_toko_edit').val(data.data.kd_toko);
                $('#nm_toko_edit').val(data.data.nm_toko);
                $('#alamat_edit').val(data.data.alamat);
                $('#username_edit').val(data.data.username);
                $('#password_edit').val(data.data.password);
            },
            error: function(error) {
                error_detail(error);
                out_load();
            }
        });
    }

    // Update Data
    $('#swal-update-button').click(function(e) {
        e.preventDefault();
        let id = $('#swal-update-button').attr('data-id');
        let token = $('input[name="_token"]').val();
        $.ajax({
            type: "PUT",
            dataType: "json",
            url: "{{ asset('toko/update') }}/"+id,
            data: {
                _token: token,
                kd_toko: $('#kd_toko_edit').val(),
                nm_toko: $('#nm_toko_edit').val(),
                alamat: $('#alamat_edit').val(),
                username: $('#username_edit').val(),
                password: $('#password_edit').val()
            },
            cahce: false,
            beforeSend: function() {
                in_load();
            },
            success: function(data) {
                Swal.fire(''+data.status+'',''+data.messages+'','success').then((value) => {
                    window.location.href = "{{ asset('toko') }}";
                });
                out_load();
            },
            error: function(error) {
                error_detail(error);
                out_load();
            }
        });
    });

    // Delete Data
    function delete_data(id) {
        Swal.fire({
            title: 'Konfirmasi Hapus !',
            text: 'Apakah anda yakin ingin menghapus Data ?',
            icon: 'warning',
            showCancelButton: true,
            showCloseButton: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((deleteFile) => {
            if(deleteFile.isConfirmed) {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ asset('toko/destroy') }}/"+id,
                    data: "_method=DELETE&_token="+tokenCSRF,
                    beforeSend: function() {
                        in_load();
                    },
                    success: function(data) {
                        Swal.fire(''+data.status+'',''+data.messages+'','success').then((value) => {
                            window.location.href = "{{ asset('toko') }}";
                        });
                        out_load();
                    },
                    error: function(error) {
                        error_detail(error);
                        out_load();
                    }
                });
            } else {
                Swal.fire('Cancelled', 'The item was NOT deleted!', 'error');
                out_load();
            }
        });
    }
</script>
