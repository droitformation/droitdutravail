@if( isset($errors) && $errors->has() || Session::has('status'))

<div class="row">
    <div class="col-md-12">
        <div class="alert alert-dismissable alert-{{ Session::get('status') }} {{ ($errors->has() ? 'alert-danger' : '') }}">

            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            @foreach($errors->all() as $message)
            <p>{!! $message !!}</p>
            @endforeach

            @if(Session::has('message'))
            {!! Session::get('message') !!}
            @endif

        </div>
    </div>
</div>

@endif

<div class="row" id="messageAlert">
    <div class="col-md-12">
        <div class="alert alert-dismissable">
            <p></p>
        </div>
    </div>
</div>
