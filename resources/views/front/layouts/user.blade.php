<!DOCTYPE html>
<html lang="fa-IR" dir="rtl">
<head>
    <title>{{$titleSeo}}</title>
    <meta name="base_url" content="{{route('front.index')}}">
    <meta name="description" content="{{$descriptionSeo}}"/>
    <meta name="keywords" content="{{$keywordsSeo}}">
    <link rel="canonical" href="{{$url}}"/>
    <meta property="og:locale" content="fa_IR"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="{{$titleSeo}}"/>
    <meta property="og:description" content="{{$descriptionSeo}}"/>
    <meta property="og:url" content="{{$url}}"/>
    <meta property="og:image" content="{{url('source/assets/front/img/akinci_fave.png')}}"/>
    <meta property="og:site_name" content="ofis"/>
    <link rel="Shortcut Icon" type="image/x-icon" href="{{url('source/assets/front/img/akinci_fave.png')}}"/>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="Shortcut Icon" type="image/x-icon" href="{{url('source/assets/front/img/akinci_fave.png')}}"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"
          integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w=="
          crossorigin="anonymous"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/js/all.min.js"
            integrity="sha512-UwcC/iaz5ziHX7V6LjSKaXgCuRRqbTp1QHpbOJ4l1nw2/boCfZ2KlFIqBUA/uRVF0onbREnY9do8rM/uT/ilqw=="
            crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.5/swiper-bundle.css">
{{--    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>--}}

    <link rel="stylesheet" href="{{asset('source/assets/front/chosen/css.css')}}">
    <link href="{{asset('source/assets/front/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('source/assets/front/css/new.css')}}" rel="stylesheet">
{{--    <link href="{{asset('source/assets/front/css/responsive.css')}}" rel="stylesheet">--}}
@yield('css')

<!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-K3YVDTL0NG"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'G-K3YVDTL0NG');
    </script>
    <!-- Facebook Pixel Code -->
    <script>
        !function (f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function () {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '4443008699059727');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=4443008699059727&ev=PageView&noscript=1"
        /></noscript>
    <!-- End Facebook Pixel Code -->

    <meta name="p:domain_verify" content="d10cf647fbec89724566c1be45aeb741"/>
    <style>


    </style>
</head>
<body>
<div class="bg_all_nav_open">

</div>
<div class="wat_sapp wat_sapp1">
    <a target="_blank" rel="noopener" href="https://api.whatsapp.com/send?phone=+905557323399">
        <img class="social_img" src="{{url('source/assets/front/img/what.png')}}" alt="sedar2020">
        <p>çevrimiçi destek</p>
    </a>
</div>
{{-- <div class="top_heder d-none d-sm-block">
    <div class="container-xxl ">
        <div class="row ">
            <div class="col-md-6">
                <ul>
                    <li>
                        <a href="#">TOUCH İÇ MİMARLIK HİZMETİ</a>
                    </li>
                    <li>
                        <a href="#">SHOWROOM</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-6">
                <ul class="float-end">
                    <li>
                        <a href="#"><i class="fas fa-volume"></i> KAMPANYALAR</a>
                    </li>
                    <li>
                        <a href="#"><i class="far fa-volume"></i> En Yeniler</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-volume"></i> DESTEK MERKEZİ</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div> --}}
<header class="desktop_menu">
    <div class="header_top">
        <div class="container-xxl ">
            <div class="row py-3">
                <div class="col-md-3  d-none d-md-block">
                    <div class="search_box">
                        <form autocomplete="off" id="frm_get1" action="{{route('front.search')}}" method="get">
                            <div class="autocomplete">
                                <input class="" id="myInput1" name="search" type="search"
                                       placeholder="Evin için ne arıyorsun?" required=""
                                       oninvalid="this.setCustomValidity('Ne arıyorsun ???')"
                                       oninput="setCustomValidity('')">
                                <input class="" id="myInput1_1" name="type" type="text" hidden>
                                <input class="" id="myInput1_2" name="val" type="text" hidden>
                                <button type="submit" aria-label="search"><i class="fa fa-search"></i></button>

                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-6 col-4">
                    <a class="navbar-brand" href="{{route('front.index')}}">
                        <div class="logo_box mx-auto" aria-label="index_page">
                            <img src="{{url('source/assets/front/img/logo.png')}}" class="w-100" alt="">
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-8">
                    <ul class="login_box1 float-end">
                        <li>

                            <a href="{{route('front.level_1')}}">
                                <div class="bas_box d_i_f">
                                    sepetim
                                    <span class="cont_bas">{{$basket_count}}</span>
                                    <i class="fa fa-shopping-basket" aria-hidden="true"></i>

                                </div>
                            </a>
                        </li>
                        <li>

                            <a href="{{route('front.favorites.list')}}">
                                <div class="bas_box d_i_f">
                                    Favorilerim
                                    @if($favorites>0)
                                        <span class="cont_bas">{{$favorites}}</span>
                                    @endif
                                    <i class="fa fa-heart"></i>
                                </div>
                            </a>
                        </li>
                        @guest()
                            <li><a href="{{ route('login') }}" class="d_i_f">
                                    Üye Girişi
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                </a>
                            </li>

                        @else
                            <li>
                                <a href="{{route('order-list')}}" class="d_i_f">
                                    Panel
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                </a>
                            </li>
                        @endguest
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <div class="menu">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-xxl p_u">


                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto navbr_menu">
                        {{--<li class="nav-item ">--}}
                        {{--<a class="nav-link " href="{{route('front.products.type','vip')}}">--}}
                        {{--Vip ürünler--}}
                        {{--</a>--}}
                        {{--</li>--}}
                        @foreach($categories as $category)
                            @if(count($category->children)>0)
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle"
                                       href="{{route('front.category',$category->slug)}}" id="navbarDropdown"
                                       role="button"
                                       data-bs-toggle="dropdown" aria-expanded="false">
                                        {{$category->name}}
                                    </a>
                                    <div class="dropdown-menu p_u animate slideIn" aria-labelledby="navbarDropdown">

                                        <div class="container-xxl">
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <div class="item_box">
                                                        <div class="row">
                                                            <?php $ww = cat_child($category->children);?>
                                                            @foreach($ww->chunk(7)  as $childs)
                                                                <ul class="col-md-3">
                                                                    @foreach($childs as $child)
                                                                        <li>
                                                                            <a href="{{route('front.category',$child->slug)}}">{{$child->name}}</a>
                                                                        </li>
                                                                    @endforeach

                                                                </ul>


                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 p_u">
                                                    <div class="item_info">
                                                        <img src="{{$category->menu_pic!=''?url($category->menu_pic):''}}"
                                                             alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @else
                                <li class="nav-item ">
                                    <a class="nav-link " href="{{route('front.category',$category->slug)}}">
                                        {{$category->name}}
                                    </a>
                                    </a>
                                </li>
                            @endif

                        @endforeach
                        {{--<li class="nav-item ">--}}
                        {{--<a class="nav-link " href="{{route('front.products.type','eco')}}">--}}
                        {{--Eco ürünler--}}
                        {{--</a>--}}
                        {{--</li>--}}

                        {{--<li class="nav-item dropdown">--}}
                        {{--<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"--}}
                        {{--data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
                        {{--OFİS MOBİLYALARI--}}
                        {{--</a>--}}
                        {{--<div class="dropdown-menu p_u animate slideIn" aria-labelledby="navbarDropdown">--}}
                        {{--<div class="container-fluid">--}}
                        {{--<div class="row">--}}
                        {{--<div class="col-md-4">--}}
                        {{--<div class="item_box">--}}
                        {{--<h5>OFİS MOBİLYALARI</h5>--}}
                        {{--<ul class="">--}}

                        {{--<li><a>MAKAM MASALARI</a></li>--}}

                        {{--<li><a>ÇALIŞMA MASALARI</a></li>--}}


                        {{--</ul>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-4">--}}
                        {{--<div class="item_box">--}}
                        {{--<h5>OFİS MOBİLYALARI</h5>--}}
                        {{--<ul class="">--}}

                        {{--<li><a>MAKAM MASALARI</a></li>--}}

                        {{--<li><a>ÇALIŞMA MASALARI</a></li>--}}


                        {{--</ul>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-4">--}}
                        {{--<div class="item_box">--}}
                        {{--<h5>OFİS MOBİLYALARI</h5>--}}
                        {{--<ul class="">--}}

                        {{--<li><a>MAKAM MASALARI</a></li>--}}

                        {{--<li><a>ÇALIŞMA MASALARI</a></li>--}}


                        {{--</ul>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-12">--}}
                        {{--<div class="item_info row other_box">--}}
                        {{--<div class="col-md-5">--}}
                        {{--<div class="img_box">--}}
                        {{--<img src="https://www.caliskanofis.com/img/a1.png" alt="">--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-7">--}}
                        {{--<h6>Özel İndirimler</h6>--}}
                        {{--<p class="my-5">--}}
                        {{--500'den fazla ürün çeşidi ile çok özel indirimler hemen--}}
                        {{--indirimli ürünleri görüntüleyip sepetine ekle alışverişin tadını--}}
                        {{--çıkartın.--}}
                        {{--</p>--}}
                        {{--<a href="">Detay</a>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</li>--}}

                    </ul>
                </div>
            </div>
        </nav>
    </div>

</header>
<div id="mySidenav1" style="z-index: 99999">
    <div id="mySidenav" class="sidenav">
        <ul class="login_box2">

            @guest()
                <li>
                    <a href="{{ route('login') }}" class="d_i_f">
                        Üye Girişi
                    </a>
                </li>
                <li>
                    <a href="{{ route('login') }}" class="d_i_f">
                        Üye Ol
                    </a>
                </li>

            @else
                <li>
                    <a href="{{route('dashboard-index')}}" class="d_i_f">
                        Panel
                    </a>
                </li>
                <li>
                    <a href="#" class="d_i_f">
                        çıkış
                    </a>
                </li>
            @endguest
        </ul>
        <br>

        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item ">
                <a class="nav-link " href="{{route('front.products.type','vip')}}">
                    Vip ürünler
                </a>
            </li>
            @foreach($categories as $category)
                @if(count($category->children)>0)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle"
                           href="{{route('front.category',$category->slug)}}" id="navbarDropdown"
                           role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            {{$category->name}}
                        </a>
                        <div class="dropdown-menu p_u animate slideIn" aria-labelledby="navbarDropdown">


                            <ul class="">

                                @foreach($category->children as $child)
                                    <li>
                                        <a href="{{route('front.category',$child->slug)}}">{{$child->name}}</a>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </li>
                @else
                    <li class="nav-item ">
                        <a class="nav-link " href="{{route('front.category',$category->slug)}}">
                            {{$category->name}}
                        </a>
                        </a>
                    </li>
                @endif
            @endforeach
            <li class="nav-item ">
                <a class="nav-link " href="{{route('front.products.type','eco')}}">
                    Eco ürünler
                </a>
            </li>
        </ul>
    </div>
</div>
<header class="mobil_menu" id="mobil_menu">
    <div class="row pt-4 px-4">
        <div class="col-3 pt-3">

            <span onclick="openNav()">

                <i class="fas fa-bars"></i>
            </span>
        </div>
        <div class="col-6">
            <div class="logo_mobil_header">
                <a aria-label="index_page" href="{{route('front.index')}}">
                    <img src="{{url('source/assets/front/img/logo.png')}}" alt="logo">
                </a>
            </div>
        </div>
        <div class="col-3 pt-3 float-end">
            <a href="{{route('front.level_1')}}">
                <div class="bas_box d_i_f float-end">
                    <span class="cont_bas">{{$basket_count}}</span>
                    <i class="fa fa-shopping-basket" aria-hidden="true"></i>

                </div>
            </a>
        </div>
    </div>
    <div class="row px-4 my-3">
        <div class="search_box p_u">
            <form autocomplete="off" id="frm_get2" action="{{route('front.search')}}" method="get">
                <div class="autocomplete">
                    <input class="" id="myInput2" name="search" type="search" placeholder="Keşfetmeye Bak" required=""
                           oninvalid="this.setCustomValidity('Ne arıyorsun ???')" oninput="setCustomValidity('')">
                    <input class="" id="myInput2_2" name="type" type="text" hidden>
                    <input class="" id="myInput2_3" name="val" type="text" hidden>

                    <button type="submit">BUL</button>
                    <i class="fa fa-search"></i>
                </div>
            </form>
        </div>
    </div>
</header>
@yield('body')
<footer class="pt-5">
    <div class="container-xxl">
        <div class="row">
            <div class="col-md-3">
                <div class="row">
                    <div class="col-md-4 d-none">
                        <div class="footer_col">
                            <h2>İçerik Sayfaları</h2>
                            <ul class="list-group list-group-flush list-group-borderless mb-0">

                                <li><a href="{{route('front.hakkımızda')}}">Hakkımızda</a></li>

                                <li><a href="{{route('front.iade_ve_değişim')}}">İade ve Değişim</a></li>

                                <li><a href="{{route('front.kişisel_veriler_politikası')}}"> Kişisel Veriler
                                        Politikası</a></li>

                                <li><a href="{{route('front.satış_sözleşmesi')}}">Satış Sözleşmesi</a></li>


                            </ul>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="footer_col">
                            <h2>Giriş</h2>
                            <ul class="list-group list-group-flush list-group-borderless mb-0">
                                <li><a href="{{route('front.about.us')}}">Hakkımızda</a></li>
                                <li><a href="{{route('front.contact.us')}}">Bize Ulaşın</a></li>
                                <li><a href="{{route('front.favorites.list')}}">Favorilerim</a></li>
                                {{--<li><a href="{{route('front.blogs')}}">nesneF</a></li>--}}
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 d-none">
                        <div class="footer_col">
                            <h2>YARDIM + DESTEK</h2>
                            <ul>
                                <li class="footer-desktek-merkezi-list">
                                    <img src="//cdn.vivense.com/images/icon/vivense-destek-merkezi-icon.svg" alt="akincihomeconcept">
                                    <a href="#">Destek Merkezi</a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="sub_menu_text">0500-------</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" target="_blank">Sipariş Takibi</a>
                                </li>
                                <li>
                                    <a href="#">Üye Girişi Yap</a>
                                </li>

                                <!--
             <li>

                 <a href="mailto:info@vivense.com">
                     <span class="sub_menu_icon write_us_icon"></span>
                     <span class="sub_menu_text">info@vivense.com</span>
                 </a>
             </li>
         -->

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="row">
                    @foreach($categories->chunk(7) as $key=>$category)
                        <div class="col-md-6">
                            <div class="footer_col {{$key>0? 'mt-4':''}}">

                                @if($key==0)<h2>KATEGORİLER</h2>@endif
                                <ul class="list-group list-group-flush list-group-borderless mb-0">
                                    @foreach($category as $category1)
                                        <li><a href="{{route('front.category',$category1->slug)}}">
                                                {{$category1->name}}
                                            </a></li>
                                    @endforeach
                                </ul>
                            </div>

                        </div>
                    @endforeach

                </div>


            </div>

            <div class="col-md-4 text-center description_footer">
                <div class="footer_subscribe_icon_div"></div>
                <h3 class="mt-2">AKİNCİ’NİN RENKLİ DÜNYASINA KATIL!</h3>
                <p>En yeni dekorasyon trendleri, kampanyalar, ve sana özel sürprizler...
                </p>
                <a href="#">HEMEN ÜYE OL</a>
            </div>
        </div>

        <div class="col-12 mb-5 px-5 text-center">

            
            <h2 class="pt-2">Bizi Takip Edin :</h2>
            <ul class="social px-2">
                {{--<li>--}}
                {{--<a href="">--}}
                {{--<i class="fa fa-file-signature"></i>--}}
                {{--</a>--}}
                {{--</li>--}}
                <li class="facebock_color">
                    <a aria-label="index_page" href="#">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                </li>

                <li class="twiter_color">
                    <a aria-label="index_page" href="#">
                        <i class="fab fa-twitter"></i>
                    </a>
                </li>

                <li class="insta_color">
                    <a aria-label="index_page" href="#">
                        <i class="fab fa-instagram"></i>
                    </a>
                </li>

                <li class="youtub_color">
                    <a aria-label="index_page" href="#">
                        <i class="fab fa-youtube-square"></i>
                    </a>
                </li>

                <li class="linkdin_color">
                    <a aria-label="index_page" href="#">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </li>

            </ul>

            {{-- <div class=" float-start mx-5"> --}}

                {{-- <ul class="footer_icon"> --}}
                    {{-- <li>
                        <img src="{{asset('source/assets/img/icon/footer/1.png')}}" alt="">
                    </li>
                    <li>
                        <img src="{{asset('source/assets/img/icon/footer/2.png')}}" alt="">
                    </li> --}}
                    {{-- <li> --}}
                        <div class="text-center">
                            <img src="{{asset('source/assets/img/icon/footer/paynet-icon.png')}}" alt="banner">
                        </div>
                    {{-- </li>
                </ul> --}}

            {{-- </div> --}}
        </div>

    </div>
    <section id="footer" class="main-content">
        <div class="content footer">
            <div class="col-xs-12 align-center">
                
                <p class="footer-text copyright animated" data-animation="fadeInUp" data-animation-delay="100">
                    Copyright © 2022 -
                    <a href="https://adib.com.tr/">ADIB.COM.TR</a>
                </p>
            
            </div>
        </div>
    </section>

</footer>
<script
        src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
        crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.5/swiper-bundle.min.js"></script>
{{--<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>--}}

<script src="{{asset('source/assets/front/chosen/js.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('source/assets/front/js/js.js')}}" type="text/javascript"></script>
<script>

    @if(session()->has('err_message'))
    $(document).ready(function () {
        Swal.fire({
            title: "Başarısız",
            text: "{{ session('err_message') }}",
            icon: "warning",
            timer: 6000,
            timerProgressBar: true,
        })
    });
    @endif
    @if(session()->has('flash_message'))
    $(document).ready(function () {
        Swal.fire({
            title: "Başarılı",
            text: "{{ session('flash_message') }}",
            icon: "success",
            timer: 6000,
            timerProgressBar: true,
        })
    })
    ;@endif
    @if (count($errors) > 0)
    $(document).ready(function () {
        Swal.fire({
            title: "Başarısız",
            icon: "warning",
            html:
            @foreach ($errors->all() as $key => $error)
                '<p class="text-right mt-2 ml-5" dir="rtl"> {{$key+1}} : ' +
            '{{ $error }}' +
            '</p>' +
            @endforeach
                '<p class="text-right mt-2 ml-5" dir="rtl">' +
            '</p>',
            timer: parseInt('{{count($errors)}}') * 1500,
            timerProgressBar: true,
        })
    });
            @endif
    var countries = [
                    @foreach($products as $product)
            ['{{$product->title}}', 'Ürün', '{{$product->slug}}'],
                    @endforeach
                    @foreach($categories_serch as $category)
            ['{{$category->name}}', 'kategoriler', '{{$category->slug}}'],
                    @endforeach
                    @foreach($brands as $brand)
            ['{{$brand->brand}}', 'marka', '{{$brand->brand}}'],
                @endforeach
        ];

    autocomplete(document.getElementById("myInput2"), document.getElementById("myInput2_2"), document.getElementById("myInput2_3"), countries);
    autocomplete(document.getElementById("myInput1"), document.getElementById("myInput1_1"), document.getElementById("myInput1_2"), countries);

</script>
@yield('js')
</body>
</html>

