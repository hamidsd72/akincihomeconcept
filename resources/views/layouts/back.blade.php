@include('panel.particle.header')
<div class="app">
    <style>
        .archive-menu-container ul li a{
            position: relative;
        }
        .badge-counter{
            position: absolute;
            right: 20px;
            width: 18px;
            text-align: center;
            border-radius: 50%;
            color: #fff;
            background: #f95858;
        }
    </style>
    <div class="main mt-4">
        <div class="view-content container" data-direction="ltr">

            <div class="row">
                <aside class="col-md-3">
                    <div class="card mb-4" style="margin-top:20px">
                        <div class="card-body archive-card-title">
                            <i class="fa fa-tv ml-2"></i>
                            @role('مدیر')
                            Yönetici paneline hoş geldiniz
                            @endrole
                            @role('مدیریت انبار')
                            Yönetici paneline hoş geldiniz
                            @endrole
                            @role('کاربر')
                            Kullanıcı paneline hoş geldiniz
                            @endrole
                        </div>
                    </div>
                    <div class="archive-menu-container mb-4">
                        <ul class="nav nav-pills nav-stacked">
                            @role('مدیر')
                                        @endrole
                            @role('مدیر')
                            <li>
                                <label>Sipariş listesi</label>
                                    <ul class="nav nav-pills nav-stacked">
                                        {{--<li>--}}
                                            {{--<a href="{{ route('basket-reserv-list') }}">Rezerve edilen siparişlerin listesi--}}
                                            {{--@if($reserv_count>0)<span class="badge-counter">{{$reserv_count}}</span>@endif--}}
                                            {{--</a>--}}
                                        {{--</li>--}}
                                        <li>
                                            <a href="{{ route('dashboard-create-factor') }}">Eklemek</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('basket-list') }}"> Sipariş listesi
                                            @if($factor_count>0)<span class="badge-counter">{{$factor_count}}</span>@endif
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('draft-list') }}">Depo havaleleri
                                            @if($draft_count>0)<span class="badge-counter">{{$draft_count}}</span>@endif
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <label>Müşteri yönetimi</label>
                                        <li>
                                            <a href="{{ route('dashboard-user-create') }}">Eklemek</a>
                                        </li>
                                    </ul>
                                </li>    
                                <li>
                                    <label>içerik yönetimi</label>
                                    <ul class="nav nav-pills nav-stacked">
                                        <li>
                                            <a href="{{ route('category-list') }}">ürün kategorizasyonu</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('brand-list') }}">Markaların listesi</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('product-list') }}">ürün listesi</a>
                                        </li>
                                        {{--<li>--}}
                                            {{--<a href="{{ route('product-vip-list') }}">Özel satışları etkinleştirin / devre dışı bırakın</a>--}}
                                        {{--</li>--}}
                                        {{--<li>--}}
                                            {{--<a href="{{ route('inventory-list') }}">Ürün envanteri</a>--}}
                                        {{--</li>--}}
                                        {{--<li>--}}
                                            {{--<a href="{{ route('inventory-archive-list') }}">Ürün Arşivi</a>--}}
                                        {{--</li>--}}
                                        <li>
                                            <a href="{{ route('slider-list') }}">Kaydırıcıların listesi</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('banner-list') }}">Afiş listesi</a>
                                        </li>
                                        {{--<li>--}}
                                            {{--<a href="{{ route('projects-list') }}">Projelerin listesi</a>--}}
                                        {{--</li>--}}

                                        <li>
                                            <a href="{{ route('article-list') }}">Web Sitesi Makaleleri</a>
                                        </li>

                                        {{--<li>--}}
                                            {{--<a href="{{ route('footer-list') }}">Dinamik sayfalar</a>--}}
                                        {{--</li>--}}
                                        <li>
                                            <a href="{{ route('admin-about') }}">Hakkımızda</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin-page_info') }}">Ev Bilgileri</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin-infocontact') }}">Bize ulaşın sayfası</a>
                                        </li>
                                        {{--<li>--}}
                                            {{--<a href="{{ route('comment-list') }}">Ürün Yorumları--}}
                                            {{--@if($comment_count>0)<span class="badge-counter">{{$comment_count}}</span>@endif--}}
                                            {{--</a>--}}
                                        {{--</li>--}}

                                        <li>
                                            <a href="{{ route('contact-list') }}">Kişi listesi</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('meta-list') }}">SEO ayarları</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('upload-list') }}">dosya yükleme</a>
                                        </li>

                                    </ul>
                                </li>
                            @endrole

                            @role('مدیر')
                            {{--<li>--}}
                                {{--<label>site yönetimi</label>--}}
                                {{--<ul class="nav nav-pills nav-stacked">--}}

                                    {{--<li>--}}
                                        {{--<a href="{{ route('visitlogs') }}">İzleyici listesi</a>--}}
                                    {{--</li>--}}
                                    {{--<li>--}}
                                        {{--<a href="{{ route('settings-list') }}">Ayarlar listesi</a>--}}
                                    {{--</li>--}}
                                {{--</ul>--}}
                            {{--</li>--}}
                            @endrole
                            @role('کاربر')
                                <li>
                                    <label>Siparişler</label>
                                    <ul class="nav nav-pills nav-stacked">
                                        <li>
                                            <a href="{{ route('order-list') }}">Sipariş listesi</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <label>Kullanıcı bilgilerim</label>
                                    <ul class="nav nav-pills nav-stacked">
                                        <li>
                                            <a href="{{ route('address-list') }}">Adres listesi</a>
                                        </li>
                                        <li>
                                            <a href="{{route('front.favorites.list')}}">Favorilerim</a>
                                        </li>
                                    </ul>
                                </li>
                            @endrole
                        </ul>
                    </div>
                </aside>
                <section class="view col-md-9 mt-4">
                    @include ('panel.messages.list')
                    @yield('body')
                </section>
            </div>


        </div>

    </div>
</div>
@include('panel.particle.footer')
