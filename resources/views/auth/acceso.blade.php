@extends('layouts/auth_template')

@section('content')

    <form action="{{ route('acceder') }}" method="POST">

        {{ csrf_field() }}

        <div class="form-log-cont">

            <div class="form-log-header">
                <img src="{{ asset('storage/log-logo.svg')}}" alt="">
            </div>

            <div class="form-log-body">
                <input type="email" name="email" id="email" placeholder="Email" class="{{ $errors->has('email') ? 'error' : '' }}" value="{{ old('email') }}">
                {!! $errors->first('email', '<span class="help-block"><b>:message</b></span>') !!}
                <input type="password" name="password" id="password" placeholder="Contraseña" class="{{ $errors->has('password') ? 'error' : '' }}">
                {!! $errors->first('password', '<span class="help-block"><b>:message</b></span>') !!}
            </div>

            <div class="form-log-footer">
                <button type="submit" class="btn btn-light form-log-btn">Acceder</button>
            </div>

            <div class="spacer" style="background-color:#2E5097; width:100%;"></div>
            <div class="form-reg">
                <a href="{{ route('registro') }}">Registrate</a>
            </div>

        </div>
    </form>

@endsection
