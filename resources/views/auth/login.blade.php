@extends('auth.master')

@section('content')
  @if (is_incevio_package_loaded('otp-login'))
    @include('otp-login::admin_login')
  @else
    <div class="box">
      <div class="login-section">
        <div class="form-container">
          <div class="image-holder"></div>
          <div class="login-form-section">
            <div class="login-logo">
              <a href="{{ url('/') }}">
                <img src="{{ get_logo_url('system', 'full') }}" class="brand-logo" height="47px" alt="{{ trans('theme.logo') }}" title="{{ trans('theme.logo') }}">
              </a>
            </div>

            <div class="form-section">
              <h3 class="text-center mt-0">{{ trans('app.login') }}</h3>

              {!! Form::open(['route' => 'login', 'id' => 'form', 'data-toggle' => 'validator']) !!}
              <div class="form-group has-feedback">
                {!! Form::email('email', null, ['id' => 'email', 'class' => 'form-control input-lg', 'placeholder' => trans('app.form.email_address'), 'required']) !!}
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                <div class="help-block with-errors"></div>
              </div>

              <div class="form-group has-feedback">
                {!! Form::password('password', ['id' => 'password', 'class' => 'form-control input-lg', 'id' => 'password', 'placeholder' => trans('app.form.password'), 'data-minlength' => '6', 'required']) !!}
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                <div class="help-block with-errors"></div>
              </div>

              <div class="row">
                <div class="col-xs-7">
                  <div class="form-group">
                    <label>
                      {!! Form::checkbox('remember', null, null, ['class' => 'icheck']) !!} {{ trans('app.form.remember_me') }}
                    </label>
                  </div>
                </div>

                <div class="col-xs-5 pull-right">
                  {!! Form::submit(trans('app.form.login'), ['class' => 'btn btn-block btn-lg btn-flat btn-primary']) !!}
                </div>
              </div>

              {!! Form::close() !!}

              <div class="spacer20"></div>

              @if (!is_incevio_package_loaded('otp-login'))
                <a class="btn btn-link" href="{{ route('password.request') }}">{{ trans('app.form.forgot_password') }}</a>
              @endif

              <a class="btn btn-link" href="{{ route('vendor.register') }}" class="text-center">{{ trans('app.form.register_as_merchant') }}</a>
            </div>
            @include('partials._demo_admin_login')
          </div>
        </div>
      </div>
    </div>
  @endif
@endsection
