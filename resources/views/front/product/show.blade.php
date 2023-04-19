@extends('front.layouts.user')
@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <style>
        .zoomContainer {
            z-index: 5;
        }
        .font_1_75 {
            font-size: 1.75rem;
        }
    </style>
@endsection
@section('body')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="address_bar lorem_address_bar">
                        {{--<span onclick="f()">dssd</span>--}}
                        <ul>
                            <li>
                                <a href="{{route('front.index')}}">Anasayfa </a> /
                            </li>
                            @if($item->category->father)
                                @if($item->category->father->father)

                                    <li>
                                        <a href="{{route('front.category',$item->category->father->father->slug)}}">{{$item->category->father->father->name }}</a> /
                                    </li>
                                @endif

                                <li>
                                    <a href="{{route('front.category',$item->category->father->slug)}}">{{$item->category->father->name}}</a> /
                                </li>
                            @endif
                            <li>
                                <a href="{{route('front.category',$item->category->slug)}}">{{$item->category->name}}</a> /
                            </li>
                            <li>
                                {{$item->title}}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container product_page">
            <div class="row">

                <div class="col-md-8 p_u">
                    <div class="show_product_slider_box lorem_show_product_slider_box">
                        <a id="favorite_link" href="{{route('front.favorites.store',[$item->id,0])}}" class="favorite_link">
                            @if(is_fav($item->id))
                                <i class="fas fa-heart color_red"></i>
                                {{----}}
                            @else
                                <i class="far fa-heart"></i>
                            @endif
                        </a>
                        {{-- <div class="swiper-container pro_gallery pro_gallery_top gallery-top">

                            <div class="swiper-wrapper">

                                @php $i=0;@endphp
                                @if($item->thumbnail!=null)
                                    @php $i++;@endphp
                                    <div class="swiper-slide" data-slide="{{$i}}">

                                        <a href="{{url($item->thumbnail)}}" data-fancybox="images" data-width="2400"
                                           data-height="1600">

                                            <img src="{{url($item->thumbnail)}}" alt="{{$item->name}}">
                                        </a>
                                    </div>
                                @endif
                                @if($item->gallery)
                                    @foreach($item->gallery as $gallery)
                                        @php $i++;@endphp
                                        <div class="swiper-slide" data-slide="{{$i}}">
                                            <a href="{{url($gallery->path)}}"
                                               data-fancybox="images" data-width="2400" data-height="1600">
                                                <img src="{{url($gallery->path)}}"
                                                     alt="">
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                                @if(count($item->models)>0)
                                    @foreach($item->models as $model_p)
                                        @php $i++;@endphp

                                        <div class="swiper-slide" data-slide="{{$i}}">
                                            <a href="{{url($model_p->photo->path)}}"
                                               data-fancybox="images" data-width="2400" data-height="1600">
                                                <img src="{{url($model_p->photo->path)}}"
                                                     alt="">
                                            </a>
                                        </div>
                                        @foreach($model_p->gallery as $model_gallery)
                                            @php $i++;@endphp
                                            <div class="swiper-slide" data-slide="{{$i}}">
                                                <a href="{{url($model_gallery->path)}}"
                                                   data-fancybox="images" data-width="2400" data-height="1600">
                                                    <img src="{{url($model_gallery->path)}}"
                                                         alt="">
                                                </a>
                                            </div>
                                        @endforeach
                                    @endforeach
                                @endif


                            </div>
                            <!-- Add Arrows -->
                            <div class="swiper-button-next swiper-button-white"></div>
                            <div class="swiper-button-prev swiper-button-white"></div>
                        </div>
                        <div class="swiper-container pro_gallery pro_gallery_bottom gallery-thumbs">
                            <div class="swiper-wrapper">
                                @if($item->thumbnail!=null)
                                    <div class="swiper-slide" id="eee">
                                        <img src="{{url($item->thumbnail)}}" alt="">
                                    </div>
                                @endif
                                @if($item->gallery)
                                    @foreach($item->gallery as $gallery)
                                        <div class="swiper-slide">
                                            <img src="{{url($gallery->path)}}"
                                                 alt="{{$item->name}}">
                                        </div>
                                    @endforeach
                                @endif
                                @if(count($item->models)>0)
                                    @foreach($item->models as $model_p)
                                        <div class="swiper-slide">

                                            <img src="{{url($model_p->photo->path)}}"
                                                 alt="">
                                        </div>
                                        @foreach($model_p->gallery as $model_gallery)
                                            <div class="swiper-slide">
                                                <img src="{{url($model_gallery->path)}}"
                                                     alt="">
                                            </div>
                                        @endforeach
                                    @endforeach
                                @endif

                            </div>
                            <!-- Add Arrows -->
                            <div class="swiper-button-next swiper-button-white" id="down" hidden></div>
                            <div class="swiper-button-prev swiper-button-white" id="up" hidden></div>
                            <div class="btn_up"><i class="fas fa-chevron-up"></i></div>
                            <div class="btn_down"><i class="fas fa-chevron-down"></i></div>
                        </div> --}}
                        <div class="lorem_slider">
                            <div class="swiper mySwiper2 swiper-initialized swiper-horizontal swiper-backface-hidden">
                                <div class="swiper-wrapper" id="swiper-wrapper-353eee22196cb124" aria-live="polite">
                                    @php $i = 0; @endphp
                                    {{-- @if($item->thumbnail!=null)
                                        @php $i ++;@endphp
                                        <div class="swiper-slide_new swiper-slide swiper-slide-active" role="group" aria-label="{{$i}} / {{$total}}">
                                            <img src="{{url($item->thumbnail)}}" alt="{{$item->name}}">
                                        </div>
                                    @endif --}}
                                    @if($photoLarge->path!=null)
                                        @php $i ++;@endphp
                                        <div class="swiper-slide_new swiper-slide swiper-slide-active" role="group" aria-label="{{$i}} / {{$total}}">
                                            <img src="{{url($photoLarge->path)}}" alt="{{$item->name}}">
                                        </div>
                                    @endif
                                    @if($item->gallery)
                                        @foreach($item->gallery as $gallery)
                                            @php $i++;@endphp
                                            <div class="swiper-slide_new swiper-slide {{$i == 1 ? 'swiper-slide-active' : ''}} {{$i == 2 ? 'swiper-slide-next' : ''}}" role="group" aria-label="{{$i}} / {{$total}}">
                                                <img src="{{url($gallery->path)}}" alt="banner">
                                            </div>
                                        @endforeach
                                    @endif
                                    @if(count($item->models)>0)
                                        @foreach($item->models as $model_p)
                                            @php $i++;@endphp
                                            <div class="swiper-slide_new swiper-slide {{$i == 1 ? 'swiper-slide-active' : ''}} {{$i == 2 ? 'swiper-slide-next' : ''}}" role="group" aria-label="{{$i}} / {{$total}}">
                                                <img src="{{url($model_p->photo->path)}}" alt="banner">
                                            </div>
                                            @foreach($model_p->gallery as $model_gallery)
                                                @php $i++;@endphp
                                                <div class="swiper-slide_new swiper-slide {{$i == 1 ? 'swiper-slide-active' : ''}} {{$i == 2 ? 'swiper-slide-next' : ''}}" role="group" aria-label="{{$i}} / {{$total}}">
                                                    <img src="{{url($model_gallery->path)}}" alt="banner">
                                                </div>
                                            @endforeach
                                        @endforeach
                                    @endif
                                </div>
                                <div class="swiper-button-next" tabindex="0" role="button" aria-label="Next slide" aria-controls="swiper-wrapper-353eee22196cb124" aria-disabled="false"></div>
                                <div class="swiper-button-prev" tabindex="0" role="button" aria-label="Previous slide" aria-controls="swiper-wrapper-353eee22196cb124" aria-disabled="false"></div>
                            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
    
                            <div class="col-lg-6 mx-auto">
                                <div thumbsslider="" class="swiper mySwiper swiper-initialized swiper-horizontal swiper-free-mode swiper-watch-progress swiper-backface-hidden swiper-thumbs">
                                    <div class="swiper-wrapper" id="swiper-wrapper-4bfc8fcd84bcacab" aria-live="polite">
                                        @php $i = 0; @endphp
                                    {{-- @if($item->thumbnail!=null)
                                        @php $i ++;@endphp
                                        <div class="swiper-slide_new swiper-slide swiper-slide-active" role="group" aria-label="{{$i}} / {{$total}}">
                                            <img src="{{url($item->thumbnail)}}" alt="{{$item->name}}">
                                        </div>
                                    @endif --}}
                                    @if($photoLarge->path!=null)
                                        @php $i ++;@endphp
                                        <div class="swiper-slide_new swiper-slide swiper-slide-active" role="group" aria-label="{{$i}} / {{$total}}">
                                            <img src="{{url($photoLarge->path)}}" alt="{{$item->name}}">
                                        </div>
                                    @endif
                                    @if($item->gallery)
                                        @foreach($item->gallery as $gallery)
                                            @php $i++;@endphp
                                            <div class="swiper-slide_new swiper-slide {{$i == 1 ? 'swiper-slide-active' : ''}} {{$i == 2 ? 'swiper-slide-next' : ''}}" role="group" aria-label="{{$i}} / {{$total}}">
                                                <img src="{{url($gallery->path)}}" alt="banner">
                                            </div>
                                        @endforeach
                                    @endif
                                    @if(count($item->models)>0)
                                        @foreach($item->models as $model_p)
                                            @php $i++;@endphp
                                            <div class="swiper-slide_new swiper-slide {{$i == 1 ? 'swiper-slide-active' : ''}} {{$i == 2 ? 'swiper-slide-next' : ''}}" role="group" aria-label="{{$i}} / {{$total}}">
                                                <img src="{{url($model_p->photo->path)}}" alt="banner">
                                            </div>
                                            @foreach($model_p->gallery as $model_gallery)
                                                @php $i++;@endphp
                                                <div class="swiper-slide_new swiper-slide {{$i == 1 ? 'swiper-slide-active' : ''}} {{$i == 2 ? 'swiper-slide-next' : ''}}" role="group" aria-label="{{$i}} / {{$total}}">
                                                    <img src="{{url($model_gallery->path)}}" alt="banner">
                                                </div>
                                            @endforeach
                                        @endforeach
                                    @endif
                                    </div>
                                    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            @if(count($item->models)>0)

                                <div class="boxs_info mt-5">
                                    <h2>
                                        Ölçü Seçenekleri
                                    </h2>
                                    <div class="body_1 py-3 px-4">

                                     <span class="next_box" data-val="1">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    </span>
                                                                    <span class="prev_box" data-val="1">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    </span>
                                        <!-- Swiper -->
                                        <div class="swiper-container model_slider">

                                            <div class="swiper-wrapper">
                                                @foreach($item->models as $model_p)

                                                    <div class="swiper-slide">
                                                        <a href="{{route('front.product',[$item->slug,$model_p->id])}}">
                                                            <div class="model_item">
                                                                <div class="img_box {{$model_default->id==$model_p->id?'active':''}}">
                                                                    <img src="{{url($model_p->photo->path)}}"
                                                                         alt="">
                                                                </div>
                                                                <div class="name_box">
                                                                    <span>{{$model_p->type_val}}</span>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="swiper-button-next" hidden id="next_1"></div>
                                            <div class="swiper-button-prev" id="prev_1" hidden></div>
                                            {{--<div class="swiper-pagination"></div>--}}
                                        </div>

                                    </div>
                                </div>
                            @endif

                        </div>
                        <div class="col-12">
                            <div class="show_product_info lorem_accordion">
                                <div class="accordion" id="accordionExample">
                                    <div class="accordion-item my-3">
                                        <h2 class="accordion-header" id="heading1">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#description" aria-expanded="true"
                                                    aria-controls="description">
                                                Ürün Açıklaması
                                            </button>
                                        </h2>
                                        <div id="description" class="accordion-collapse collapse show"
                                             aria-labelledby="heading1"
                                             data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                {!! $item->text !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="col-md z_8">
                    <div class="lorem_info p_info sticky-top">
                        <div class="show_product_title_box">
                            <div class="price_info">
                                <div class="lorem_product_name">
                                    {{$item->title}} {{$model_default!=null?$model_default->type_val:''}}
                                </div>
                                @if($item->model_have=='yes' and $model_default!=null)
                                    @if( $model_default->price_vip && $model_default->price_vip > 0)
                                        <div class="offer-text ">
                                            <span class="disc-prc">
                                                %{{ceil(round(((intval($model_default->price)-intval($model_default->price_vip))/intval($model_default->price))*100,1))}}İNDİRİM
                                            </span>
                                        </div>
                                        <div class="price-text">
                                            <span class="old-price">
                                                <del class="del-price">{{number_format(TL($model_default->price))}}
                                                    TL
                                                </del>
                                            </span>
                                            <br>
                                            <span class="new-price discount">{{number_format(TL($model_default->price_vip))}}TL</span>
                                        </div>
                                    @else
                                        <div class="price-text">
                                            <span class="new-price discount">{{number_format(TL($model_default->price))}}TL</span>
                                        </div>
                                    @endif
                                @else
                                    @if( $item->vip_default > 0)
                                        <div class="offer-text ">
                                            <span class="disc-prc">
                                                %{{ceil(round(((intval($item->price_default)-intval($item->vip_default))/intval($item->price_default))*100,1))}}İNDİRİM
                                            </span>
                                        </div>
                                        <div class="price-text">
                                            <span class="old-price">
                                                <del class="del-price">{{number_format(TL($item->price_default))}}
                                                    TL
                                                </del>
                                            </span>
                                            <br>
                                            <span class="new-price discount">{{number_format(TL($item->vip_default))}}
                                                TL
                                            </span>
                                        </div>
                                    @else
                                        <div class="price-text">
                                            <span class="new-price discount">{{number_format(TL($item->price_default))}}
                                                TL
                                            </span>
                                        </div>
                                    @endif
                                @endif


                                <div class="pt-3">
                                    @if($model_default)
                                        <a id="buy_link"
                                           href="{{$model_default->inventory>0 ? route('front.add.basket',[$item->id,$model_default->id]) : 'javascript:void(0)'}}"
                                           class="py-lg-3 btn  {{$model_default->inventory>0?'btn-success':'btn-invent'}}">
                                            @if($model_default->inventory>0)
                                                <i class="fas fa-shopping-cart"></i>
                                                <span>Sepete ekle</span>
                                            @else
                                                <span>× mevcut değil</span>
                                            @endif
                                        </a>
                                    @else
                                        <a id="buy_link"
                                           href="{{$item->inventory_default>0 ? route('front.add.basket',[$item->id,0]) : 'javascript:void(0)'}}"
                                           class="py-lg-3 btn   {{$item->inventory_default>0?'btn-success':'btn-invent'}}">
                                            @if($item->inventory_default>0)
                                                <i class="fas fa-shopping-cart"></i>
                                                <span> Sepete ekle</span>
                                            @else
                                                <span>× mevcut değil</span>
                                            @endif
                                        </a>
                                    @endif
                                </div>
                            </div>
                            {{-- <div class="expand-showroom">
                                <div class="d-flex">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <div class="p-1">
                                        <a href="" class="scroll-menu  view-in-showroom">Showroomda Görebilir Miyim?</a>
                                    </div>

                                </div>
                            </div>
                            <div class="product-details-bottom">
                                <p><img src="//cdn.vivense.com/images/icon/fast-delivery-1.svg"
                                        style="padding-bottom: 5px"> Hızlı Teslimat: <span class="delivery-date">08-13 Temmuz
                                </span>
                                    <br>
                                    <a href="#delivery-information" class="scroll-menu delivery-info">Teslimat ve
                                        Kurulum</a>
                                </p>
                                <a class="feedback_product" data-toggle="modal" href="#feedback_product_popup"
                                   style="display: none">
                                    Bu ürünü bildir &gt;
                                </a>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12 text-center my-5">
                    <span class="title_orginal1 lorem_title_orginal1">Benzer ürünler</span>
                </div>

                <div class="btn_slider_box">
                    <!-- Swiper -->
                    <div class="swiper-container other_slider">

                        <div class="swiper-wrapper">
                            @foreach($item->category->products->take(10) as $product1)
                                <div class="swiper-slide">
                                    <div class="lorem-53 mb-4 mb-lg-5">
                                        @include('includes.product.cart_4',['product_include'=>$product1])
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="swiper-button-next" hidden id="next_2"></div>
                        <div class="swiper-button-prev" id="prev_2" hidden></div>
                        {{--<div class="swiper-pagination"></div>--}}
                        <span class="next_box swapper-slider-btn" data-val="2">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </span>
                        <span class="prev_box swapper-slider-btn" data-val="2">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </span>
                    </div>
                </div>


            </div>
        </div>
    </section>

@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script src="{{asset('source/assets/front/js/jquery.zoom.js')}}" type="text/javascript"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            spaceBetween: 4,
            slidesPerView: '{{$total}}',
            freeMode: true,
            watchSlidesProgress: true,
        });
        var swiper2 = new Swiper(".mySwiper2", {
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            thumbs: {
                swiper: swiper,
            },
        });
    </script>
@endsection

{{-- <script>
    $(".zoom").elevateZoom({
        zoomType: "lens",
        lensShape: "round",
        lensSize: 200,
        zoomWindowFadeIn: 500,
        zoomWindowFadeOut: 500,
        lensFadeIn: 500,
        lensFadeOut: 500,
        scrollZoom: true
    });

    function f() {
        var gallery_top = new Swiper('.gallery-top');
        gallery_top.slideTo(3, 3, false);
        var gallery_thumbs = new Swiper('.gallery-thumbs', {
            spaceBetween: 0,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesVisibility: true,
            watchSlidesProgress: true,

        });
        gallery_thumbs.slideTo(3, 3, false);
        gallery_thumbs.slideThumbActiveClass();
        gallery_thumbs.update()
    }
</script> --}}