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
            { data: 'kode_supplier' },
            { data: 'nama_supplier' },
            { data: 'nomor_rincian_akun' },
            { data: 'nama_rincian_akun' },
            { data: 'tanggal' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [
            [0, 'asc']
        ],
    });

    $('#addButton').click(function(){
        $('.modal-title').text('Tambah Pembelian');
        $('#saveButton').val('Add');
        $('#action').val('Add');
        $('#addEditForm').trigger("reset");
        $('#addEditForm').validate().resetForm();
        $('#detailFields').html('');
        add_dynamic_input_field(1);
        $('.price').mask('000.000.000', {reverse: true});

        $('#addEditModal').on('shown.bs.modal', function() {
            $('#account_detail_id').trigger('focus');
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
                $(".price").unmask();
                if($('#action').val() == 'Add') {
                    action_url = "{{ route('purchase.store') }}";
                    swal_title = "Berhasil!";
                    swal_text = "Data berhasil ditambahkan!";
                    swal_fail_title = "Gagal!";
                    swal_fail_text = "Data gagal ditambahkan!";
                }

                if($('#action').val() == 'Edit') {
                    action_url = "{{ route('purchase.update') }}";
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
        });
    };

    if ($("#importForm").length > 0) {
        $("#importForm").validate({
            rules: {},
            submitHandler: function (form) {
                $('#importSubmitButton').html('Processing..');
                var formdata = new FormData($("#importForm")[0]);
                $.ajax({
                    url: "{{ route('purchase.import') }}",
                    type: "POST",
                    data: formdata,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $('#importForm').trigger("reset");
                        $('#importModal').modal('hide');
                        $('#importSubmitButton').html('Submit');
                        var oTable = $('#table').DataTable();
                        oTable.draw(false);
                        swal({
                            title: "Berhasil!",
                            text: "Excel berhasil diimport!",
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
                            title: "Gagal!",
                            text: "Excel gagal diimport!",
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
                        $('#importSubmitButton').html('Submit');
                    }
                })
            }
        });
    };

    $(document).on('click', '.edit', function(){
        var id = $(this).data('id');
        $.ajax({
            url :"purchase/"+ id +"/edit",
            dataType:"json",
            success: function(data)
            {
                $('#id').val(data.id);
                $('#account_detail_id').val(data.account_detail_id);
                $('#supplier_id').val(data.supplier_id);
                $('#tanggal').val(data.tanggal);
                $('#keterangan').val(data.keterangan);
                $('#detailFields').val(data.detail);
                $('#saveButton').val('Update');
                $('#action').val('Edit');
                add_dynamic_input_field(1);
                $('.modal-title').text('Edit Pembelian');
                $('#addEditModal').modal('show');
                $('#addEditForm').validate().resetForm();

                $('#addEditModal').on('shown.bs.modal', function() {
                    $('#account_detail_id').trigger('focus');
                });
            },
        })
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
        output += '<label for="kuantitas" class="col-sm-12 control-label">Kuantitas</label><div class="col-sm-12 input-group w-100"><input type="number" class="form-control" id="kuantitas" name="kuantitas[]" placeholder="Contoh: 5" required>';
        output += '<div class="input-group-append">'+button+'</div></div></div>';
        output += '<div class="form-group"></div>';

        output += '<div id="row'+count+'">';
        output += '<label for="price" class="col-sm-12 control-label">Harga Satuan</label><div class="col-sm-12 input-group w-100"><div class="input-group-prepend"><span class="input-group-text">Rp</span></div><input type="text" class="form-control price" id="price" name="price[]" placeholder="Contoh: 50.000" required>';
        output += '<div class="input-group-append"><span class="input-group-text">,00</span></div></div></div>';
        output += '<div class="form-group"></div>';

        output += '<div id="row'+count+'">';
        output += '<label for="keterangan" class="col-sm-12 control-label">Detail Keterangan</label><div class="col-sm-12"><textarea name="keterangan[]" id="keterangan" class="form-control" placeholder="Contoh: Kursi" rows="4" required></textarea></div></div>';
        output += '<div class="form-group"></div>';

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

    $(document).on('click', '.editDetail', function(){
        var id = $(this).data('id');
        var edPurchaseId = $(this).attr('id');
        $.ajax({
            url :"purchase-detail/"+ id +"/edit",
            dataType:"json",
            success: function(data)
            {
                $('#id').val(data.id);
                $('#keterangan').val(data.keterangan);
                $('#kuantitas').val(data.kuantitas);
                $('#price').val(data.harga_satuan);
                $('#saveButton').val('Update');
                $('#action').val('Edit');
                $('.modal-title').text('Edit Rincian Pembelian');
                $('#detailModal').modal('show');
                $('#detailForm').validate().resetForm();
                $('.price').mask('000.000.000', {reverse: true});
                $('#detailModal').on('shown.bs.modal', function() {
                    $('#purchase_id').trigger('focus');
                });
            },
        })
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
