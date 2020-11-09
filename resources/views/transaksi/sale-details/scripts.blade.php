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
            url: "{{ route('sale-detail.index') }}"
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'nomor_penjualan' },
            { data: 'kuantitas' },
            { data: 'harga_satuan', render: $.fn.dataTable.render.number('.', ',', 2, 'Rp') },
            { data: 'total', render: $.fn.dataTable.render.number('.', ',', 2, 'Rp') },
            { data: 'keterangan' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [
            [0, 'asc']
        ],
    });

    $('#addButton').click(function(){
        $('.modal-title').text('Tambah Rincian Penjualan');
        $('#saveButton').val('Add');
        $('#action').val('Add');
        $('#addEditForm').trigger("reset");
        $('#addEditForm').validate().resetForm();
        $('.price').mask('000.000.000', {reverse: true});
        $('#addEditModal').on('shown.bs.modal', function() {
            $('#sale_id').trigger('focus');
        });
    });

    $('#deleteButton').click(function () {
        $('#deleteButton').html('Processing..');
    });

    if ($("#addEditForm").length > 0) {
        $("#addEditForm").validate({
            rules: {
                keterangan: { maxlength: 500, },
            },
            submitHandler: function (form) {
                $("#price").unmask();

                if($('#action').val() == 'Add') {
                    action_url = "{{ route('sale-detail.store') }}";
                    swal_title = "Berhasil!";
                    swal_text = "Data berhasil ditambahkan!";
                    swal_fail_title = "Gagal!";
                    swal_fail_text = "Data gagal ditambahkan!";
                }

                if($('#action').val() == 'Edit') {
                    action_url = "{{ route('sale-detail.update') }}";
                    swal_title = "Berhasil!";
                    swal_text = "Data berhasil diperbarui!";
                    swal_fail_title = "Gagal!";
                    swal_fail_text = "Data gagal diperbarui!";
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
                        swal({
                            title: swal_fail_title,
                            text: swal_fail_text,
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
                        $('#saveButton').html('Submit');
                    }
                })
            }
        })
    };

    $(document).on('click', '.edit', function(){
        var id = $(this).data('id');
        $.ajax({
            url :"sale-detail/"+ id +"/edit",
            dataType:"json",
            success: function(data)
            {
                $('#id').val(data.id);
                $('#sale_id').val(data.sale_id);
                $('#keterangan').val(data.keterangan);
                $('#kuantitas').val(data.kuantitas);
                $('#price').val(data.harga_satuan);
                $('#saveButton').val('Update');
                $('#action').val('Edit');
                $('.modal-title').text('Edit Rincian Penjualan');
                $('#addEditModal').modal('show');
                $('#addEditForm').validate().resetForm();
                $('.price').mask('000.000.000', {reverse: true});
                $('#addEditModal').on('shown.bs.modal', function() {
                    $('#purchase_id').trigger('focus');
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
                    url: "sale-detail/" + dataId,
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
                })
            }
        });
    });
});
</script>
