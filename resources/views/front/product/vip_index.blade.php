@extends('front.layouts.user')
@section('css')
@endsection
@section('body')
    <section>
        {{--<div class="col-12 page_header">--}}
        {{--<img src="https://www.caliskanofis.com/uploads/urunkategori/banner/banner_5f57a1d091bc0_1599578576.jpg"--}}
        {{--alt="">--}}
        {{--</div>--}}
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="address_bar">
                        <ul>
                            <li>
                                <a href="{{route('front.index')}}">Anasayfa </a> /
                            </li>
                            <li>
                                {{$type}}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @if ($type=='vip')
            <div class="row">

                    <div class="col-md-12 mx-auto">
                            <div class="slider_g_box height_unset">
                                <!-- Swiper -->
                                <div class="swiper-container cat_page_g_s1">
                                    <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <img src="{{asset('source/assets/img/main-slider-vip.jpg')}}"/>
                                            </div>
                                    </div>
                                </div>
                            </div>
                    </div>

            </div>
        @endif

        <div class="container">
            @if(count($products)>0)

                <div class="row py-5">
                    @foreach($products as $product)
                        <div class="col-md-3 my-3">
                            @include('includes.product.cart_4',['product_include'=>$product])

                        </div>
                    @endforeach


                </div>
                <div class="col-12">
                    <div class="pagination_box">
                        {{ $products->links("pagination::bootstrap-4") }}
                    </div>
                </div>
            @else
                <div class="col-12 alert alert-danger text-center">
                    <h5>
                        Kayıtsız ürünler
                    </h5>
                </div>
            @endif
        </div>
    </section>
@endsection
@section('js')
@endsection