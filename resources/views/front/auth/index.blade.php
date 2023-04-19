@extends('front.layouts.user')
@section('css')
@endsection
@section('body')
    {{--blog--}}
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="address_bar">
                    <ul>
                        <li>
                            <a href="{{route('front.index')}}">Anasayfa </a> /
                        </li>

                        <li>
                            Giriş yap veya kaydol
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <section class="container">
        <div class="row">
            <div class="col-md-5 mx-auto mb-5">
                <div class="auth_box py-5 px-5">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-login-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-login" type="button" role="tab" aria-controls="nav-login"
                                    aria-selected="true">Giriş yap
                            </button>
                            <button class="nav-link" id="nav-register-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-register" type="button" role="tab" aria-controls="nav-register"
                                    aria-selected="false">Üye Ol
                            </button>

                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-login" role="tabpanel"
                             aria-labelledby="nav-login-tab">
                            <form method="post" action="{{route('front.custom-login')}}" id="login-form" class="login_box mt-3" novalidate="novalidate">
                                {{csrf_field()}}

                                <input type="text" name="email" class="{{$errors->has('email')?'error_input':''}}" placeholder="E-posta adresi veya Telefon numarası" required="">
                                @if(isset($err))<span class="error_text">{{$err[0]}}</span>@endif
                                @if($errors->has('email'))
                                    @foreach($errors->get('email') as $error)
                                        <span class="error_text">{{$error}}</span>
                                    @endforeach
                                @endif

                                <input type="password" name="password" class="{{$errors->has('password')?'error_input':''}}" placeholder="Şifre" required="">
                                @if(isset($err))<span class="error_text">{{$err[1]}}</span>@endif
                                @if($errors->has('password'))
                                    @foreach($errors->get('password') as $error)
                                        <span class="error_text">{{$error}}</span>
                                    @endforeach
                                @endif
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link text-start p_u py-4" href="{{ route('password.request') }}">
                                        Parolanızı mı unuttunuz?
                                    </a>
                                @endif

                                <div>
                                    <input class="form-check-input" type="checkbox" name="remember"
                                           id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        Beni Unutma
                                    </label>
                                </div>

                                <button type="submit" class="btn btn-digi btn-large">
                                    <span>oturum aç</span>
                                    <i class="fas fa-sign-in-alt"></i>
                                </button>

                            </form>
                        </div>
                        <div class="tab-pane fade" id="nav-register" role="tabpanel" aria-labelledby="nav-register-tab">
                            <form action="{{route('register')}}" id="register" method="POST" name="registration"
                                  class="login_box mt-3" novalidate="novalidate">
                                {{csrf_field()}}
                                {{--<h2 class="mt-5 text-center">Hesap oluştur</h2>--}}

                                            <input name="first_name" placeholder="isim" required="" type="text" value="{{old('first_name')}}">

                                            <input name="last_name" required="" placeholder="Soyadı" type="text" value="{{old('last_name')}}">

                                            <input type="email" dir="ltr" name="email" value="{{old('email')}}" placeholder="E-posta adresi">
                                            
                                            <input type="text" dir="ltr" name="mobile" value="{{old('mobile')}}" placeholder="Telefon numarası">

                                            <input id="password" dir="ltr" required="" name="password" minlength="8" placeholder="Parola"
                                                   type="password"
                                                   autocomplete="new-password">

                                            <input id="password_confirmation" required="" name="password_confirmation" dir="ltr" minlength="8" placeholder="Şifreyi tekrar girin" type="password" autocomplete="new-password" equalto="#password">

                                            <small class="d-block mt-5">
                                                Kayıt, sitenin <a href="#">kurallarını</a>  kabul etmek içindir.
                                            </small>

                                            <button type="submit" class="btn btn-digi btn-large">
                                                <span>Kayıt ol</span>
                                                <i class="fas fa-user-plus"></i>
                                            </button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')

@endsection