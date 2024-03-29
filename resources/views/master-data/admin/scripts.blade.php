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
            url: "{{ route('user.index') }}"
        },
        columns: [
            { data: 'name' },
            { data: 'username' },
            { data: 'email' },
            { data: 'role.jabatan', name: 'role.jabatan', orderable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [
            [0, 'asc']
        ],
    });

    $('#addButton').click(function(){
        $('.modal-title').text('Tambah Admin');
        $('#saveButton').val('Add');
        $('#action').val('Add');
        $('#dataFields').prop('disabled', false);
        $('#dataFields').prop('hidden', false);
        $('#passwordFields').prop('disabled', false);
        $('#passwordFields').prop('hidden', false);
        $('#addEditForm').trigger("reset");
        $('#addEditForm').validate().resetForm();
        $('#addEditModal').on('shown.bs.modal', function() {
            $('#name').trigger('focus');
        });
    });

    $(document).on('click', '.change-pass', function(){
        var id = $(this).data('id');
        $.ajax({
            url :"user/"+ id +"/edit",
            dataType:"json",
            success: function(data)
            {
                $('.modal-title').text('Change Password');
                $('#saveButton').val('ChangePass');
                $('#action').val('ChangePass');
                $('#id').val(data.id);
                $('#label-password').text('New Password');
                $('#label-confirm-password').text('Confirm New Password');
                $('#addEditModal').modal('show');
                $('#passwordFields').prop('disabled', false);
                $('#passwordFields').prop('hidden', false);
                $('#dataFields').prop('disabled', true);
                $('#dataFields').prop('hidden', true);
                $('#addEditForm').validate().resetForm();
                $('#addEditModal').on('shown.bs.modal', function() {
                    $('#password').trigger('focus');
                });
            },
        });
    });

    $(document).on('click', '.edit', function(){
        var id = $(this).data('id');
        $.ajax({
            url :"user/"+ id +"/edit",
            dataType:"json",
            success: function(data)
            {
                $('.modal-title').text('Edit Admin');
                $('#saveButton').val('Update');
                $('#action').val('Edit');
                $('#id').val(data.id);
                $('#name').val(data.name);
                $('#username').val(data.username);
                $('#email').val(data.email);
                $('#jabatan').val(data.role_id);
                $('#dataFields').prop('disabled', false);
                $('#dataFields').prop('hidden', false);
                $('#passwordFields').prop('disabled', true);
                $('#passwordFields').prop('hidden', true);
                $('#addEditModal').modal('show');
                $('#addEditForm').validate().resetForm();
                $('#addEditModal').on('shown.bs.modal', function() {
                    $('#name').trigger('focus');
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
                    url: "user/" + dataId,
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
                            text: "Terjadi masalah pada server! Silakan coba lagi!",
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

        $.validator.addMethod( "nowhitespace", function( value, element ) {
            return this.optional( element ) || /^\S+$/i.test( value );
        }, "Any spaces are not allowed." );

        $.validator.addMethod( "alphanumeric", function( value, element ) {
            return this.optional( element ) || /^\w+$/i.test( value );
        }, "Please enter letters, numbers, and underscores only." );

        $("#addEditForm").validate({
            rules: {
                name: { lettersOnly: true, maxlength: 255, },
                username: { nowhitespace: true, alphanumeric: true, maxlength: 255, },
                email: { maxlength: 255, },
                password: { minlength: 8, },
                password_confirmation: { equalTo: '#password', },
            },

            submitHandler: function (form) {
                if($('#action').val() == 'Add') {
                    action_url = "{{ route('user.store') }}";
                    swal_title = "Berhasil!";
                    swal_text = "Data berhasil ditambahkan!";
                    swal_fail_title = "Data gagal ditambahkan!";
                }

                if($('#action').val() == 'Edit') {
                    action_url = "{{ route('user.update') }}";
                    swal_title = "Berhasil!";
                    swal_text = "Data berhasil diperbarui!";
                    swal_fail_title = "Data gagal diperbarui!";
                }

                if($('#action').val() == 'ChangePass') {
                    action_url = "{{ route('user.update') }}";
                    swal_title = "Berhasil!";
                    swal_text = "Password berhasil diperbarui!";
                    swal_fail_title = "Password gagal diperbarui!";
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
