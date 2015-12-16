@if (session()->get('success'))
    <!-- Alert -->
    <div id="success" class="row">
        <div class="col-md-12">
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        </div>
    </div>
@endif

@section('scripts')
    @parent
    <script>
        $(document).ready(function() {
            if ($('#success')) {
                setTimeout(function() {
                    $('#success').fadeOut("normal", function() {
                        $(this).remove();
                    });
                }, 4000);

                $('#success').click(function() {
                    $(this).remove();
                });
            }
        });
    </script>
@endsection
