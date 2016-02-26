{{-- <div class="row m-t-2 m-b-1">
    <div class="col-lg-12">
        <h4></h4>
    </div>
</div> --}}
<div class="row">
    <div class="col-lg-12">
        @foreach ($fields as $field)
            @field($field->name)
        @endforeach
    </div>
</div>
