@extends('web::layouts.app')

@section('content')
    <div>
        <div class="account-pages"></div>
        <div class="clearfix"></div>
        <div class="wrapper-page">
            <div class="card-box">
                <div class="panel-heading">
                    <h4 class="text-center" style="color: black;">TAISHODO VIETNAM</strong></h4>
                    <img class="logo" src="{{asset('img/logobig.png')}}" alt="logo" width="50" height="50" style="margin-left: 164px;">
                </div>

                <div class="p-20">
                    <form class="form-horizontal m-t-20" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group ">
                            <div class="col-12">
                                <label for='userCode'>Tên đăng nhập / Username / ユーザー</label>
                                <input id="userCode" type="userCode" class="form-control{{ $errors->has('userCode') ? ' is-invalid' : '' }}"
                                       name="userCode" required autofocus>
                                @if ($errors->has('userCode'))
                                    <span class="invalid-feedback">
                                    <strong>{{ $errors->first('userCode') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <label for='userCode'>Mật khẩu / Password / パースワード</label>
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group text-center m-t-40">
                            @include('web::error.node')
                            <div class="col-6" style='margin: 0 auto;'>
                                <button class="btn btn-pink btn-block text-uppercase waves-effect waves-light" type="submit">
                                    Login
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

