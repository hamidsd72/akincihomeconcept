@extends('front.layouts.user')
@section('css')
@endsection
@section('body')


    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="10000">
        <div class="carousel-indicators">
            @foreach($sliders as $key=>$slider)
                <span data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{$key}}"
                        class="{{$key==0?'active':''}}" aria-current="true"></span>
            @endforeach

        </div>
        <div class="carousel-inner">
            @foreach($sliders as $key1=>$slider)

                {{--                <a href="{{$slider->link}}">--}}
                <div class="carousel-item {{$key1==0?'active':''}}">
                    <a href="{{$slider->link?$slider->link:'#'}}">

                        <img src="{{$slider->photo?url($slider->photo->path):''}}" class="d-block w-100" alt="...">
                    </a>
                    {{--@if($slider->top_left_pic)--}}
                    {{--<div class="ani_pic_box top_left slide-top-{{$slider->ani_top_left}}">--}}
                    {{--<img src="{{url($slider->top_left_pic)}}"--}}
                    {{--alt="">--}}
                    {{--</div>--}}
                    {{--@endif--}}
                    {{--@if($slider->top_center_pic)--}}
                    {{--<div class="ani_pic_box top_center slide-top-{{$slider->ani_top_center}}">--}}
                    {{--<img src="{{url($slider->top_center_pic)}}"--}}
                    {{--alt="">--}}
                    {{--</div>--}}
                    {{--@endif--}}
                    {{--@if($slider->top_right_pic)--}}
                    {{--<div class="ani_pic_box top_right slide-top-{{$slider->ani_top_right}}">--}}
                    {{--<img src="{{url($slider->top_right_pic)}}"--}}
                    {{--alt="">--}}
                    {{--</div>--}}
                    {{--@endif--}}
                    {{--@if($slider->bottom_left_pic)--}}
                    {{--<div class="ani_pic_box bottom_left slide-top-{{$slider->ani_bottom_left}}">--}}
                    {{--<img src="{{url($slider->bottom_left_pic)}}"--}}
                    {{--alt="">--}}
                    {{--</div>--}}
                    {{--@endif--}}
                    {{--@if($slider->bottom_center_pic)--}}
                    {{--<div class="ani_pic_box bottom_center slide-top-{{$slider->ani_bottom_center}}">--}}
                    {{--<img src="{{url($slider->bottom_center_pic)}}"--}}
                    {{--alt="">--}}
                    {{--</div>--}}
                    {{--@endif--}}
                    {{--@if($slider->bottom_right_pic)--}}
                    {{--<div class="ani_pic_box bottom_right slide-top-{{$slider->ani_bottom_right}}">--}}
                    {{--<img src="{{url($slider->bottom_right_pic)}}"--}}
                    {{--alt="">--}}
                    {{--</div>--}}
                    {{--@endif--}}

                </div>

                {{--</a>--}}
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    {{--    category --}}
    <section class="cat_box py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 text-center mb-4">
                    <span class="title">ÜRÜN KATEGORİLER</span>
                </div>

                {{--<div class="swiper-container cat_slid mt-5">--}}
                {{--<div class="swiper-wrapper">--}}
                {{--@foreach($pro_cats as $pro_cat)--}}

                {{--<div class="swiper-slide">--}}
                {{--<a href="{{route('front.category',$pro_cat->slug)}}">--}}
                {{--<div class="cat_slid_box">--}}
                {{--<div class="img_box">--}}
                {{--<img src="{{$pro_cat->photo?url($pro_cat->photo->path):''}}"--}}
                {{--alt="{{$pro_cat->name}}">--}}
                {{--</div>--}}
                {{--<h6 class="my-3">{{$pro_cat->name}}</h6>--}}


                {{--</div>--}}
                {{--</a>--}}
                {{--</div>--}}

                {{--@endforeach--}}
                {{--</div>--}}
                {{--<!-- Add Pagination -->--}}
                {{--<div class="swiper-pagination"></div>--}}
                {{--<div class="swiper-button-next swiper-button-white"></div>--}}
                {{--<div class="swiper-button-prev swiper-button-white"></div>--}}
                {{--</div>--}}

                {{--</div>--}}
                @if(count($pro_cats)>0)
                    @foreach($pro_cats as $pro_cat)
                        <div class="col-lg-3 col-md-6 my-4">
                            <a href="{{route('front.category',$pro_cat->slug)}}">
                                <div class="cat_item container-fluid">
                                    <div class="row h-100">
                                        <div class="col-7 cat_info_box p-2">
                                            <h5 class="my-2">{{$pro_cat->name}}</h5>
                                            <span class="cat_price">{{$pro_cat->start_price}} ₺ 'den</span>
                                            <span class="cat_start_price">başlayan fiyatlar</span>
                                        </div>
                                        <div class="col-5 h-100 p-0">
                                            <div class="cat_img_box">
                                                <img src="{{$pro_cat->photo?url($pro_cat->photo->path):''}}"
                                                     alt="{{$pro_cat->name}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>

                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>



    @if(isset($banners_width[0]))
        <section class=" py-2">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="banner_width">
                            <a href="{{$banners_width[0]->link?$banners_width[0]->link:'#'}}">

                                <img src="{{$banners_width[0]->photo?url($banners_width[0]->photo->path):''}}"
                                     alt="{{$banners_width[0]->brand}}">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if(count($vips))
      <section class="cart_box py-5">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <h3 class="text-center">
                Vip Ürünler
              </h3>
            </div>
            <div class="slider_box">
                     <span class="next_box" data-val="1001">
                         <span class="carousel-control-next-icon" aria-hidden="true"></span>
                     </span>
              <span class="prev_box" data-val="1001">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </span>
              <div class="swiper-container vip-slider">
                <div class="swiper-wrapper">
                    @foreach($vips as $product_vip)
                        <div class="swiper-slide row1_item">
                            @include('includes.product.cart_4',['product_include'=>$product_vip])
                        </div>
                    @endforeach
                </div>
                {{--<div class="swiper-pagination"></div>--}}
                <div class="swiper-button-next swiper-button-white slider_r1_1001"
                     id="next_1001" hidden></div>
                <div class="swiper-button-prev swiper-button-white slider_r1_1001"
                     id="prev_1001" hidden></div>
              </div>

            </div>
          </div>
        </div>
      </section>
    @endif

    @if(count($ecos))
      <section class="cart_box py-5">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <h3 class="text-center">
                Ekonomi Dünyası
              </h3>
            </div>
            <div class="slider_box">
                     <span class="next_box" data-val="1002">
                         <span class="carousel-control-next-icon" aria-hidden="true"></span>
                     </span>
              <span class="prev_box" data-val="1002">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </span>
              <div class="swiper-container eco-slider">
                <div class="swiper-wrapper">
                  @foreach($ecos as $product_eco)
                    <div class="swiper-slide row1_item">
                      @include('includes.product.cart_4',['product_include'=>$product_eco])
                    </div>
                  @endforeach
                </div>
{{--                <div class="swiper-pagination eco-pagination"></div>--}}
                <div class="swiper-button-next  slider_r1_1002"
                     id="next_1002" hidden></div>
                <div class="swiper-button-prev  slider_r1_1002"
                     id="prev_1002" hidden></div>
              </div>

            </div>
          </div>
        </div>
      </section>
    @endif

    <section class="banners_box py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    @if($page_info->pic2!=null)

                        <div class="img_banner_big">
                            <a href="{{$page_info->link_pic3?$page_info->link_pic3:'#'}}">
                                <img src="{{url($page_info->pic3)}}"
                                     alt="banner">
                            </a>
                        </div>
                    @endif
                </div>
                <div class="col-md-4">
                    {{--<div class="text_banner_small pt-2">
                        <h4 class="header">{{$page_info->title1}}</h4>
                        <h5>{{$page_info->title1}}</h5>
                        <p>{{$page_info->text1}}</p>
                        <a href="{{$page_info->link?$page_info->link:'#'}}">
                            {{$page_info->link_title1}}
                        </a>
                    </div>--}}
                    @if($page_info->pic4!=null)
                        <div class="img_banner_small pt-2">
                            <a href="{{$page_info->link_pic4?$page_info->link_pic4:'#'}}">
                                <img src="{{url($page_info->pic4)}}"
                                     alt="banner">
                            </a>
                        </div>
                    @endif
                    @if($page_info->pic1!=null)
                        <div class="img_banner_small pt-2">
                            <a href="{{$page_info->link_pic1?$page_info->link_pic1:'#'}}">
                                <img src="{{url($page_info->pic1)}}"
                                     alt="banner">
                            </a>
                        </div>
                    @endif
                    @if($page_info->pic2!=null)

                        <div class="img_banner_small pt-2">
                            <a href="{{$page_info->link_pic2?$page_info->link_pic2:'#'}}">
                                <img src="{{url($page_info->pic2)}}"
                                     alt="banner">
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <?php $i = 0;
    $row1 = 1;
    $row2 = 1;
    ?>
    @foreach($cat_homes as $key_cat=>$cat_home)

        {{--    slider_1 row_2--}}
        @if(count($cat_home->home_products) and  $cat_home->slider_type==2)
            <section class="cat_box py-5">

                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12 text-center mb-4">
                            <span class="title">
                                <a href="{{route('front.category',$pro_cat->slug)}}"
                                   class="">{{$cat_home->name}}</a>
                            </span>
                        </div>
                        <div class="slider_box">
     <span class="next_box" data-val="{{$key_cat}}">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </span>
                            <span class="prev_box" data-val="{{$key_cat}}">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </span>
                            <div class="swiper-container row2_slider row2_slider_{{$row2}}">
                                <div class="swiper-wrapper">

                                    @foreach($cat_home->home_products as $product_cat)
                                        <div class="swiper-slide row2_item">
                                            @include('includes.product.cart_4',['product_include'=>$product_cat])
                                        </div>
                                    @endforeach
                                </div>
                                {{--<div class="swiper-pagination"></div>--}}
                                <div class="swiper-button-next swiper-button-white slider_r2_{{$row2}}" hidden
                                     id="next_{{$key_cat}}"></div>
                                <div class="swiper-button-prev swiper-button-white slider_slider_r2_{{$row2}}"
                                    hidden id="prev_{{$key_cat}}"></div>
                            </div>

                        </div>


                    </div>
                </div>
            </section>
            <?php $row2++?>

            {{--    slider_2 row_1--}}

        @elseif(count($cat_home->home_products) and $cat_home->slider_type==1)
            <section class="cart_box py-5">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h3 class="text-center">
                                <a href="{{route('front.category',$cat_home->slug)}}"
                                   class="">{{$cat_home->name}}</a>
                            </h3>
                            <p class="text-center">
                                <a href="{{route('front.category',$cat_home->slug)}}" class="float-end ink_cat">
                                    Tümü <i class="fa fa-arrow-right"></i></a>
                            </p>

                        </div>
                        <div class="slider_box">
                     <span class="next_box" data-val="{{$key_cat}}">
                         <span class="carousel-control-next-icon" aria-hidden="true"></span>
                     </span>
                            <span class="prev_box" data-val="{{$key_cat}}">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </span>
                            <div class="swiper-container row1_slider row1_slider_{{$row1}}">
                                <div class="swiper-wrapper">
                                    @foreach($cat_home->home_products as $product_cat)
                                        <div class="swiper-slide row1_item">
                                            @include('includes.product.cart_4',['product_include'=>$product_cat])
                                        </div>
                                    @endforeach
                                </div>
                                {{--<div class="swiper-pagination"></div>--}}
                                <div class="swiper-button-next swiper-button-white slider_r1_{{$row1}}"
                                     id="next_{{$key_cat}}" hidden></div>
                                <div class="swiper-button-prev swiper-button-white slider_r1_{{$row1}}"
                                     id="prev_{{$key_cat}}" hidden></div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
            <?php $row1++?>
        @endif



{{--        --}}{{--    banner--}}
{{--        @if($key_cat==1)--}}
{{--            <section class="banners_box py-5">--}}
{{--                <div class="container">--}}
{{--                    <div class="row justify-content-center">--}}
{{--                        <div class="col-md-8">--}}
{{--                            @if($page_info->pic2!=null)--}}

{{--                            <div class="img_banner_big">--}}
{{--                                <a href="{{$page_info->link_pic3?$page_info->link_pic3:'#'}}">--}}
{{--                                    <img src="{{url($page_info->pic3)}}"--}}
{{--                                         alt="banner">--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                                @endif--}}
{{--                        </div>--}}
{{--                        <div class="col-md-4">--}}
{{--                            --}}{{--<div class="text_banner_small pt-2">--}}
{{--                                <h4 class="header">{{$page_info->title1}}</h4>--}}
{{--                                <h5>{{$page_info->title1}}</h5>--}}
{{--                                <p>{{$page_info->text1}}</p>--}}
{{--                                <a href="{{$page_info->link?$page_info->link:'#'}}">--}}
{{--                                    {{$page_info->link_title1}}--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            @if($page_info->pic4!=null)--}}
{{--                                <div class="img_banner_small pt-2">--}}
{{--                                    <a href="{{$page_info->link_pic4?$page_info->link_pic4:'#'}}">--}}
{{--                                        <img src="{{url($page_info->pic4)}}"--}}
{{--                                             alt="banner">--}}
{{--                                    </a>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                            @if($page_info->pic1!=null)--}}
{{--                            <div class="img_banner_small pt-2">--}}
{{--                                <a href="{{$page_info->link_pic1?$page_info->link_pic1:'#'}}">--}}
{{--                                    <img src="{{url($page_info->pic1)}}"--}}
{{--                                         alt="banner">--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            @endif--}}
{{--                                @if($page_info->pic2!=null)--}}

{{--                                <div class="img_banner_small pt-2">--}}
{{--                                <a href="{{$page_info->link_pic2?$page_info->link_pic2:'#'}}">--}}
{{--                                    <img src="{{url($page_info->pic2)}}"--}}
{{--                                         alt="banner">--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                                @endif--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </section>--}}
{{--        @endif--}}


        {{--    one banner--}}
        @if($key_cat==4)
{{--
            <section class="banner_one_box d-none d-sm-block"
                     style="background: url({{$page_info->pic4!=null?url($page_info->pic4):''}})">
                <div class="container-fluis h-100">
                    <div class="row h-100">
                        <div class="col-lg-4 col-md-6 col-sm-8 px-0 mx-auto h-100 position-relative">
                            <div class="text_banner px-2">
                                <div class="header_text">{{$page_info->title2}}</div>
                                <div class="big_text">{{$page_info->text2}}</div>
                                <div class="a_text">
                                    <a href="{{$page_info->link2?$page_info->link2:''}}">
                                        {{$page_info->link_title2}}
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>--}}
        @endif


    @endforeach

    @if(count($banners_group)>0)
        <section class=" py-5">
            <div class="container">
                <div class="row justify-content-md-center">
                    <div class="col-md-10">
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-5 ">
                            @foreach($banners_group as $banner_group)
                                <div class="col">
                                    <div class="banner_group">
                                        <a href="{{$banner_group->link?$banner_group->link:'#'}}">
                                            <img src="{{$banner_group->photo?url($banner_group->photo->path):''}}"
                                                 alt="{{$banner_group->brand}}">
                                        </a>
                                    </div>
                                </div>

                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </section>
    @endif



@endsection
@section('js')

@endsection