@if ($softDeletes)
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-cogs"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
            <h6 class="dropdown-header">Trashed Items</h6>
            <a class="dropdown-item" href="?trash=with">With Trashed</a>
            <a class="dropdown-item" href="?trash=only">Only Trashed</a>
        </div>
    </div>
@endif
