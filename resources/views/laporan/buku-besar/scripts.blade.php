<script>
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });

    $("#chooseModal").modal({
        backdrop: 'static',
        keyboard: false
    });
    $('#chooseModal'). modal('show');
    $('#chooseModal').on('shown.bs.modal', function() {
        $('#rincian_akun').trigger('focus');
    });

    $('.input-daterange').datepicker({
        todayBtn: 'linked',
        format: 'yyyy-mm-dd',
        autoclose: true
    });

    $('#filter').click(function () {
        var rincian_akun = $('#rincian_akun').val();
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        if (from_date != '' && to_date != '') {
            $('#table').DataTable().destroy();
            load_data(rincian_akun, from_date, to_date);
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
        var rincian_akun = $('#rincian_akun').val();
        $('#from_date').val('');
        $('#to_date').val('');
        $('#table').DataTable().destroy();
        load_data(rincian_akun, null, null);
    });

    $('#chooseButton').click(function () {
        var rincian_akun = $('#rincian_akun').val();
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        if (rincian_akun != '' && from_date != '' && to_date != '') {
            $('#table').DataTable().destroy();
            load_data(rincian_akun, from_date, to_date);
            $('#chooseModal').modal('hide');
        } else if (rincian_akun != '') {
            $('#table').DataTable().destroy();
            load_data(rincian_akun, null, null);
            $('#chooseModal').modal('hide');
        } else {
            swal({
                title: "Gagal!",
                text: "Pastikan sudah memilih akun!",
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

    function load_data(rincian_akun = '', from_date = '', to_date = '') {
        if ($)

        var table = $('#table').DataTable({
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
                url: "{{ route('ledger.index') }}",
                data: { rincian_akun: rincian_akun, from_date: from_date, to_date: to_date }
            },
            columns: [
                { data: 'general_entry.tanggal', name: 'general_entry.tanggal' },
                { data: 'account_detail.nomor_rincian_akun', name: 'account_detail.nomor_rincian_akun' },
                { data: 'account_detail.nama_rincian_akun', name: 'account_detail.nama_rincian_akun' },
                { data: 'keterangan', name: 'keterangan' },
                { defaultContent: 'JU' },
                { data: 'debit', render: $.fn.dataTable.render.number('.', ',', 0, 'Rp', ',-') },
                { data: 'kredit', render: $.fn.dataTable.render.number('.', ',', 0, 'Rp', ',-') },
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

                totalDebit = api
                    .column( 5, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                totalKredit = api
                     .column( 6, { page: 'current'} )
                     .data()
                     .reduce( function (a, b) {
                         return intVal(a) + intVal(b);
                     }, 0 );

                if (totalDebit !== null && totalKredit !== null) {
                    $( api.column( 1 ).footer() ).html( 'Rp' + new Intl.NumberFormat().format(totalDebit) + ',- <br>(debit)' );
                    $( api.column( 2 ).footer() ).html( 'Rp' + new Intl.NumberFormat().format(totalKredit) + ',- <br>(kredit)' );

                    if (totalDebit > totalKredit) {
                        $( api.column( 6 ).footer() ).html( 'Rp' + new Intl.NumberFormat().format(totalDebit - totalKredit) + ',- <br>(debit)' );
                    } else if (totalDebit < totalKredit) {
                        $( api.column( 6 ).footer() ).html( 'Rp' + new Intl.NumberFormat().format(totalKredit - totalDebit) + ',- <br>(kredit)' );
                    } else {
                        $( api.column( 6 ).footer() ).html( 'Rp' + new Intl.NumberFormat().format(0) + ',-' );
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
