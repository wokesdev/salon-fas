<script>
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });

    load_data();

    $('.input-daterange').datepicker({
        todayBtn: 'linked',
        format: 'yyyy-mm-dd',
        autoclose: true
    });

    $('#filter').click(function () {
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        if (from_date != '' && to_date != '') {
            $('#table').DataTable().destroy();
            load_data(from_date, to_date);
        } else {
            swal({
                title: "Filter tanggal gagal!",
                text: "Pastikan kedua range tanggal sudah dipilih!",
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
    });

    $('#refresh').click(function () {
        $('#from_date').val('');
        $('#to_date').val('');
        $('#table').DataTable().destroy();
        load_data();
    });

    function load_data(from_date = '', to_date = '') {
        $('#table').DataTable({
            dom: 'Bfrtip',
            lengthMenu: [
                [ 10, 25, 50, -1 ],
                [ '10 rows', '25 rows', '50 rows', 'Show all' ]
            ],
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print', ],
            buttons: [
                {
                    extend: 'copy',
                    messageTop: 'Jurnal Umum'
                },
                {
                    extend: 'csv',
                    messageTop: 'Jurnal Umum'
                },
                {
                    extend: 'excel',
                    messageTop: 'Jurnal Umum'
                },
                {
                    extend: 'pdf',
                    messageTop: 'Jurnal Umum'
                },
                {
                    extend: 'print',
                    messageTop: 'Jurnal Umum'
                },
                'pageLength'
            ],
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('general-entry.index') }}",
                data: { from_date: from_date, to_date: to_date }
            },
            columns: [
                { data: 'general_entry.tanggal', name: 'general_entry.tanggal' },
                { data: 'account_detail.nama_rincian_akun', name: 'account_detail.nama_rincian_akun' },
                { data: 'account_detail.nomor_rincian_akun', name: 'account_detail.nomor_rincian_akun' },
                { data: 'debit', render: $.fn.dataTable.render.number('.', ',', 2, 'Rp') },
                { data: 'kredit', render: $.fn.dataTable.render.number('.', ',', 2, 'Rp') },
            ],
            order: [
                [0, 'asc']
            ],
        });
    }
});
</script>
