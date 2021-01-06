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
                    footer: true
                },
                {
                    extend: 'csv',
                    footer: true
                },
                {
                    extend: 'excel',
                    footer: true
                },
                {
                    extend: 'pdf',
                    footer: true
                },
                {
                    extend: 'print',
                    footer: true
                },
                // 'pageLength'
            ],
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('income-statement.index') }}",
                data: { from_date: from_date, to_date: to_date }
            },
            columns: [
                { data: 'general_entry.tanggal', name: 'general_entry.tanggal' },
                { data: 'altered_pendapatan', name: 'altered_pendapatan' },
                { data: 'sumKredit', name: 'sumKredit', render: $.fn.dataTable.render.number('.', ',', 0, 'Rp', ',-') },
                { data: 'altered_beban', name: 'altered_beban' },
                { data: 'sumDebit', name: 'sumDebit', render: $.fn.dataTable.render.number('.', ',', 0, 'Rp', ',-') },
            ],
            order: [
                [0, 'asc']
            ],
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };

                // Total over all pages
                // total = api
                //     .column( 5 )
                //     .data()
                //     .reduce( function (a, b) {
                //         return intVal(a) + intVal(b);
                //     }, 0 );

                totalPendapatan = api
                    .column( 2, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                totalBeban = api
                     .column( 4, { page: 'current'} )
                     .data()
                     .reduce( function (a, b) {
                         return intVal(a) + intVal(b);
                     }, 0 );

                if (totalPendapatan !== null && totalBeban !== null) {
                    $( api.column( 1 ).footer() ).html( 'Rp' + new Intl.NumberFormat().format(totalPendapatan) + ',- <br>(pendapatan)' );
                    $( api.column( 2 ).footer() ).html( 'Rp' + new Intl.NumberFormat().format(totalBeban) + ',- <br>(beban)' );

                    if (totalPendapatan > totalBeban) {
                        $( api.column( 4 ).footer() ).html( 'Rp' + new Intl.NumberFormat().format(totalPendapatan - totalBeban) + ',-' );
                    } else if (totalPendapatan < totalBeban) {
                        $( api.column( 4 ).footer() ).html( '(Rp' + new Intl.NumberFormat().format(totalBeban - totalPendapatan) + ',-)' );
                    } else {
                        $( api.column( 4 ).footer() ).html( 'Rp' + new Intl.NumberFormat().format(0) + ',-' );
                    }
                }

                //  $('tr:eq(0) th:eq(1)', api.table().footer()).html(
                //     'Rp' + new Intl.NumberFormat().format(totalDebit) + ',-'
                //  );

                //  $('tr:eq(0) th:eq(2)', api.table().footer()).html(
                //     'Rp' + new Intl.NumberFormat().format(totalKredit) + ',-'
                //  );

                //  $('tr:eq(1) th:eq(1)', api.table().footer()).html(
                //     'Rp' + new Intl.NumberFormat().format(totalDebit - totalKredit) + ',-'
                //  );
            },
        });
    }
});
</script>
