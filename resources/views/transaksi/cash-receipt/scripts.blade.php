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
            url: "{{ route('cash-receipt.index') }}"
        },
        columns: [
            { data: 'nomor_nota' },
            { data: 'account_detail.nomor_rincian_akun', name: 'account_detail.nomor_rincian_akun', orderable: false },
            { data: 'account_detail.nama_rincian_akun', name: 'account_detail.nama_rincian_akun', orderable: false },
            { data: 'jumlah', render: $.fn.dataTable.render.number('.', ',', 2, 'Rp') },
            { data: 'keterangan' },
            { data: 'tanggal' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [
            [0, 'asc']
        ],
    });

    $('#addButton').click(function(){
        $('.modal-title').text('Tambah Penerimaan Kas');
        $('#saveButton').val('Add');
        $('#action').val('Add');
        $('#addEditForm').trigger("reset");
        $('#addEditForm').validate().resetForm();
        $('.jumlah').mask('000.000.000', {reverse: true});
        $('#addEditModal').on('shown.bs.modal', function() {
            $('#rincian_akun').trigger('focus');
        });
    });

    $(document).on('click', '.edit', function(){
        var id = $(this).data('id');
        $.ajax({
            url :"cash-receipt/"+ id +"/edit",
            dataType:"json",
            success: function(data)
            {
                $('.modal-title').text('Edit Penerimaan Kas');
                $('#saveButton').val('Update');
                $('#action').val('Edit');
                $('#id').val(data.id);
                $('#rincian_akun').val(data.account_detail_id);
                $('#jumlah').val(data.jumlah);
                $('#keterangan').val(data.keterangan);
                $('#tanggal').val(data.tanggal);
                $('#addEditModal').modal('show');
                $('#addEditForm').validate().resetForm();
                $('.jumlah').mask('000.000.000', {reverse: true});
                $('#addEditModal').on('shown.bs.modal', function() {
                    $('#rincian_akun').trigger('focus');
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
                    url: "cash-receipt/" + dataId,
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
        $("#addEditForm").validate({
            rules: {
                keterangan: { maxlength: 500, },
            },

            submitHandler: function (form) {
                $(".jumlah").unmask();

                if($('#action').val() == 'Add') {
                    action_url = "{{ route('cash-receipt.store') }}";
                    swal_title = "Berhasil!";
                    swal_text = "Data berhasil ditambahkan!";
                    swal_fail_title = "Data gagal ditambahkan!";
                }

                if($('#action').val() == 'Edit') {
                    action_url = "{{ route('cash-receipt.update') }}";
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
