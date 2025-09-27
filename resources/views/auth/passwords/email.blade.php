@extends('layouts/front')
@section('content')
<div id="corps">
    <div class="row page">
        <div class="login-box">

            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">أدخل البريد الإلكتروني لإعادة تعيين كلمة المرور</p>


                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="form-group has-feedback ">
                        <input type="email" class="form-control" name="email" value="" placeholder="البريد الإلكتروني">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        @error('email')
                        <span class="help-block" style="color: #dd4b39;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary pull-right">
                                <i class="fa fa-btn fa-envelope"></i> إرسال رابط إعادة تعيين كلمة السر
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