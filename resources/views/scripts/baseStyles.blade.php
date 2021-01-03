<!-- Fonts and icons -->
<script src="{{ asset('atlantis-assets/js/plugin/webfont/webfont.min.js') }}"></script>
<script>
    WebFont.load({
        google: {"families":["Lato:300,400,700,900"]},
        custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{ asset('atlantis-assets/css/fonts.min.css') }}']},
        active: function() {
            sessionStorage.fonts = true;
        }
    });
</script>

<!-- CSS Files -->
<link rel="stylesheet" href="{{ asset('self-assets/my-login.css') }}">
<link rel="stylesheet" href="{{ asset('self-assets/style.css') }}">
<link rel="stylesheet" href="{{ asset('atlantis-assets/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('atlantis-assets/css/atlantis.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
