@extends('caravel::master')

@section('container')
    @if (session()->get('success'))
        <div id="success" class="row">
            <div class="col-md-12">
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <table id="caravel-list-resource" class="table">
                <thead>
                    <tr>
                        @foreach ($fields as $field)
                            <th>{{ $field->label }}</th>
                        @endforeach
                        <th class="actions">
                            <a href="{{ $baseUri }}/create" class="btn btn-sm btn-primary-outline pull-right"><i class="fa fa-file-o"></i></a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            @foreach ($fields as $field)
                                <td>{{ str_limit($item->$field, 25) }}</td>
                            @endforeach
                            <td class="actions">
                                <a href="{{ $baseUri }}/{{ $item->id }}/edit" class="btn btn-warning-outline btn-sm" role="button"><i class="fa fa-pencil"></i></a>
                                <a href="{{ $baseUri }}/{{ $item->id }}" class="btn btn-danger-outline btn-sm delete" role="button" data-toggle="modal" data-target=".bd-example-modal-sm"><i class="fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                  Are you sure you would like to delete this resource?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <form id="confirm-delete" method="post">
                  {{ csrf_field() }}
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="btn btn-danger">Confirm Delete</button>
              </form>
            </div>
        </div>
      </div>
    </div>
@endsection

@section('scripts')
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

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.10/vue.min.js"></script>
    <script>
        new Vue({
            el: '#caravel-list-resource',
            ready: function() {
                console.log('list loaded');
            }
        });
    </script> --}}
@endsection
