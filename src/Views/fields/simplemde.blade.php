{!! $bootForm->textarea($field->label, $field)
             ->helpBlock($field->help) !!}

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="//cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
@endsection

@section('scripts')
    @parent
    <script src="//cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <script>
        var simplemde = new SimpleMDE({
            element: $('#{{ $field }}')[0],
            renderingConfig: {
                singleLineBreaks: true
            },
            hideIcons: ["guide", "image"]
                // - Implement custom hideIcons options soon?
                // - Build guide off of shown icons only?
                // - Show guide in modal?
                // - Implement helper for image insertion?
        });

        $(document).ready(function() {
            $('.has-error .editor-statusbar').remove();
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
@endsection
