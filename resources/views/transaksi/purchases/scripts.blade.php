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
            url: "{{ route('purchase.index') }}"
        },
        columns: [
            { data: 'nomor_pembelian' },
            { data: 'kode_supplier', orderable: false },
            { data: 'nama_supplier', orderable: false },
            { data: 'nomor_rincian_akun', orderable: false },
            { data: 'nama_rincian_akun', orderable: false },
            { data: 'tanggal' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [
            [5, 'asc']
        ],
    });

    $('#addButton').click(function(){
        $('.modal-title').text('Tambah Pembelian');
        $('#saveButton').val('Add');
        $('#action').val('Add');
        $('#addEditForm').trigger("reset");
        $('#addEditForm').validate().resetForm();
        $('#detailFields').prop('disabled', false);
        $('#detailFields').prop('hidden', false);
        $('#addEditModal').on('shown.bs.modal', function() {
            $('#account_detail_id').trigger('focus');
        });
        add_dynamic_input_field(1);
        $('.price').mask('000.000.000', {reverse: true});
    });

    $(document).on('click', '.edit', function(){
        var id = $(this).data('id');
        $.ajax({
            url :"purchase/"+ id +"/edit",
            dataType:"json",
            success: function(data)
            {
                $('.modal-title').text('Edit Pembelian');
                $('#saveButton').val('Update');
                $('#action').val('Edit');
                $('#id').val(data.id);
                $('#account_detail_id').val(data.account_detail_id);
                $('#supplier_id').val(data.supplier_id);
                $('#tanggal').val(data.tanggal);
                $('#detailFields').prop('disabled', true);
                $('#detailFields').prop('hidden', true);
                $('#addEditModal').modal('show');
                $('#addEditForm').validate().resetForm();
                $('#addEditModal').on('shown.bs.modal', function() {
                    $('#account_detail_id').trigger('focus');
                });
                add_dynamic_input_field(1);
            },
        });
    });

    $(document).on('click', '.detail', function () {
        var userId = $(this).data('id');
        $.ajax({
            url: 'purchase/' + userId,
            type: 'GET',
            success: function(response){
                $('.modal-title').text('Rincian Pembelian');
                $('.showModal').html(response);
                $('#showModal').modal('show')
            }
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
                    url: "purchase/" + dataId,
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

    $('#addDetailButton').click(function(){
        var userId = $('.detail').data('id');
        $('.modal-title').text('Tambah Rincian Pembelian');
        $('#saveButton').val('AddDetail');
        $('#action').val('AddDetail');
        $('#id').val(userId);
        $('#addEditForm').trigger("reset");
        $('#addEditForm').validate().resetForm();
        $('#detailFields').prop('disabled', false);
        $('#detailFields').prop('hidden', false);
        $('#purchaseFields').prop('disabled', true);
        $('#purchaseFields').prop('hidden', true);
        $('#detailFields').html('');
        $('#addEditModal').on('shown.bs.modal', function() {
            $('#kuantitas').trigger('focus');
        });
        add_dynamic_input_field(1);
        $('.price').mask('000.000.000', {reverse: true});
    });

    $(document).on('click', '.editDetail', function(){
        var id = $(this).data('id');
        var edPurchaseId = $(this).attr('id');
        $.ajax({
            url :"purchase-detail/"+ id +"/edit",
            dataType:"json",
            success: function(data)
            {
                $('.modal-title').text('Edit Rincian Pembelian');
                $('#editDetailButton').val('Update');
                $('#detailAction').val('Edit');
                $('#detailId').val(data.id);
                $('#detailKuantitas').val(data.kuantitas);
                $('#detailPrice').val(data.harga_satuan);
                $('#detailKeterangan').val(data.keterangan);
                $('#editDetailModal').modal('show');
                $('#editDetailForm').validate().resetForm();
                $('.detailPrice').mask('000.000.000', {reverse: true});
                $('#editDetailModal').on('shown.bs.modal', function() {
                    $('#detailKuantitas').trigger('focus');
                });
            },
        });
    });

    $(document).on('click', '.deleteDetail', function () {
        var dataId = $(this).attr('id');
        var ddPurchaseId = $(this).data('id');
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
                    url: "purchase-detail/" + dataId,
                    type: 'DELETE',
                    success: function (data) {
                        $.ajax({
                            url: 'purchase/' + ddPurchaseId,
                            type: 'GET',
                            success: function(response){
                                $('.modal-title').text('Rincian Pembelian');
                                $('.showModal').html(response);
                                $('#showModal').modal('show')
                            }
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
                price: { number: true, },
                keterangan: { maxlength: 500, },
            },

            submitHandler: function (form) {
                var userId = $('.detail').data('id');
                $(".price").unmask();

                if($('#action').val() == 'Add') {
                    action_url = "{{ route('purchase.store') }}";
                    swal_title = "Berhasil!";
                    swal_text = "Data berhasil ditambahkan!";
                    swal_fail_title = "Data gagal ditambahkan!";
                }

                if($('#action').val() == 'Edit') {
                    action_url = "{{ route('purchase.update') }}";
                    swal_title = "Berhasil!";
                    swal_text = "Data berhasil diperbarui!";
                    swal_fail_title = "Data gagal diperbarui!";
                }

                if($('#action').val() == 'AddDetail') {
                    action_url = "{{ route('purchase-detail.store') }}";
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
                        add_dynamic_input_field(1);
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

                        if($('#action').val() == 'AddDetail') {
                            $.ajax({
                                url: 'purchase/' + userId,
                                type: 'GET',
                                success: function(response){
                                    $('.modal-title').text('Rincian Pembelian');
                                    $('.showModal').html(response);
                                }
                            });
                        };
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

    if ($("#editDetailForm").length > 0) {
        $("#editDetailForm").validate({
            rules: {
                keterangan: { maxlength: 500, },
            },

            submitHandler: function (form) {
                var userId = $('.detail').data('id');
                $(".detailPrice").unmask();
                $('#editDetailButton').html('Processing..');
                $.ajax({
                    data: $('#editDetailForm').serialize(),
                    url: "{{ route('purchase-detail.update') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#editDetailForm').trigger("reset");
                        $('#editDetailModal').modal('hide');
                        $('#editDetailButton').html('Edit');
                        add_dynamic_input_field(1);

                        swal({
                            title: "Berhasil!",
                            text: "Data berhasil diperbarui!",
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

                        $.ajax({
                            url: 'purchase/' + userId,
                            type: 'GET',
                            success: function(response){
                                $('.modal-title').text('Rincian Pembelian');
                                $('.showModal').html(response);
                            }
                        });
                    },
                    error: function (data) {
                        if(data.responseJSON.errors) {
                            var values = '';
                            jQuery.each(data.responseJSON.errors, function (key, value) {
                                values += "• " + value + "\n"
                            });

                            swal({
                                title: "Data gagal ditambahkan!",
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
                                title: "Data gagal diperbarui!",
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
                        $('#editDetailButton').html('Edit');
                    }
                });
            }
        });
    };

    var count = 1;
    function add_dynamic_input_field(count)
    {
        var button = '';
        if(count > 1) {
            button = '<button type="button" name="remove" id="'+count+'" class="btn btn-danger btn-xs remove">x</button>';
        } else {
            button = '<button type="button" name="add_more" id="add_more" class="btn btn-success btn-xs ml-auto">+</button>';
        }

        output = '<div id="row'+count+'">';
            output += '<div class="form-group">';
            output += '<label for="kuantitas" class="col-sm-12 control-label">Kuantitas</label>';
            output += '<div class="col-sm-12 input-group w-100"><input type="number" class="form-control" id="kuantitas" name="kuantitas[]" placeholder="Contoh: 5" required><div class="input-group-append">'+button+'</div></div>'
            output += '</div>';
            output += '<div class="form-group">';
            output += '<label for="price" class="col-sm-12 control-label">Harga Satuan</label>';
            output += '<div class="col-sm-12 input-group w-100"><div class="input-group-prepend"><span class="input-group-text">Rp</span></div><input type="text" class="form-control price" id="price" name="price[]" placeholder="Contoh: 50.000" required><div class="input-group-append"><span class="input-group-text">,00</span></div></div>'
            output += '</div>';
            output += '<div class="form-group">';
            output += '<label for="keterangan" class="col-sm-12 control-label">Keterangan</label>';
            output += '<div class="col-sm-12"><textarea name="keterangan[]" id="keterangan" class="form-control" placeholder="Contoh: Kursi" rows="4" required></textarea></div>'
            output += '</div>';
        output += '</div>';
        $('#detailFields').append(output);
    }

    $(document).on('click', '#add_more', function(){
        count = count + 1;
        add_dynamic_input_field(count);
        $('.price').mask('000.000.000', {reverse: true});
    });

    $(document).on('click', '.remove', function(){
        var row_id = $(this).attr("id");
        $('#row'+row_id).remove();
    });
});
</script>
