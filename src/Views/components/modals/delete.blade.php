<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirm Deletion</h4>
            </div>
            <div class="modal-body">
                <p class="m-b-0">Are you sure you would like to delete this resource?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form id="confirm-delete" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger">Confirm</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('.delete').click(function(e) {
            e.preventDefault();
            $('form#confirm-delete').attr('action', this.href);
        });

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
