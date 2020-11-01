<script>
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });

    $('.harga').mask('000.000.000', {reverse: true});

    $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('package.index') }}"
        },
        columns: [
            { data: 'name' },
            { data: 'kategori' },
            { data: 'harga', render: $.fn.dataTable.render.number('.', ',', 2, 'Rp') },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [
            [0, 'asc']
        ],
    });

    $('#addButton').click(function(){
        $('.modal-title').text('Tambah Paket');
        $('#saveButton').val('Add');
        $('#action').val('Add');
        $('#addEditForm').trigger("reset");
        $('#addEditForm').validate().resetForm();

        $('#addEditModal').on('shown.bs.modal', function() {
            $('#name').trigger('focus');
        });
    });

    $('#deleteButton').click(function () {
        $('#deleteButton').html('Processing..');
    });

    if ($("#addEditForm").length > 0) {
        $("#addEditForm").validate({
            rules: {
                name: { maxlength: 255, },
                harga: { number: true, maxlength: 9, },
            },

            submitHandler: function (form) {
                if($('#action').val() == 'Add') {
                    action_url = "{{ route('package.store') }}";
                    swal_title = "Berhasil!";
                    swal_text = "Data berhasil ditambahkan!";
                    swal_fail_title = "Gagal!";
                    swal_fail_text = "Data gagal ditambahkan!";
                }

                if($('#action').val() == 'Edit') {
                    action_url = "{{ route('package.update') }}";
                    swal_title = "Berhasil!";
                    swal_text = "Data berhasil diperbarui!";
                    swal_fail_title = "Gagal!";
                    swal_fail_text = "Data gagal diperbarui!";
                }

                var actionType = $('#saveButton').val();
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
                                    text: "OK",
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
                            title: swal_fail_title,
                            text: "Periksa kembali inputan Anda!",
                            icon: "error",
                            buttons: {
                                confirm: {
                                    text: "OK",
                                    value: true,
                                    visible: true,
                                    className: "btn btn-danger",
                                    closeModal: true
                                }
                            },
                            timer: 1500,
                        });
                        console.log('Error:', data);
                        $('#saveButton').html('Submit');
                    }
                })
            }
        });
    };

    $(document).on('click', '.edit', function(){
        var id = $(this).data('id');
        $.ajax({
            url :"package/"+ id +"/edit",
            dataType:"json",
            success: function(data)
            {
                $('#id').val(data.id);
                $('#name').val(data.name);
                if(data.kategori == 'Laki-laki'){
                    $("#men").prop("checked", true);
                }
                else if(data.kategori == 'Perempuan'){
                    $("#women").prop("checked", true);
                }
                $('#harga').val(data.harga);
                $('#saveButton').val('Update');
                $('#action').val('Edit');
                $('.modal-title').text('Edit Paket');
                $('#addEditModal').modal('show');
                $('#addEditForm').validate().resetForm();

                $('#addEditModal').on('shown.bs.modal', function() {
                    $('#name').trigger('focus');
                });
            },
        })
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
                    url: "package/" + dataId,
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
                                    text: "OK",
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
                                    text: "OK",
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
                })
            }
        });
    });
});
</script>
