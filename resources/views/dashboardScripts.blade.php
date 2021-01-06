<script>
    $.ajax({
        url: "{{ route('dashboard-data.supplier') }}",
        type: "GET",
        dataType: "json",
        success: function(data){
            var myCircle = Circles.create({
            id:                  'circles-1',
            radius:              60,
            value:               data,
            maxValue:            100,
            width:               10,
            text:                function(value){return value},
            colors:              ['#D3B6C6', '#483D8B'],
            duration:            400,
            wrpClass:            'circles-wrp',
            textClass:           'circles-text',
            valueStrokeClass:    'circles-valueStroke',
            maxValueStrokeClass: 'circles-maxValueStroke',
            styleWrapper:        true,
            styleText:           true
            });
        }
    });

    $.ajax({
        url: "{{ route('dashboard-data.customer') }}",
        type: "GET",
        dataType: "json",
        success: function(data){
            var myCircle = Circles.create({
            id:                  'circles-2',
            radius:              60,
            value:               data,
            maxValue:            100,
            width:               10,
            text:                function(value){return value},
            colors:              ['#D3B6C6', '#4B253A'],
            duration:            400,
            wrpClass:            'circles-wrp',
            textClass:           'circles-text',
            valueStrokeClass:    'circles-valueStroke',
            maxValueStrokeClass: 'circles-maxValueStroke',
            styleWrapper:        true,
            styleText:           true
            });
        }
    });

    $.ajax({
        url: "{{ route('dashboard-data.purchase') }}",
        type: "GET",
        dataType: "json",
        success: function(data){
            var myCircle = Circles.create({
            id:                  'circles-3',
            radius:              60,
            value:               data,
            maxValue:            100,
            width:               10,
            text:                function(value){return value},
            colors:              ['#D3B6C6', '#FF0000'],
            duration:            400,
            wrpClass:            'circles-wrp',
            textClass:           'circles-text',
            valueStrokeClass:    'circles-valueStroke',
            maxValueStrokeClass: 'circles-maxValueStroke',
            styleWrapper:        true,
            styleText:           true
            });
        }
    });

    $.ajax({
        url: "{{ route('dashboard-data.sale') }}",
        type: "GET",
        dataType: "json",
        success: function(data){
            var myCircle = Circles.create({
            id:                  'circles-4',
            radius:              60,
            value:               data,
            maxValue:            100,
            width:               10,
            text:                function(value){return value},
            colors:              ['#D3B6C6', '#32CD32'],
            duration:            400,
            wrpClass:            'circles-wrp',
            textClass:           'circles-text',
            valueStrokeClass:    'circles-valueStroke',
            maxValueStrokeClass: 'circles-maxValueStroke',
            styleWrapper:        true,
            styleText:           true
            });
        }
    });

    $.ajax({
        url: "{{ route('dashboard-data.cash-payment') }}",
        type: "GET",
        dataType: "json",
        success: function(data){
            var myCircle = Circles.create({
            id:                  'circles-5',
            radius:              60,
            value:               data,
            maxValue:            100,
            width:               10,
            text:                function(value){return value},
            colors:              ['#D3B6C6', '	#FF4500'],
            duration:            400,
            wrpClass:            'circles-wrp',
            textClass:           'circles-text',
            valueStrokeClass:    'circles-valueStroke',
            maxValueStrokeClass: 'circles-maxValueStroke',
            styleWrapper:        true,
            styleText:           true
            });
        }
    });

    $.ajax({
        url: "{{ route('dashboard-data.cash-receipt') }}",
        type: "GET",
        dataType: "json",
        success: function(data){
            var myCircle = Circles.create({
            id:                  'circles-6',
            radius:              60,
            value:               data,
            maxValue:            100,
            width:               10,
            text:                function(value){return value},
            colors:              ['#D3B6C6', '#4682B4'],
            duration:            400,
            wrpClass:            'circles-wrp',
            textClass:           'circles-text',
            valueStrokeClass:    'circles-valueStroke',
            maxValueStrokeClass: 'circles-maxValueStroke',
            styleWrapper:        true,
            styleText:           true
            });
        }
    });
</script>
