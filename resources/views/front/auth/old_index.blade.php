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

    <section class="container-fluid px-md-4 px-2 mb-70-md mt-3 auth-page">
        <div>
            <div class="card">

                <div class="row">


                    <div class="col-md-6 ">
                        {{--<a class="mobile-only text-blue" href="#register">اگر حساب کاربری ندارید برای ثبت‌نام اینجا کلیک--}}
                        {{--کنید</a>--}}
                        <form method="post" action="{{route('login')}}" id="login-form" class="login_box my-5"
                              novalidate="novalidate">
                            {{csrf_field()}}
                            <h2 class="text-center mt-5">Hesaba giriş yap</h2>
                            <table class="mx-auto mt-5">
                                <tr>
                                    <td>
                                        <label>Email Giriş</label>
                                    </td>
                                    <td>
                                        <input type="email" name="email" required="">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Parola</label>
                                    </td>
                                    <td>
                                        <input type="password" name="password" required="">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        @if (Route::has('password.request'))
                                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                                Parolanızı mı unuttunuz?
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input class="form-check-input" type="checkbox" name="remember"
                                               id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">
                                            Beni Unutma
                                        </label>
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-digi btn-large">
                                            <span>oturum aç</span>
                                            <i class="fas fa-sign-in-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            </table>


                            <div class="d-flex align-items-center justify-content-end mt-5">

                            </div>
                        </form>
                    </div>


                    <div class="col-md-6 col-sm-12">
                        <form action="{{route('register')}}" id="register" method="POST" name="registration"
                              class="register_box my-5" novalidate="novalidate">
                            {{csrf_field()}}
                            <h2 class="mt-5 text-center">Hesap oluştur</h2>
                            <table class="mx-auto mt-5">
                                <tr>
                                    <td>
                                        <label>isim <span class="text-danger">*</span></label>
                                    </td>
                                    <td>
                                        <input name="first_name" required="" type="text" value="{{old('first_name')}}">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Soyadı <span class="text-danger">*</span></label>
                                    </td>
                                    <td>
                                        <input name="last_name" required="" type="text" value="{{old('last_name')}}">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label> telefon numarası <span class="text-danger">*</span></label>
                                    </td>
                                    <td>
                                        <input type="text" required="" dir="ltr" value="{{old('mobile')}}" maxlength="11"
                                               minlength="11" name="mobile">
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label>E</label>
                                    </td>
                                    <td>
                                        <input type="email" dir="ltr" name="email" value="{{old('email')}}">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Adres <span class="text-danger">*</span></label>
                                    </td>
                                    <td>
                                        <input name="address" required="" type="text" data-rule-persianonly="true"
                                               value="{{old('address')}}">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Parola <span class="text-danger">*</span></label>
                                    </td>
                                    <td>
                                        <input id="password" dir="ltr" required="" name="password" minlength="8"
                                               type="password"
                                               autocomplete="new-password">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Şifreyi tekrar girin <span class="text-danger">*</span></label>
                                    </td>
                                    <td>
                                        <input id="password_confirmation" required="" name="password_confirmation" dir="ltr" minlength="8" type="password" autocomplete="new-password" equalto="#password">
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <small class="d-block mt-5">
                                            Kayıt, sitenin <a href="#">kurallarını</a>  kabul etmek içindir.
                                        </small>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-center">
                                        <button type="submit" class="btn btn-digi btn-large">
                                            <span>Kayıt ol</span>
                                            <i class="fas fa-user-plus"></i>
                                        </button>
                                    </td>

                                </tr>
                            </table>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')

@endsection