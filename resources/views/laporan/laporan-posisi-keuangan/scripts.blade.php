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

        $('#from_date_pdf').val(from_date);
        $('#to_date_pdf').val(to_date);

        if (from_date != '' && to_date != '') {
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

    $('#makePDF').click(function () {
        swal({
            title: "Berhasil!",
            text: "Silakan tunggu hingga PDF selesai di-download!",
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
        });
    });

    $('#refresh').click(function () {
        $('#from_date').val('');
        $('#to_date').val('');
        $('#from_date_pdf').val('');
        $('#to_date_pdf').val('');
        load_data();
    });

    function load_data(from_date = '', to_date = '') {
        $.ajax({
            url: "{{ route('statement-of-financial-position.getData') }}",
            data: { from_date: from_date, to_date: to_date },
            success: function(response){
                $('tbody').html(response);
            }
        });
    }


});
</script>
