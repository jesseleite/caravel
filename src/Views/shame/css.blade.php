{{-- Yeck! Get these styles into a proper CSS file! --}}
<style>
    body {
        margin: 50px 0;
    }
    .page-header {
        margin-bottom: 30px;
        margin-left: 16px;
    }
    .nav {
        margin-bottom: 30px;
    }
    .logout {
        color: #ccc;
    }
    .logout:hover {
        color: #7a7a7a;
    }
    .version {
        color: #ccc;
    }
    th.actions,
    td.actions {
        text-align: right;
        white-space: nowrap;
    }
    td.actions > a {
        /*margin-bottom: 7px; Fix this when collapsed for small screens. */
    }
    .help-block {
        color: #ccc;
    }
    #confirm-delete {
        display: inline-block;
    }
    input[type=file] {
        display: block;
    }
    .has-error {
        color: rgb(217, 83, 79);
    }
    .has-error .help-block {
        color: rgb(217, 83, 79);
    }
    .has-error input,
    .has-error textarea,
    .has-error input:focus {
        border-color: rgb(217, 83, 79) !important;
    }
    .pagination {
        margin: 0;
    }
    .list-toolbar {
        padding: 0.5rem .75rem;
    }
    .list-toolbar input, button {
        padding: 0.5rem .75rem !important;
    }
</style>
