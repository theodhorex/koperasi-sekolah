@extends('layouts.auth-master')

@section('content')
    <form class="bg-light py-4 px-4 rounded-3" method="post" action="{{ route('login.perform') }}">
        
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <img class="mb-2" src="{!! url('images/bootstrap-logo.svg') !!}" alt="" width="72" height="57">
        
        <h3 class="mb-3 fw-semibold">Login</h3>

        @include('layouts.partials.messages')

        <div class="form-group form-floating mb-3">
            <input type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Username" required="required" autofocus>
            <label for="floatingName">Email or Username</label>
            @if ($errors->has('username'))
                <span class="text-danger text-left">{{ $errors->first('username') }}</span>
            @endif
        </div>
        
        <div class="form-group form-floating mb-3">
            <input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password" required="required">
            <label for="floatingPassword">Password</label>
            @if ($errors->has('password'))
                <span class="text-danger text-left">{{ $errors->first('password') }}</span>
            @endif
        </div>

        <div class="form-group mb-3 float-start">
            <input type="checkbox" name="remember" value="1">
            <label class="fw-semibold" for="remember">Remember me</label>
        </div>

        <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>
        
        <!-- @include('auth.partials.copy') -->
    </form>
@endsection
