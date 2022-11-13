@extends('auth.contenido')
@section('login')
    <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="#" class="h1"><b>ARCHIVO CENTRAL</b></a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Control de acceso al sistema</p>
            
                    <form class="form-horizontal was-validated" method="POST" action="{{route('login')}}">
                        {{ csrf_field() }}
                    <div class="input-group mb-3 {{$errors->has('usuario' ? 'is-invalid' : '')}}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="icon-user"></span>
                            </div>
                            </div>
                        <input type="text" value="{{old('usuario')}}" name="usuario" id="usuario" class="form-control" placeholder="Usuario">
                        {!!$errors->first('usuario','<span class="invalid-feedback">:message</span>')!!}
                    </div>
                    <div class="input-group mb-3 {{$errors->has('password' ? 'is-invalid' : '')}}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="icon-lock"></span>
                            </div>
                            </div>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                        {!!$errors->first('password','<span class="invalid-feedback">:message</span>')!!}
                    </div>
                    <div class="row">
                        <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember">
                            <label for="remember">
                            Remember Me
                            </label>
                        </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary px-4">Acceder</button>
                        </div>
                        <!-- /.col -->
                    </div>
                    </form>
            
                    <!-- /.social-auth-links -->
            
                    <p class="mb-1">
                    <a href="forgot-password.html">I forgot my password</a>
                    </p>
                
                </div>
        <!-- /.card-body -->
    </div>
    <!-- /.login-logo -->
    
    <!-- /.card -->

@endsection
