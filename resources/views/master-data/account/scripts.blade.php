<script>
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });

    $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('account.index') }}"
        },
        columns: [
            { data: 'nomor_akun' },
            { data: 'nama_akun' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [
            [0, 'asc']
        ],
    });

    $('#addButton').click(function(){
        $('.modal-title').text('Tambah Akun');
        $('#saveButton').val('Add');
        $('#action').val('Add');
        $('#addEditForm').trigger("reset");
        $('#addEditForm').validate().resetForm();
        $('#addEditModal').on('shown.bs.modal', function() {
            $('#nomor_akun').trigger('focus');
        });
    });

    $(document).on('click', '.edit', function(){
        var id = $(this).data('id');
        $.ajax({
            url :"account/"+ id +"/edit",
            dataType:"json",
            success: function(data)
            {
                $('.modal-title').text('Edit Akun');
                $('#saveButton').val('Update');
                $('#action').val('Edit');
                $('#id').val(data.id);
                $('#nomor_akun').val(data.nomor_akun);
                $('#nama_akun').val(data.nama_akun);
                $('#addEditModal').modal('show');
                $('#addEditForm').validate().resetForm();
                $('#addEditModal').on('shown.bs.modal', function() {
                    $('#nomor_akun').trigger('focus');
                });
            },
        });
    });

    $(document).on('click', '.delete', function () {
        var dataId = $(this).attr('id');
        swal({
            title: 'Apa Anda yakin?',
            text: "Data rincian akuntansi yang berkaitan juga akan terhapus permanen!",
            icon: 'warning',
            buttons:{
                confirm: {
                    text: 'Ya, saya yakin!',
                    className: 'btn btn-success'
                },
                cancel: {
                    text: 'Batal!',
                    visible: true,
                    className: 'btn btn-danger'
                }
            }
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "account/" + dataId,
                    type: 'DELETE',
                    success: function (data) {
                        setTimeout(function () {
                            var oTable = $('#table').DataTable();
                            oTable.draw(false);
                        });
                        swal({
                            title: "Berhasil!",
                            text: "Data berhasil dihapus!",
                            icon: "success",
                            buttons: {
                                confirm: {
                                    text: "Oke",
                                    value: true,
                                    visible: true,
                                    className: "btn btn-success",
                                    closeModal: true
                                }
                            },
                            timer: 1500,
                        });
                    },
                    error: function (data) {
                        swal({
                            title: "Data gagal dihapus!",
                            text: "Terjadi masalah pada server!",
                            icon: "error",
                            buttons: {
                                confirm: {
                                    text: "Oke",
                                    value: true,
                                    visible: true,
                                    className: "btn btn-danger",
                                    closeModal: true
                                }
                            },
                            timer: 1500,
                        });
                        console.log('Error:', data);
                    }
                });
            };
        });
    });

    if ($("#addEditForm").length > 0) {
        $.validator.addMethod( "lettersOnly", function( value, element ) {
        return this.optional( element ) || /^[a-zA-Z\s]+$/.test( value );
        }, "Please enter letters only." );

        $("#addEditForm").validate({
            rules: {
                nomor_akun: { maxlength: 4, },
                nama_akun: { lettersOnly: true, maxlength: 255, },
            },

            submitHandler: function (form) {
                if($('#action').val() == 'Add') {
                    action_url = "{{ route('account.store') }}";
                    swal_title = "Berhasil!";
                    swal_text = "Data berhasil ditambahkan!";
                    swal_fail_title = "Data gagal ditambahkan!";
                }

                if($('#action').val() == 'Edit') {
                    action_url = "{{ route('account.update') }}";
                    swal_title = "Berhasil!";
                    swal_text = "Data berhasil diperbarui!";
                    swal_fail_title = "Data gagal diperbarui!";
                }

                $('#saveButton').html('Processing..');
                $.ajax({
                    data: $('#addEditForm').serialize(),
                    url: action_url,
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#addEditForm').trigger("reset");
                        $('#addEditModal').modal('hide');
                        $('#saveButton').html('Submit');
                        var oTable = $('#table').DataTable();
                        oTable.draw(false);
                        swal({
                            title: swal_title,
                            text: swal_text,
                            icon: "success",
                            buttons: {
                                confirm: {
                                    text: "Oke",
                                    value: true,
                                    visible: true,
                                    className: "btn btn-success",
                                    closeModal: true
                                }
                            },
                            timer: 1500,
                        });
                    },
                    error: function (data) {
                        if(data.responseJSON.errors) {
                            var values = '';
                            jQuery.each(data.responseJSON.errors, function (key, value) {
                                values += "• " + value + "\n"
                            });

                            swal({
                                title: swal_fail_title,
                                text: values,
                                icon: "error",
                                buttons: {
                                    confirm: {
                                        text: "Oke",
                                        value: true,
                                        visible: true,
                                        className: "btn btn-danger",
                                        closeModal: true
                                    }
                                },
                            });
                        }

                        else {
                            swal({
                                title: swal_fail_title,
                                text: "Terjadi masalah pada server!",
                                icon: "error",
                                buttons: {
                                    confirm: {
                                        text: "Oke",
                                        value: true,
                                        visible: true,
                                        className: "btn btn-danger",
                                        closeModal: true
                                    }
                                },
                                timer: 1500,
                            });
                        }
                        console.log('Error:', data);
                        $('#saveButton').html('Submit');
                    }
                });
            }
        });
    };
});
</script>
