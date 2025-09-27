@extends('layouts/front')
@section('content')
<div id="corps">
    <div class="row page">
        <div class="register-box" style="width: 90%;">



            <div class="register-box-body">
                <p class="login-box-msg">انشاء حساب جديد</p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group has-feedback" style="direction: ltr;">

                                <span class="glyphicon glyphicon-user form-control-feedback"
                                    style="right: auto;"></span>
                                <input type="text" class="form-control" style="padding-left: 30.5px;"
                                    name="first_name_fr" value="{{ old('first_name_fr') }}" placeholder="Prénom">
                                <input type="hidden" name="authenticite">
                                @error('first_name_fr')
                                <span class="help-block" style="color: #dd4b39;">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group has-feedback">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                    placeholder="الاسم الشخصي">
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                @error('name')
                                <span class="help-block" style="color: #dd4b39;">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                        </div>

                    </div>


                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group has-feedback" style="direction: ltr;">

                                <span class="glyphicon glyphicon-user form-control-feedback"
                                    style="right: auto;"></span>
                                <input type="text" class="form-control" style="padding-left: 30.5px;"
                                    name="last_name_fr" value="{{ old('last_name_fr') }}" placeholder="Nom">

                                @error('last_name_fr')
                                <span class="help-block" style="color: #dd4b39;">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-feedback">
                                <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}"
                                    placeholder="الاسم العائلي">
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                @error('last_name')
                                <span class="help-block" style="color: #dd4b39;">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group has-feedback" id="rent_number_container"
                                {{(old('type_subscriber') == '2') ? 'style=display:none' : ''}}>
                                <input type="text" class="form-control" name="rent_number"
                                    value="{{ old('rent_number') }}" placeholder="رقم التأجير">
                                <span class="fa fa-address-card-o form-control-feedback"></span>
                                @error('rent_number')
                                <span class="help-block" style="color: #dd4b39;">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group has-feedback" id="pension_number_container"
                                @if(old('type_subscriber'))
                                {{(old('type_subscriber') == '1') ? 'style=display:none' : ''}} @else
                                {{'style=display:none'}} @endif>
                                <input type="text" class="form-control" name="pension_number"
                                    value="{{ old('pension_number') }}" placeholder="رقم المعاش">
                                <span class="fa fa-address-card-o form-control-feedback"></span>
                                @error('pension_number')
                                <span class="help-block" style="color: #dd4b39;">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div style="margin-right: 25px;">
                                <div class="radio ">
                                    <label>
                                        <input type="radio" name="type_subscriber" value="1" @if(old('type_subscriber'))
                                            {{(old('type_subscriber') == '1') ? 'checked' : ''}} @else {{'checked'}}
                                            @endif class="input_radio"> في
                                        الخدمة
                                    </label>
                                    <label>
                                        <input type="radio" name="type_subscriber" value="2"
                                            {{(old('type_subscriber') == '2') ? 'checked' : ''}} class="input_radio">
                                        متقاعد أو من ذوي
                                        الحقوق
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-feedback">
                                <input type="text" class="form-control" name="cin" value="{{ old('cin') }}"
                                    placeholder="رقم البطاقة الوطنية">
                                <span class="fa fa-address-card-o form-control-feedback"></span>
                                @error('cin')
                                <span class="help-block" style="color: #dd4b39;">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group has-feedback">
                                <input type="text" class="form-control" name="birth_date"
                                    data-inputmask="'alias': 'dd/mm/yyyy'" data-mask placeholder="تاريخ الازدياد"
                                    value="{{ old('birth_date') }}">
                                <span class="fa fa-calendar form-control-feedback"></span>
                                @error('birth_date')
                                <span class="help-block" style="color: #dd4b39;">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group has-feedback">
                                <input type="text" class="form-control" name="birth_place"
                                    value="{{ old('birth_place') }}" placeholder="مكان الازدياد">
                                <span class="fa fa-map-pin form-control-feedback"></span>
                                @error('birth_place')
                                <span class="help-block" style="color: #dd4b39;">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6">

                            <div class="form-group has-feedback">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                    placeholder="البريد الاكتروني">
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                @error('email')
                                <span class="help-block" style="color: #dd4b39;">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>


                    <div class="row">


                        <div class="col-md-6">
                            <div class="form-group has-feedback">
                                <input type="password" name="password_confirmation" class="form-control"
                                    placeholder="تأكيد كلمة المرور">
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group has-feedback">
                                <input type="password" class="form-control" name="password" placeholder="كلمة المرور">
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                @error('password')
                                <span class="help-block" style="color: #dd4b39;">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox icheck hidden">
                                <label>
                                    <div class="icheckbox_square-blue checked" style="position: relative;">
                                        <input type="checkbox" checked=""
                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                            class="iCheck-helper"
                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                    </div> <a href="#"></a>
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">تسجيل</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <a href="/login" class="text-center">لدي حساب</a>
            </div>
            <!-- /.login-box-body -->
        </div>
    </div>
</div>


@stop