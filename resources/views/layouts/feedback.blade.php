@if ($errors->any())
<div class="alert alert-danger">
    <h4>Error!</h4>
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


@if (\Session::has('status'))

<div class="alert alert-success">
    <strong>Success!</strong> {{ Session::get('status') }}
</div>

@endif



@if (\Session::has('error'))

<div class="alert alert-danger">
    <strong>Error!</strong> {{ Session::get('error') }}
</div>

@endif