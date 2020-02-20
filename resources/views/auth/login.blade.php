@extends('layouts.app')

@section('login')

<div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card-group mb-0">
          <div class="card p-4">
            <form method="post" class="form-horizontal was-validated" action="{{ url('login') }}">
                @csrf
                <div class="card-body">
                  <h1>Inicio</h1>
                  <p class="text-muted">Control de acceso al sistema</p>

                  <div class="form-group mb-3 {{ $errors->has('user' ? 'is-invalid' : '')}}">
                    <div class="input-group-prepend">
                    <span class="input-group-text">
                      
                    </span>
                  </div>
                    <input type="text" name="user" id="user" class="form-control" placeholder="Usuario" value="{{ old('user') }}"></span>
                    {!! $errors->first('user','<span class="invalid-feedback">:message</span>') !!}

                  </div>
                  <div class="form-group mb-4 {{ $errors->has('password' ? 'is-invalid' : '')}}">
                    
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                     {!! $errors->first('password','<span class="invalid-feedback">:message</span>') !!}
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <button type="submit" class="btn btn-primary px-4"><i class="icon-lock-open"></i>&nbsp;&nbsp;Entrar</button>
                    </div>
                    <div class="col-6 text-right">
                      <!--<button type="button" class="btn btn-link px-0">Olvidaste tu password?</button>-->
                    </div>
                  </div>
                </div>
            </form>
          </div>
          <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
            <div class="card-body text-center">
              <div>
                <img src="{{ asset('img/jm.png') }}" width="300px" height="100px">
                
                <a href="http://www.jonaymedina.com.ve" target="_blank" class="btn btn-primary active mt-3">Visite nuestro sitio web</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
