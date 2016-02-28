<!-- Delete Modal -->
<div id="modal-delete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirm Deletion</h4>
            </div>
            <div class="modal-body">
                <p class="m-b-0">Are you sure you would like to delete this resource?</p>
            </div>
            <div class="modal-footer">
                {!! BootForm::open()->delete() !!}
                    {!! BootForm::button('Cancel')->addClass('btn-secondary')->attribute('data-dismiss', 'modal') !!}
                    {!! BootForm::submit('Confirm')->addClass('btn-danger') !!}
                {!! BootForm::close() !!}
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('a[data-target="#modal-delete"]').click(function(e) {
                e.preventDefault();
                $('#modal-delete form').attr('action', this.href);
            });
        });
    </script>
@endpush
