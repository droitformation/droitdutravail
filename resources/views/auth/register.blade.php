@extends('layouts.auth')
@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">Inscription</div>
        <div class="panel-body">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> {{ trans('message.problem') }}<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="form-horizontal" role="form" method="POST" action="/auth/register">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    <label class="col-md-4 control-label">Prénom</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Nom</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">E-Mail</label>
                    <div class="col-md-6">
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Mot de passe</label>
                    <div class="col-md-6">
                        <input type="password" class="form-control" name="password">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Confirmation du mot de passe</label>
                    <div class="col-md-6">
                        <input type="password" class="form-control" name="password_confirmation">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            Register
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
