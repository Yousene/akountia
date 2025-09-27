@extends('layouts/front')
@section('content')
<div id="corps">
    <div class="row page">
        <div class="register-box">

            <!-- /.login-logo -->


            <div class="login-box-body">
                <p class="login-box-msg">اعد ضبط كلمه السر</p>

                <form method="post" action="http://moltamassi.ma/password/reset">
                    <input type="hidden" name="_token" value="ZUDw24Irq1Oxwxomm7erILPdpa2BDg4Q0rC4fxOO">

                    <input type="hidden" name="token"
                        value="186843695c550a1b96dca918a3ed1cfff6c92e305cd2afa441d24a85f56a1404">

                    <div class="form-group has-feedback ">
                        <input type="email" class="form-control" name="email" value="" placeholder="Email">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" name="password" placeholder="كلمه السر">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                    </div>

                    <div class="form-group has-feedback">
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="تأكيد كلمة المرور">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>

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