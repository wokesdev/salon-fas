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
            url: "{{ route('sale.index') }}"
        },
        columns: [
            { data: 'nomor_penjualan' },
            { data: 'customer.kode_pelanggan', name: 'customer.kode_pelanggan', orderable: false },
            { data: 'customer.nama', name: 'customer.nama', orderable: false },
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

    $('#addButtonServisBarang').click(function(){
        $.ajax({
            url: "{{ route('purchase.getBarang') }}",
            type: "POST",
            dataType: "json",
            beforeSend: function()
            {
                $('#detailFields').html('');
                add_dynamic_input_field(1);
                $('#barang1').prop('disabled', true);
                $('#servis1').prop('disabled', true);
                $('#kuantitas1').prop('disabled', true);
                $('#harga_satuan1').prop('disabled', true);
                $('#kuantitasServis1').prop('disabled', true);
                $('#harga_satuan_servis1').prop('disabled', true);
            },
            success: function(data){
                var html = '<option value="" disabled selected>Pilih Barang</option>';
                var i;
                for (i = 0; i < data.length; i++) {
                    html += '<option value='+data[i].id+'>'+data[i].nama+'</option>';
                }
                $('.barang').html(html);
                $('#barang1').prop('disabled', false);
                $('#servis1').prop('disabled', false);
                $('#kuantitas1').prop('disabled', false);
                $('#harga_satuan1').prop('disabled', false);
                $('#kuantitasServis1').prop('disabled', false);
                $('#harga_satuan_servis1').prop('disabled', false);
            }
        });

        $.ajax({
            url: "{{ route('purchase.getServis') }}",
            type: "POST",
            dataType: "json",
            beforeSend: function()
            {
                $('#detailFields').html('');
                add_dynamic_input_field(1);
                $('#barang1').prop('disabled', true);
                $('#servis1').prop('disabled', true);
                $('#kuantitas1').prop('disabled', true);
                $('#harga_satuan1').prop('disabled', true);
                $('#kuantitasServis1').prop('disabled', true);
                $('#harga_satuan_servis1').prop('disabled', true);
            },
            success: function(data){
                var html = '<option value="" disabled selected>Pilih Servis</option>';
                var i;
                for (i = 0; i < data.length; i++) {
                    html += '<option value='+data[i].id+'>'+data[i].nama+'</option>';
                }
                $('.servis').html(html);
                $('#barang1').prop('disabled', false);
                $('#servis1').prop('disabled', false);
                $('#kuantitas1').prop('disabled', false);
                $('#harga_satuan1').prop('disabled', false);
                $('#kuantitasServis1').prop('disabled', false);
                $('#harga_satuan_servis1').prop('disabled', false);
            }
        });

        $('#total').val('');
        $('.modal-title').text('Tambah Penjualan');
        $('#saveButton').val('Add');
        $('#action').val('Add');
        $('#mainFields').prop('disabled', false);
        $('#mainFields').prop('hidden', false);
        $('#saleFields').prop('disabled', false);
        $('#saleFields').prop('hidden', false);
        $('#detailFields').prop('disabled', false);
        $('#detailFields').prop('hidden', false);
        $('#totalFieldBarang').prop('disabled', false);
        $('#totalFieldBarang').prop('hidden', false);
        $('#totalFieldServis').prop('disabled', false);
        $('#totalFieldServis').prop('hidden', false);
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

    $('#addButtonServis').click(function(){
        $.ajax({
            url: "{{ route('purchase.getServis') }}",
            type: "POST",
            dataType: "json",
            beforeSend: function()
            {
                $('#detailFields').html('');
                add_dynamic_input_field_servis(1);
                $('#servis1').prop('disabled', true);
                $('#kuantitasServis1').prop('disabled', true);
                $('#harga_satuan_servis1').prop('disabled', true);
            },
            success: function(data){
                var html = '<option value="" disabled selected>Pilih Servis</option>';
                var i;
                for (i = 0; i < data.length; i++) {
                    html += '<option value='+data[i].id+'>'+data[i].nama+'</option>';
                }
                $('.servis').html(html);
                $('#servis1').prop('disabled', false);
                $('#kuantitasServis1').prop('disabled', false);
                $('#harga_satuan_servis1').prop('disabled', false);
            }
        });

        $('#total').val('');
        $('.modal-title').text('Tambah Penjualan');
        $('#saveButton').val('Add');
        $('#action').val('Add');
        $('#mainFields').prop('disabled', false);
        $('#mainFields').prop('hidden', false);
        $('#saleFields').prop('disabled', false);
        $('#saleFields').prop('hidden', false);
        $('#detailFields').prop('disabled', false);
        $('#detailFields').prop('hidden', false);
        $('#totalFieldBarang').prop('disabled', true);
        $('#totalFieldBarang').prop('hidden', true);
        $('#totalFieldServis').prop('disabled', false);
        $('#totalFieldServis').prop('hidden', false);
        $('#totalField').prop('disabled', true);
        $('#totalField').prop('hidden', true);
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

    $('#addButtonBarang').click(function(){
        $.ajax({
            url: "{{ route('purchase.getBarang') }}",
            type: "POST",
            dataType: "json",
            beforeSend: function()
            {
                $('#detailFields').html('');
                add_dynamic_input_field_barang(1);
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
        $('.modal-title').text('Tambah Penjualan');
        $('#saveButton').val('Add');
        $('#action').val('Add');
        $('#mainFields').prop('disabled', false);
        $('#mainFields').prop('hidden', false);
        $('#saleFields').prop('disabled', false);
        $('#saleFields').prop('hidden', false);
        $('#detailFields').prop('disabled', false);
        $('#detailFields').prop('hidden', false);
        $('#totalFieldBarang').prop('disabled', false);
        $('#totalFieldBarang').prop('hidden', false);
        $('#totalFieldServis').prop('disabled', true);
        $('#totalFieldServis').prop('hidden', true);
        $('#totalField').prop('disabled', true);
        $('#totalField').prop('hidden', true);
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
            url: 'sale/' + userId,
            type: 'GET',
            success: function(response){
                $('.showModal').html(response);
            }
        });

        $('#id').val(userId);
        $('.modal-title').text('Rincian Penjualan');
        $('#showModal').modal('show')
    });

    $(document).on('click', '.edit', function(){
        var id = $(this).data('id');
        $.ajax({
            url :"sale/"+ id +"/edit",
            dataType:"json",
            success: function(data)
            {
                $('#id').val(data.id);
                $('#rincian_akun').val(data.account_detail_id);
                $('#rincian_akun_pembayaran').val(data.account_detail_payment_id);
                $('#customer').val(data.customer_id);
                $('#tanggal').val(data.tanggal);
            },
        });

        $('.modal-title').text('Edit Penjualan');
        $('#saveButton').val('Update');
        $('#action').val('Edit');
        $('#mainFields').prop('disabled', false);
        $('#mainFields').prop('hidden', false);
        $('#purchaseFields').prop('disabled', false);
        $('#purchaseFields').prop('hidden', false);
        $('#detailFields').prop('disabled', true);
        $('#detailFields').prop('hidden', true);
        $('#totalFieldBarang').prop('disabled', true);
        $('#totalFieldBarang').prop('hidden', true);
        $('#totalFieldServis').prop('disabled', true);
        $('#totalFieldServis').prop('hidden', true);
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
                    url: "sale/" + dataId,
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
            url: "{{ route('purchase.getServis') }}",
            type: "POST",
            dataType: "json",
            success: function(data){
                var html = '<option value="" disabled selected>Pilih Servis</option>';
                var i;
                for (i = 0; i < data.length; i++) {
                    html += '<option value='+data[i].id+'>'+data[i].nama+'</option>';
                }
                $('.servis').html(html);
            }
        });

        $.ajax({
            url: "{{ route('purchase.getBarang') }}",
            type: "POST",
            dataType: "json",
            success: function(data){
                var html = '<option value="" disabled selected>Pilih Barang</option>';
                var i;
                for (i = 0; i < data.length; i++) {
                    html += '<option value='+data[i].id+'>'+data[i].nama+'</option>';
                }
                $('.barang').html(html);
            }
        });

        $('#detailFields').html('');
        add_dynamic_input_field(1);
        $('.modal-title').text('Tambah Rincian Penjualan');
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

    $('#addDetailButtonServis').click(function(){
        $.ajax({
            url: "{{ route('purchase.getServis') }}",
            type: "POST",
            dataType: "json",
            success: function(data){
                var html = '<option value="" disabled selected>Pilih Servis</option>';
                var i;
                for (i = 0; i < data.length; i++) {
                    html += '<option value='+data[i].id+'>'+data[i].nama+'</option>';
                }
                $('.servis').html(html);
            }
        });

        $('#detailFields').html('');
        add_dynamic_input_field_servis(1);
        $('.modal-title').text('Tambah Rincian Penjualan');
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

    $('#addDetailButtonBarang').click(function(){
        $.ajax({
            url: "{{ route('purchase.getBarang') }}",
            type: "POST",
            dataType: "json",
            success: function(data){
                var html = '<option value="" disabled selected>Pilih Barang</option>';
                var i;
                for (i = 0; i < data.length; i++) {
                    html += '<option value='+data[i].id+'>'+data[i].nama+'</option>';
                }
                $('.barang').html(html);
            }
        });

        $('#detailFields').html('');
        add_dynamic_input_field_barang(1);
        $('.modal-title').text('Tambah Rincian Penjualan');
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

    $(document).on('click', '.editDetailServis', function(){
        var id = $(this).data('id');
        var edSaleId = $(this).attr('id');
        $.ajax({
            url :"sale-detail/"+ id +"/edit",
            dataType:"json",
            success: function(data)
            {
                $('#detailId').val(data.id);
                $('#detailServis').val(data.service_id);
                $('#detailKuantitasServis').val(data.kuantitas_servis);
                $('#detailHargaSatuanServis').val(data.harga_satuan_servis);
                $('#detailSubtotalServis').val(data.subtotal_servis);
                $('#currentSubtotalServis').val(data.subtotal_servis);
            },
        });

        $('#servisField').prop('disabled', false);
        $('#servisField').prop('hidden', false);
        $('#barangField').prop('disabled', true);
        $('#barangField').prop('hidden', true);
        $('#saleId').val(edSaleId);
        $('.modal-title').text('Edit Rincian Penjualan');
        $('#editDetailButton').val('Update');
        $('#detailAction').val('Edit');
        $('#editDetailModal').modal('show');
        $('#editDetailForm').validate().resetForm();
        $('#editDetailModal').on('shown.bs.modal', function() {
            $('#detailServis').trigger('focus');
        });

        $(".input").on("keyup", function(){
            var val = parseInt($("#detailKuantitasServis").val()) * parseInt($("#detailHargaSatuanServis").val());
            $("#detailSubtotalServis").val(val);
        });

        $(".input").on("change", function(){
            var val = parseInt($("#detailKuantitasServis").val()) * parseInt($("#detailHargaSatuanServis").val());
            $("#detailSubtotalServis").val(val);
        });

        $("#detailServis").change(function(){
            var id = $('#detailServis').val();
            $.ajax({
                url :"purchase/"+ id +"/getServisById",
                dataType:"json",
                beforeSend: function()
                {
                    $('#detailServis').prop('disabled', true);
                    $('#detailKuantitasServis').prop('disabled', true);
                    $('#detailHargaSatuanServis').prop('disabled', true);
                },
                success: function(data)
                {
                    $('#detailHargaSatuanServis').val(data.harga);
                    var val = parseInt($("#detailKuantitasServis").val()) * parseInt($("#detailHargaSatuanServis").val());
                    $("#detailSubtotalServis").val(val);
                    $('#detailServis').prop('disabled', false);
                    $('#detailKuantitasServis').prop('disabled', false);
                    $('#detailHargaSatuanServis').prop('disabled', false);
                },
            });
        });
    });

    $(document).on('click', '.editDetailBarang', function(){
        var id = $(this).data('id');
        var edSaleId = $(this).attr('id');
        $.ajax({
            url :"sale-detail/"+ id +"/edit",
            dataType:"json",
            success: function(data)
            {
                $('#detailId').val(data.id);
                $('#detailBarang').val(data.item_id);
                $('#detailKuantitasBarang').val(data.kuantitas_barang);
                $('#detailHargaSatuanBarang').val(data.harga_satuan_barang);
                $('#detailSubtotalBarang').val(data.subtotal_barang);
                $('#currentSubtotalBarang').val(data.subtotal_barang);
            },
        });

        $('#servisField').prop('disabled', true);
        $('#servisField').prop('hidden', true);
        $('#barangField').prop('disabled', false);
        $('#barangField').prop('hidden', false);
        $('#saleId').val(edSaleId);
        $('.modal-title').text('Edit Rincian Penjualan');
        $('#editDetailButton').val('Update');
        $('#detailAction').val('Edit');
        $('#editDetailModal').modal('show');
        $('#editDetailForm').validate().resetForm();
        $('#editDetailModal').on('shown.bs.modal', function() {
            $('#detailBarang').trigger('focus');
        });

        $(".input").on("keyup", function(){
            var val = parseInt($("#detailKuantitasBarang").val()) * parseInt($("#detailHargaSatuanBarang").val());
            $("#detailSubtotalBarang").val(val);
        });

        $(".input").on("change", function(){
            var val = parseInt($("#detailKuantitasBarang").val()) * parseInt($("#detailHargaSatuanBarang").val());
            $("#detailSubtotalBarang").val(val);
        });

        $("#detailBarang").change(function(){
            var id = $('#detailBarang').val();
            $.ajax({
                url :"purchase/"+ id +"/getBarangById",
                dataType:"json",
                beforeSend: function()
                {
                    $('#detailBarang').prop('disabled', true);
                    $('#detailKuantitasBarang').prop('disabled', true);
                    $('#detailHargaSatuanBarang').prop('disabled', true);
                },
                success: function(data)
                {
                    $('#detailHargaSatuanBarang').val(data.harga_beli);
                    var val = parseInt($("#detailKuantitasBarang").val()) * parseInt($("#detailHargaSatuanBarang").val());
                    $("#detailSubtotalBarang").val(val);
                    $('#detailBarang').prop('disabled', false);
                    $('#detailKuantitasBarang').prop('disabled', false);
                    $('#detailHargaSatuanBarang').prop('disabled', false);
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
                    url: "sale-detail/" + dataId,
                    type: 'DELETE',
                    success: function (data) {
                        setTimeout(function () {
                            var oTable = $('#table').DataTable();
                            oTable.draw(false);
                        });
                        $.ajax({
                            url: 'sale/' + ddPurchaseId,
                            type: 'GET',
                            success: function(response){
                                $('.modal-title').text('Rincian Penjualan');
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
        $('.modal-title').text('Rincian Penjualan');
    });

    $('#editDetailModal').on('hide.bs.modal', function() {
        $('.modal-title').text('Rincian Penjualan');
    });

    if ($("#addEditForm").length > 0) {
        $("#addEditForm").validate({
            rules: {},
            submitHandler: function (form) {
                var userId = $('#id').val();
                $('.modal-title').text('Rincian Penjualan');

                if($('#action').val() == 'Add') {
                    action_url = "{{ route('sale.store') }}";
                    swal_title = "Berhasil!";
                    swal_text = "Data berhasil ditambahkan!";
                    swal_fail_title = "Data gagal ditambahkan!";
                }

                if($('#action').val() == 'Edit') {
                    action_url = "{{ route('sale.update') }}";
                    swal_title = "Berhasil!";
                    swal_text = "Data berhasil diperbarui!";
                    swal_fail_title = "Data gagal diperbarui!";
                }

                if($('#action').val() == 'AddDetail') {
                    action_url = "{{ route('sale-detail.store') }}";
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
                        $('#chooseModal').modal('hide');
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
                                url: 'sale/' + userId,
                                type: 'GET',
                                success: function(response){
                                    $('.showModal').html(response);
                                }
                            });

                            $('.modal-title').text('Rincian Penjualan');
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
                var userId = $('#id').val();
                $('.modal-title').text('Rincian Penjualan');
                $('#editDetailButton').html('Processing..');

                $.ajax({
                    data: $('#editDetailForm').serialize(),
                    url: "{{ route('sale-detail.update') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#editDetailForm').trigger("reset");
                        $('#editDetailModal').modal('hide');
                        $('#editDetailButton').html('Edit');
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
                            url: 'sale/' + userId,
                            type: 'GET',
                            success: function(response){
                                $('.showModal').html(response);
                            }
                        });

                        $('.modal-title').text('Rincian Penjualan');
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
            output += '<label for="servis" class="col-sm-12 control-label">Servis</label>';
            output += '<div class="col-sm-12 input-group w-100"><select class="form-control servis" id="servis'+count+'" name="servis[]" required></select><div class="input-group-append">'+button+'</div></div>'
            output += '</div>';
            output += '<div class="form-group">';
            output += '<label for="kuantitas" class="col-sm-12 control-label">Kuantitas</label>';
            output += '<div class="col-sm-12"><input type="number" class="form-control input'+count+' kuantitasServis" id="kuantitasServis'+count+'" name="kuantitas_servis[]" placeholder="Contoh: 5" required></div>'
            output += '</div>';
            output += '<div class="form-group">';
            output += '<label for="harga_satuan" class="col-sm-12 control-label">Harga Satuan</label>';
            output += '<div class="col-sm-12 input-group w-100"><div class="input-group-prepend"><span class="input-group-text">Rp</span></div><input type="number" class="form-control input'+count+' harga_satuan_servis" id="harga_satuan_servis'+count+'" name="harga_satuan_servis[]" placeholder="Contoh: 50.000" required><div class="input-group-append"><span class="input-group-text">,00</span></div></div>'
            output += '</div>';
            output += '<div class="form-group">';
            output += '<label for="subtotal" class="col-sm-12 control-label">Subtotal</label>';
            output += '<div class="col-sm-12 input-group w-100"><div class="input-group-prepend"><span class="input-group-text">Rp</span></div><input type="number" class="form-control subtotalServis" id="subtotalServis'+count+'" name="subtotal_servis[]" placeholder="0" readonly required><div class="input-group-append"><span class="input-group-text">,00</span></div></div>'
            output += '</div>';
            output += '<hr class="mt-3 mb-3 bg-dark">'
            output += '<div class="form-group">';
            output += '<label for="barang" class="col-sm-12 control-label">Barang</label>';
            output += '<div class="col-sm-12 input-group w-100"><select class="form-control barang" id="barang'+count+'" name="barang[]" required></select></div>'
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
            output += '<div class="col-sm-12 input-group w-100"><div class="input-group-prepend"><span class="input-group-text">Rp</span></div><input type="number" class="form-control subtotal" id="subtotal'+count+'" name="subtotal[]" placeholder="0" readonly required><div class="input-group-append"><span class="input-group-text">,00</span></div></div>'
            output += '</div>';
            output += '<hr class="mt-3 mb-3 bg-dark">'
        output += '</div>';
        $('#detailFields').append(output);

        $(".input" + count).on("keyup", function(){
            var val = parseInt($("#kuantitas" + count).val()) * parseInt($("#harga_satuan" + count).val());
            $("#subtotal" + count).val(val);

            var val2 = parseInt($("#kuantitasServis" + count).val()) * parseInt($("#harga_satuan_servis" + count).val());
            $("#subtotalServis" + count).val(val2);

            var val3 = parseInt($("#totalBarang").val()) + parseInt($("#totalServis").val());
            $("#total").val(val3);
        });

        $(".input" + count).on("change", function(){
            var val = parseInt($("#kuantitas" + count).val()) * parseInt($("#harga_satuan" + count).val());
            $("#subtotal" + count).val(val);

            var val2 = parseInt($("#kuantitasServis" + count).val()) * parseInt($("#harga_satuan_servis" + count).val());
            $("#subtotalServis" + count).val(val2);

            var val3 = parseInt($("#totalBarang").val()) + parseInt($("#totalServis").val());
            $("#total").val(val3);
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

        $("#servis" + count).change(function(){
            var id = $('#servis' + count).val();
            $.ajax({
                url :"purchase/"+ id +"/getServisById",
                dataType:"json",
                beforeSend: function()
                {
                    $('#kuantitasServis' + count).prop('disabled', true);
                    $('#harga_satuan_servis' + count).prop('disabled', true);
                },
                success: function(data)
                {
                    $('#harga_satuan_servis' + count).val(data.harga);
                    var val = parseInt($("#kuantitasServis" + count).val()) * parseInt($("#harga_satuan_servis" + count).val());
                    $("#subtotalServis" + count).val(val);
                    $('#kuantitasServis' + count).prop('disabled', false);
                    $('#harga_satuan_servis' + count).prop('disabled', false);
                },
            });
        });

        $(".kuantitas").keyup(function(){
            var total = 0;
            $('.subtotal').each(function() {
                total = total + parseInt($(this).val());
            });
            $("#totalBarang").val(total);
        });

        $(".kuantitasServis").keyup(function(){
            var totalServis = 0;
            $('.subtotalServis').each(function() {
                totalServis = totalServis + parseInt($(this).val());
            });
            $("#totalServis").val(totalServis);
        });

        $(".harga_satuan").keyup(function(){
            var total = 0;
            $('.subtotal').each(function() {
                total = total + parseInt($(this).val());
            });
            $("#totalBarang").val(total);
        });

        $(".harga_satuan_servis").keyup(function(){
            var totalServis = 0;
            $('.subtotalServis').each(function() {
                totalServis = totalServis + parseInt($(this).val());
            });
            $("#totalServis").val(totalServis);
        });

        $(".kuantitas").change(function(){
            var total = 0;
            $('.subtotal').each(function() {
                total = total + parseInt($(this).val());
            });
            $("#totalBarang").val(total);
        });

        $(".kuantitasServis").change(function(){
            var totalServis = 0;
            $('.subtotalServis').each(function() {
                totalServis = totalServis + parseInt($(this).val());
            });
            $("#totalServis").val(totalServis);
        });

        $(".harga_satuan").change(function(){
            var total = 0;
            $('.subtotal').each(function() {
                total = total + parseInt($(this).val());
            });
            $("#totalBarang").val(total);
        });

        $(".harga_satuan_servis").change(function(){
            var totalServis = 0;
            $('.subtotalServis').each(function() {
                totalServis = totalServis + parseInt($(this).val());
            });
            $("#totalServis").val(totalServis);
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
                $('#servis' + count).prop('disabled', true);
                $('#kuantitas' + count).prop('disabled', true);
                $('#harga_satuan' + count).prop('disabled', true);
                $('#kuantitasServis' + count).prop('disabled', true);
                $('#harga_satuan_servis' + count).prop('disabled', true);
            },
            success: function(data){
                var html = '<option value="" disabled selected>Pilih Barang</option>';
                var i;
                for (i = 0; i < data.length; i++) {
                    html += '<option value='+data[i].id+'>'+data[i].nama+'</option>';
                }
                $('#barang' + count).html(html);
                $('#barang' + count).prop('disabled', false);
                $('#servis' + count).prop('disabled', false);
                $('#kuantitas' + count).prop('disabled', false);
                $('#harga_satuan' + count).prop('disabled', false);
                $('#kuantitasServis' + count).prop('disabled', false);
                $('#harga_satuan_servis' + count).prop('disabled', false);
            }
        });

        $.ajax({
            url: "{{ route('purchase.getServis') }}",
            type: "POST",
            dataType: "json",
            beforeSend: function()
            {
                $('#barang' + count).prop('disabled', true);
                $('#servis' + count).prop('disabled', true);
                $('#kuantitas' + count).prop('disabled', true);
                $('#harga_satuan' + count).prop('disabled', true);
                $('#kuantitasServis' + count).prop('disabled', true);
                $('#harga_satuan_servis' + count).prop('disabled', true);
            },
            success: function(data){
                var html = '<option value="" disabled selected>Pilih Servis</option>';
                var i;
                for (i = 0; i < data.length; i++) {
                    html += '<option value='+data[i].id+'>'+data[i].nama+'</option>';
                }
                $('#servis' + count).html(html);
                $('#barang' + count).prop('disabled', false);
                $('#servis' + count).prop('disabled', false);
                $('#kuantitas' + count).prop('disabled', false);
                $('#harga_satuan' + count).prop('disabled', false);
                $('#kuantitasServis' + count).prop('disabled', false);
                $('#harga_satuan_servis' + count).prop('disabled', false);
            }
        });
    });

    $(document).on('click', '.remove', function(){
        var row_id = $(this).attr("id");
        $('#row'+row_id).remove();
    });

    var count = 1;
    function add_dynamic_input_field_servis(count)
    {
        var button_servis = '';
        if(count > 1) {
            button_servis = '<button type="button" name="remove_servis" id="'+count+'" class="btn btn-danger btn-xs remove_servis">x</button>';
        } else {
            button_servis = '<button type="button" name="add_more_servis" id="add_more_servis" class="btn btn-success btn-xs ml-auto">+</button>';
        }

        output = '<div id="row'+count+'">';
            output += '<div class="form-group">';
            output += '<label for="servis" class="col-sm-12 control-label">Servis</label>';
            output += '<div class="col-sm-12 input-group w-100"><select class="form-control servis" id="servis'+count+'" name="servis[]" required></select><div class="input-group-append">'+button_servis+'</div></div>'
            output += '</div>';
            output += '<div class="form-group">';
            output += '<label for="kuantitas" class="col-sm-12 control-label">Kuantitas</label>';
            output += '<div class="col-sm-12"><input type="number" class="form-control input'+count+' kuantitasServis" id="kuantitasServis'+count+'" name="kuantitas_servis[]" placeholder="Contoh: 5" required></div>'
            output += '</div>';
            output += '<div class="form-group">';
            output += '<label for="harga_satuan" class="col-sm-12 control-label">Harga Satuan</label>';
            output += '<div class="col-sm-12 input-group w-100"><div class="input-group-prepend"><span class="input-group-text">Rp</span></div><input type="number" class="form-control input'+count+' harga_satuan_servis" id="harga_satuan_servis'+count+'" name="harga_satuan_servis[]" placeholder="Contoh: 50.000" required><div class="input-group-append"><span class="input-group-text">,00</span></div></div>'
            output += '</div>';
            output += '<div class="form-group">';
            output += '<label for="subtotal" class="col-sm-12 control-label">Subtotal</label>';
            output += '<div class="col-sm-12 input-group w-100"><div class="input-group-prepend"><span class="input-group-text">Rp</span></div><input type="number" class="form-control subtotalServis" id="subtotalServis'+count+'" name="subtotal_servis[]" placeholder="0" readonly required><div class="input-group-append"><span class="input-group-text">,00</span></div></div>'
            output += '</div>';
            output += '<hr class="mt-3 mb-3 bg-dark">'
        output += '</div>';
        $('#detailFields').append(output);

        $(".input" + count).on("keyup", function(){
            var val2 = parseInt($("#kuantitasServis" + count).val()) * parseInt($("#harga_satuan_servis" + count).val());
            $("#subtotalServis" + count).val(val2);
        });

        $(".input" + count).on("change", function(){
            var val2 = parseInt($("#kuantitasServis" + count).val()) * parseInt($("#harga_satuan_servis" + count).val());
            $("#subtotalServis" + count).val(val2);
        });

        $("#servis" + count).change(function(){
            var id = $('#servis' + count).val();
            $.ajax({
                url :"purchase/"+ id +"/getServisById",
                dataType:"json",
                beforeSend: function()
                {
                    $('#servis' + count).prop('disabled', true);
                    $('#kuantitasServis' + count).prop('disabled', true);
                    $('#harga_satuan_servis' + count).prop('disabled', true);
                },
                success: function(data)
                {
                    $('#servis' + count).prop('disabled', false);
                    $('#harga_satuan_servis' + count).val(data.harga);
                    var val = parseInt($("#kuantitasServis" + count).val()) * parseInt($("#harga_satuan_servis" + count).val());
                    $("#subtotalServis" + count).val(val);
                    $('#kuantitasServis' + count).prop('disabled', false);
                    $('#harga_satuan_servis' + count).prop('disabled', false);
                },
            });
        });

        $(".kuantitasServis").keyup(function(){
            var totalServis = 0;
            $('.subtotalServis').each(function() {
                totalServis = totalServis + parseInt($(this).val());
            });
            $("#totalServis").val(totalServis);
        });

        $(".harga_satuan_servis").keyup(function(){
            var totalServis = 0;
            $('.subtotalServis').each(function() {
                totalServis = totalServis + parseInt($(this).val());
            });
            $("#totalServis").val(totalServis);
        });

        $(".kuantitasServis").change(function(){
            var totalServis = 0;
            $('.subtotalServis').each(function() {
                totalServis = totalServis + parseInt($(this).val());
            });
            $("#totalServis").val(totalServis);
        });

        $(".harga_satuan_servis").change(function(){
            var totalServis = 0;
            $('.subtotalServis').each(function() {
                totalServis = totalServis + parseInt($(this).val());
            });
            $("#totalServis").val(totalServis);
        });
    }

    $(document).on('click', '#add_more_servis', function(){
        count = count + 1;
        add_dynamic_input_field_servis(count);

        $.ajax({
            url: "{{ route('purchase.getServis') }}",
            type: "POST",
            dataType: "json",
            beforeSend: function()
            {
                $('#servis' + count).prop('disabled', true);
                $('#kuantitasServis' + count).prop('disabled', true);
                $('#harga_satuan_servis' + count).prop('disabled', true);
            },
            success: function(data){
                var html = '<option value="" disabled selected>Pilih Servis</option>';
                var i;
                for (i = 0; i < data.length; i++) {
                    html += '<option value='+data[i].id+'>'+data[i].nama+'</option>';
                }
                $('#servis' + count).html(html);
                $('#servis' + count).prop('disabled', false);
                $('#kuantitasServis' + count).prop('disabled', false);
                $('#harga_satuan_servis' + count).prop('disabled', false);
            }
        });
    });

    $(document).on('click', '.remove_servis', function(){
        var row_id = $(this).attr("id");
        $('#row'+row_id).remove();
    });

    var count = 1;
    function add_dynamic_input_field_barang(count)
    {
        var button_barang = '';
        if(count > 1) {
            button_barang = '<button type="button" name="remove_barang" id="'+count+'" class="btn btn-danger btn-xs remove_barang">x</button>';
        } else {
            button_barang = '<button type="button" name="add_more_barang" id="add_more_barang" class="btn btn-success btn-xs ml-auto">+</button>';
        }

        output = '<div id="row'+count+'">';
            output += '<div class="form-group">';
            output += '<label for="barang" class="col-sm-12 control-label">Barang</label>';
            output += '<div class="col-sm-12 input-group w-100"><select class="form-control barang" id="barang'+count+'" name="barang[]" required></select><div class="input-group-append">'+button_barang+'</div></div>'
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
            output += '<div class="col-sm-12 input-group w-100"><div class="input-group-prepend"><span class="input-group-text">Rp</span></div><input type="number" class="form-control subtotal" id="subtotal'+count+'" name="subtotal[]" placeholder="0" readonly required><div class="input-group-append"><span class="input-group-text">,00</span></div></div>'
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
                    $('#barang' + count).prop('disabled', true);
                    $('#kuantitas' + count).prop('disabled', true);
                    $('#harga_satuan' + count).prop('disabled', true);
                },
                success: function(data)
                {
                    $('#barang' + count).prop('disabled', false);
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
            $("#totalBarang").val(total);
        });

        $(".harga_satuan").keyup(function(){
            var total = 0;
            $('.subtotal').each(function() {
                total = total + parseInt($(this).val());
            });
            $("#totalBarang").val(total);
        });

        $(".kuantitas").change(function(){
            var total = 0;
            $('.subtotal').each(function() {
                total = total + parseInt($(this).val());
            });
            $("#totalBarang").val(total);
        });

        $(".harga_satuan").change(function(){
            var total = 0;
            $('.subtotal').each(function() {
                total = total + parseInt($(this).val());
            });
            $("#totalBarang").val(total);
        });
    }

    $(document).on('click', '#add_more_barang', function(){
        count = count + 1;
        add_dynamic_input_field_barang(count);

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

    $(document).on('click', '.remove_barang', function(){
        var row_id = $(this).attr("id");
        $('#row'+row_id).remove();
    });
});
</script>
