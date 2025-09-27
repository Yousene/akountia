@extends('layouts/front')
@section('content')
<div id="corps">
    <div class="row page">
        <div class="login-box">

            @if(session('success'))
            <br>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                {{session('success')}}
            </div>
            @endif

            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">المرجو تسجيل الدخول</p>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group has-feedback ">
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                            placeholder="البريد الالكتروني">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

                        @error('email')
                        <span class="help-block" style="color: #dd4b39;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="كلمة المرور" name="password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                        @error('password')
                        <span class="help-block" style="color: #dd4b39;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-flat">تسجيل االدخول</button>
                </form>
            </div>
            <!-- /.login-box-body -->
        </div>
    </div>
</div>
@stop