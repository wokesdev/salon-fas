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
            dom: 'lBfrtip',
            // lengthMenu: [
            //     [ 10, 25, 50, -1 ],
            //     [ '10 rows', '25 rows', '50 rows', 'Show all' ]
            // ],
            // buttons: ['copy', 'csv', 'excel', 'pdf', 'print', ],
            buttons: [
                {
                    extend: 'copy',
                    footer: true,
                },
                {
                    extend: 'csv',
                    footer: true,
                },
                {
                    extend: 'excel',
                    footer: true,
                },
                {
                    extend: 'pdf',
                    footer: true,
                },
                {
                    extend: 'print',
                    footer: true,
                },
                // 'pageLength'
            ],
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('sale-report.index') }}",
                data: { from_date: from_date, to_date: to_date }
            },
            columns: [
                { data: 'tanggal', name: 'tanggal' },
                { data: 'nomor_penjualan', name: 'nomor_penjualan' },
                { data: 'customer.kode_pelanggan', name: 'customer.kode_pelanggan' },
                { data: 'customer.nama', name: 'customer.nama' },
                { data: 'keterangan', name: 'keterangan' },
                { defaultContent: 'IDR' },
                { data: 'total', render: $.fn.dataTable.render.number('.', ',', 0, 'Rp', ',-') },
            ],
            order: [
                [0, 'asc']
            ],

            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };

                total = api
                    .column( 6, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                $( api.column( 6 ).footer() ).html( 'Rp' + new Intl.NumberFormat().format(total) + ',-' );
             },
        });
    }
});
</script>
