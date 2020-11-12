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
            url: "{{ route('account-detail.index') }}"
        },
        columns: [
            { data: 'nomor_akun', orderable: false },
            { data: 'nama_akun', orderable: false },
            { data: 'nomor_rincian_akun' },
            { data: 'nama_rincian_akun' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [
            [2, 'asc']
        ],
    });

    $('#addButton').click(function(){
        $('.modal-title').text('Tambah Rincian Akun');
        $('#saveButton').val('Add');
        $('#action').val('Add');
        $('#input_no_rincian').prop('disabled', true);
        $('#input_no_rincian').prop('hidden', true);
        $('#input_akun').prop('disabled', false);
        $('#input_akun').prop('hidden', false);
        $('#addEditForm').trigger("reset");
        $('#addEditForm').validate().resetForm();
        $('#addEditModal').on('shown.bs.modal', function() {
            $('#akun_id').trigger('focus');
        });
    });

    $(document).on('click', '.edit', function(){
        var id = $(this).data('id');
        $.ajax({
            url :"account-detail/"+ id +"/edit",
            dataType:"json",
            success: function(data)
            {
                $('.modal-title').text('Edit Rincian Akun');
                $('#saveButton').val('Update');
                $('#action').val('Edit');
                $('#id').val(data.id);
                $('#akun_id').val(data.account_id);
                $('#nomor_rincian_akun').val(data.nomor_rincian_akun);
                $('#nama_rincian_akun').val(data.nama_rincian_akun);
                $('#input_no_rincian').prop('disabled', false);
                $('#input_no_rincian').prop('hidden', false);
                $('#input_akun').prop('disabled', true);
                $('#input_akun').prop('hidden', true);
                $('#addEditModal').modal('show');
                $('#addEditForm').validate().resetForm();
                $('#addEditModal').on('shown.bs.modal', function() {
                    $('#nomor_rincian_akun').trigger('focus');
                });
            },
        });
    });

    $(document).on('click', '.delete', function () {
        var dataId = $(this).attr('id');
        swal({
            title: 'Apa Anda yakin?',
            text: "Data akan terhapus permanen!",
            icon: 'warning',
            buttons:{
                confirm: {
                    text : 'Ya, saya yakin!',
                    className : 'btn btn-success'
                },
                cancel: {
                    visible: true,
                    className: 'btn btn-danger'
                }
            }
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "account-detail/" + dataId,
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
                nomor_rincian_akun: { maxlength: 4, },
                nama_rincian_akun: { lettersOnly: true, maxlength: 255, },
            },

            submitHandler: function (form) {
                if($('#action').val() == 'Add') {
                    action_url = "{{ route('account-detail.store') }}";
                    swal_title = "Berhasil!";
                    swal_text = "Data berhasil ditambahkan!";
                    swal_fail_title = "Data gagal ditambahkan!";
                }

                if($('#action').val() == 'Edit') {
                    action_url = "{{ route('account-detail.update') }}";
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
