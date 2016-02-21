{{-- Yeck! Get these scripts into a proper CSS file! --}}
<script>
    $(document).ready(function() {

        // Bootstrap 4 alpha select height fix.
        if ($('select') && $('input[type=text]')) {
            var inputHeight = $('input[type=text]').outerHeight();
            $('select').css('height', inputHeight);
        }

    });
</script>
