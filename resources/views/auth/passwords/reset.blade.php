@extends('layouts/front')
@section('content')
<div id="corps">
    <div class="row page">
        <div class="login-box">

            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">اعد ضبط كلمه السر</p>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group has-feedback ">
                        <input type="email" class="form-control" name="email" value="" placeholder="البريد الالكتروني">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        @error('email')
                        <span class="help-block" style="color: #dd4b39;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" name="password" placeholder="كلمه السر">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        @error('password')
                        <span class="help-block" style="color: #dd4b39;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group has-feedback">
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="تأكيد كلمة المرور">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        @error('password_confirmation')
                        <span class="help-block" style="color: #dd4b39;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary pull-right">
                                <i class="fa fa-btn fa-refresh"></i>إعادة تعيين كلمة المرور
                            </button>
                        </div>
                    </div>
                </form>

            </div>
            <!-- /.login-box-body -->
        </div>
    </div>
</div>
@stop