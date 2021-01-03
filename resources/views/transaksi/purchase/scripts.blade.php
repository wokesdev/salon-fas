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
            { data: 'supplier.kode_supplier', name: 'supplier.kode_supplier', orderable: false },
            { data: 'supplier.nama', name: 'supplier.nama', orderable: false },
            { data: 'account_detail.nomor_rincian_akun', name: 'account_detail.nomor_rincian_akun', orderable: false },
            { data: 'account_detail.nama_rincian_akun', name: 'account_detail.nama_rincian_akun', orderable: false },
            { data: 'total', render: $.fn.dataTable.render.number('.', ',', 2, 'Rp') },
            { data: 'tanggal' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [
            [6, 'asc']
        ],
    });

    $('#addButton').click(function(){
        $.ajax({
            url: "{{ route('purchase.getBarang') }}",
            type: "POST",
            dataType: "json",
            beforeSend: function()
            {
                $('#detailFields').html('');
                add_dynamic_input_field(1);
                $('#barang1').prop('disabled', true);
                $('#kuantitas1').prop('disabled', true);
                $('#harga_satuan1').prop('disabled', true);
            },
            success: function(data){
                var html = '<option value="" disabled selected>Pilih Barang</option>';
                var i;
                for (i = 0; i < data.length; i++) {
                    html += '<option value='+data[i].id+'>'+data[i].nama+'</option>';
                }
                $('.barang').html(html);
                $('#barang1').prop('disabled', false);
                $('#kuantitas1').prop('disabled', false);
                $('#harga_satuan1').prop('disabled', false);
            }
        });

        $('#total').val('');
        $('.modal-title').text('Tambah Pembelian');
        $('#saveButton').val('Add');
        $('#action').val('Add');
        $('#mainFields').prop('disabled', false);
        $('#mainFields').prop('hidden', false);
        $('#purchaseFields').prop('disabled', false);
        $('#purchaseFields').prop('hidden', false);
        $('#detailFields').prop('disabled', false);
        $('#detailFields').prop('hidden', false);
        $('#totalField').prop('disabled', false);
        $('#totalField').prop('hidden', false);
        $('#mainFields').removeClass('col-sm-12');
        $('#mainFields').addClass('col-sm-6');
        $('#detailFields').removeClass('col-sm-12');
        $('#detailFields').addClass('col-sm-6');
        $('#addEditForm').trigger("reset");
        $('#addEditForm').validate().resetForm();
        $('#addEditModal').on('shown.bs.modal', function() {
            $('#rincian_akun').trigger('focus');
        });
    });

    $(document).on('click', '.detail', function () {
        var userId = $(this).data('id');
        $.ajax({
            url: 'purchase/' + userId,
            type: 'GET',
            success: function(response){
                $('.showModal').html(response);
            }
        });

        $('#id').val(userId);
        $('.modal-title').text('Rincian Pembelian');
        $('#showModal').modal('show')
    });

    $(document).on('click', '.edit', function(){
        var id = $(this).data('id');
        $.ajax({
            url :"purchase/"+ id +"/edit",
            dataType:"json",
            success: function(data)
            {
                $('#id').val(data.id);
                $('#rincian_akun').val(data.account_detail_id);
                $('#rincian_akun_pembayaran').val(data.account_detail_payment_id);
                $('#supplier').val(data.supplier_id);
                $('#tanggal').val(data.tanggal);
            },
        });

        $('.modal-title').text('Edit Pembelian');
        $('#saveButton').val('Update');
        $('#action').val('Edit');
        $('#mainFields').prop('disabled', false);
        $('#mainFields').prop('hidden', false);
        $('#purchaseFields').prop('disabled', false);
        $('#purchaseFields').prop('hidden', false);
        $('#detailFields').prop('disabled', true);
        $('#detailFields').prop('hidden', true);
        $('#totalField').prop('disabled', true);
        $('#totalField').prop('hidden', true);
        $('#mainFields').removeClass('col-sm-6');
        $('#mainFields').addClass('col-sm-12');
        $('#addEditModal').modal('show');
        $('#addEditForm').validate().resetForm();
        $('#addEditModal').on('shown.bs.modal', function() {
            $('#rincian_akun').trigger('focus');
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
        $.ajax({
            url: "{{ route('purchase.getBarang') }}",
            type: "POST",
            dataType: "json",
            beforeSend: function()
            {
                $('#detailFields').html('');
                add_dynamic_input_field(1);
                $('#barang1').prop('disabled', true);
                $('#kuantitas1').prop('disabled', true);
                $('#harga_satuan1').prop('disabled', true);
            },
            success: function(data){
                var html = '<option value="" disabled selected>Pilih Barang</option>';
                var i;
                for (i = 0; i < data.length; i++) {
                    html += '<option value='+data[i].id+'>'+data[i].nama+'</option>';
                }
                $('.barang').html(html);
                $('#barang1').prop('disabled', false);
                $('#kuantitas1').prop('disabled', false);
                $('#harga_satuan1').prop('disabled', false);
            }
        });

        $('.modal-title').text('Tambah Rincian Pembelian');
        $('#saveButton').val('AddDetail');
        $('#action').val('AddDetail');
        $('#mainFields').prop('disabled', true);
        $('#mainFields').prop('hidden', true);
        $('#purchaseFields').prop('disabled', true);
        $('#purchaseFields').prop('hidden', true);
        $('#detailFields').prop('disabled', false);
        $('#detailFields').prop('hidden', false);
        $('#detailFields').removeClass('col-sm-6');
        $('#detailFields').addClass('col-sm-12');
        $('#addEditForm').trigger("reset");
        $('#addEditForm').validate().resetForm();
        $('#addEditModal').on('shown.bs.modal', function() {
            $('#kuantitas').trigger('focus');
        });
    });

    $(document).on('click', '.editDetail', function(){
        var id = $(this).data('id');
        var edPurchaseId = $(this).attr('id');
        $.ajax({
            url :"purchase-detail/"+ id +"/edit",
            dataType:"json",
            beforeSend: function()
            {
                $('#detailBarang').prop('disabled', true);
                $('#detailKuantitas').prop('disabled', true);
                $('#detailHargaSatuan').prop('disabled', true);
            },
            success: function(data)
            {
                $('#detailId').val(data.id);
                $('#detailBarang').val(data.item_id);
                $('#detailKuantitas').val(data.kuantitas);
                $('#detailHargaSatuan').val(data.harga_satuan);
                $('#detailSubtotal').val(data.subtotal);
                $('#currentSubtotal').val(data.subtotal);
                $('#detailBarang').prop('disabled', false);
                $('#detailKuantitas').prop('disabled', false);
                $('#detailHargaSatuan').prop('disabled', false);
            },
        });

        $('#purchaseId').val(edPurchaseId);
        $('.modal-title').text('Edit Rincian Pembelian');
        $('#editDetailButton').val('Update');
        $('#detailAction').val('Edit');
        $('#editDetailModal').modal('show');
        $('#editDetailForm').validate().resetForm();
        $('#editDetailModal').on('shown.bs.modal', function() {
            $('#detailBarang').trigger('focus');
        });

        $(".input").on("keyup", function(){
            var val = parseInt($("#detailKuantitas").val()) * parseInt($("#detailHargaSatuan").val());
            $("#detailSubtotal").val(val);
        });

        $(".input").on("change", function(){
            var val = parseInt($("#detailKuantitas").val()) * parseInt($("#detailHargaSatuan").val());
            $("#detailSubtotal").val(val);
        });

        $("#detailBarang").change(function(){
            var id = $('#detailBarang').val();
            $.ajax({
                url :"purchase/"+ id +"/getBarangById",
                dataType:"json",
                beforeSend: function()
                {
                    $('#detailKuantitas').prop('disabled', true);
                    $('#detailHargaSatuan').prop('disabled', true);
                },
                success: function(data)
                {
                    $('#detailHargaSatuan').val(data.harga_beli);
                    var val = parseInt($("#detailKuantitas").val()) * parseInt($("#detailHargaSatuan").val());
                    $("#detailSubtotal").val(val);
                    $('#detailKuantitas').prop('disabled', false);
                    $('#detailHargaSatuan').prop('disabled', false);
                },
            });
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
                        setTimeout(function () {
                            var oTable = $('#table').DataTable();
                            oTable.draw(false);
                        });
                        $.ajax({
                            url: 'purchase/' + ddPurchaseId,
                            type: 'GET',
                            success: function(response){
                                $('.modal-title').text('Rincian Pembelian');
                                $('.showModal').html(response);
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

    $('#addEditModal').on('hide.bs.modal', function() {
        $('.modal-title').text('Rincian Pembelian');
    });

    $('#editDetailModal').on('hide.bs.modal', function() {
        $('.modal-title').text('Rincian Pembelian');
    });

    if ($("#addEditForm").length > 0) {
        $("#addEditForm").validate({
            rules: {},
            submitHandler: function (form) {
                var userId = $('#id').val();
                $('.modal-title').text('Rincian Pembelian');

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
                                    $('.showModal').html(response);
                                }
                            });

                            $('.modal-title').text('Rincian Pembelian');
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

                        else if(data.responseJSON.message) {
                            var values = data.responseJSON.message;
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
            rules: {},
            submitHandler: function (form) {
                var userId = $('.detail').data('id');
                $('.modal-title').text('Rincian Pembelian');
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
                        var oTable = $('#table').DataTable();
                        oTable.draw(false);

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
                                $('.showModal').html(response);
                            }
                        });

                        $('.modal-title').text('Rincian Pembelian');
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

                        else if(data.responseJSON.message) {
                            var values = data.responseJSON.message;
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
            output += '<label for="barang" class="col-sm-12 control-label">Barang</label>';
            output += '<div class="col-sm-12 input-group w-100"><select class="form-control barang" id="barang'+count+'" name="barang[]" required></select><div class="input-group-append">'+button+'</div></div>'
            output += '</div>';
            output += '<div class="form-group">';
            output += '<label for="kuantitas" class="col-sm-12 control-label">Kuantitas</label>';
            output += '<div class="col-sm-12"><input type="number" class="form-control input'+count+' kuantitas" id="kuantitas'+count+'" name="kuantitas[]" placeholder="Contoh: 5" required></div>'
            output += '</div>';
            output += '<div class="form-group">';
            output += '<label for="harga_satuan" class="col-sm-12 control-label">Harga Satuan</label>';
            output += '<div class="col-sm-12 input-group w-100"><div class="input-group-prepend"><span class="input-group-text">Rp</span></div><input type="number" class="form-control input'+count+' harga_satuan" id="harga_satuan'+count+'" name="harga_satuan[]" placeholder="Contoh: 50.000" required><div class="input-group-append"><span class="input-group-text">,00</span></div></div>'
            output += '</div>';
            output += '<div class="form-group">';
            output += '<label for="subtotal" class="col-sm-12 control-label">Subtotal</label>';
            output += '<div class="col-sm-12 input-group w-100"><div class="input-group-prepend"><span class="input-group-text">Rp</span></div><input type="number" class="form-control subtotal" id="subtotal'+count+'" name="subtotal[]" placeholder="0" required readonly><div class="input-group-append"><span class="input-group-text">,00</span></div></div>'
            output += '</div>';
            output += '<hr class="mt-3 mb-3 bg-dark">'
        output += '</div>';
        $('#detailFields').append(output);

        $(".input" + count).on("keyup", function(){
            var val = parseInt($("#kuantitas" + count).val()) * parseInt($("#harga_satuan" + count).val());
            $("#subtotal" + count).val(val);
        });

        $(".input" + count).on("change", function(){
            var val = parseInt($("#kuantitas" + count).val()) * parseInt($("#harga_satuan" + count).val());
            $("#subtotal" + count).val(val);
        });

        $("#barang" + count).change(function(){
            var id = $('#barang' + count).val();
            $.ajax({
                url :"purchase/"+ id +"/getBarangById",
                dataType:"json",
                beforeSend: function()
                {
                    $('#kuantitas' + count).prop('disabled', true);
                    $('#harga_satuan' + count).prop('disabled', true);
                },
                success: function(data)
                {
                    $('#harga_satuan' + count).val(data.harga_beli);
                    var val = parseInt($("#kuantitas" + count).val()) * parseInt($("#harga_satuan" + count).val());
                    $("#subtotal" + count).val(val);
                    $('#kuantitas' + count).prop('disabled', false);
                    $('#harga_satuan' + count).prop('disabled', false);
                },
            });
        });

        $(".kuantitas").keyup(function(){
            var total = 0;
            $('.subtotal').each(function() {
                total = total + parseInt($(this).val());
            });
            $("#total").val(total);
        });

        $(".harga_satuan").keyup(function(){
            var total = 0;
            $('.subtotal').each(function() {
                total = total + parseInt($(this).val());
            });
            $("#total").val(total);
        });

        $(".kuantitas").change(function(){
            var total = 0;
            $('.subtotal').each(function() {
                total = total + parseInt($(this).val());
            });
            $("#total").val(total);
        });

        $(".harga_satuan").change(function(){
            var total = 0;
            $('.subtotal').each(function() {
                total = total + parseInt($(this).val());
            });
            $("#total").val(total);
        });
    }

    $(document).on('click', '#add_more', function(){
        count = count + 1;
        add_dynamic_input_field(count);

        $.ajax({
            url: "{{ route('purchase.getBarang') }}",
            type: "POST",
            dataType: "json",
            beforeSend: function()
            {
                $('#barang' + count).prop('disabled', true);
                $('#kuantitas' + count).prop('disabled', true);
                $('#harga_satuan' + count).prop('disabled', true);
            },
            success: function(data){
                var html = '<option value="" disabled selected>Pilih Barang</option>';
                var i;
                for (i = 0; i < data.length; i++) {
                    html += '<option value='+data[i].id+'>'+data[i].nama+'</option>';
                }
                $('#barang' + count).html(html);
                $('#barang' + count).prop('disabled', false);
                $('#kuantitas' + count).prop('disabled', false);
                $('#harga_satuan' + count).prop('disabled', false);
            }
        });
    });

    $(document).on('click', '.remove', function(){
        var row_id = $(this).attr("id");
        $('#row'+row_id).remove();
    });
});
</script>
