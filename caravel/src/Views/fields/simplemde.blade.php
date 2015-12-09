{!! $bootForm->textarea($field->label, $field)
             ->helpBlock($field->help) !!}

{{-- Please sir, why CDN? Load these locally, as needed. Somehow. Pls. --}}
<link rel="stylesheet" href="//cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="//cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
<script>
    var simplemde = new SimpleMDE({ element: $('#{{ $field }}')[0] });

    $(function() {

        // If validation error, hide simplemde's statusbar.
        $('.has-error .editor-statusbar').remove();

        // If validation error, fix simplemde's styling to match Bootstrap validation state styling.
        var originalColour         = $('.has-error .CodeMirror-wrap').css('border-color');
        var errorColour            = $('.has-error .help-block').css('border-color');
        var toolbarBorderColour    = errorColour + ' ' + errorColour + ' ' + originalColour + ' ' + errorColour;
        var bottomBorderColour     = originalColour + ' ' + errorColour + ' ' + errorColour + ' ' + errorColour;
        var originalToolbarOpacity = $('.has-error .editor-toolbar').css('opacity');
        $('.has-error .editor-toolbar').css('border-color', toolbarBorderColour);
        $('.has-error .CodeMirror-wrap').css('border-color', bottomBorderColour);
        $('.has-error .editor-toolbar').css('opacity', '1');
        $('.has-error .editor-toolbar').children().css('opacity', originalToolbarOpacity);

    });
</script>
