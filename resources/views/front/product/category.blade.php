@extends('front.layouts.user')
@section('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

@endsection
@section('body')
    <section>
        {{--<p>--}}
            {{--<label for="amount">Price range:</label>--}}
            {{--<input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">--}}
        {{--</p>--}}

        {{--<div id="slider-range"></div>--}}
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
                            @if($category->father)
                                @if($category->father->father)

                                    <li>
                                        <a href="{{route('front.category',$category->father->father->slug)}}">{{$category->father->father->name }}</a>
                                        /
                                    </li>
                                @endif

                                <li>
                                    <a href="{{route('front.category',$category->father->slug)}}">{{$category->father->name}} </a>
                                    /
                                </li>
                            @endif

                            <li>
                                {{$category_name}}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                {{--@if(count($category->gallery_2)>0 or count($category->gallery)>0)--}}

                {{--<div class="col-md-9">--}}
                    {{--@if(count($category->gallery)>0)--}}
                        {{--<div class="slider_g_box">--}}
                            {{--<!-- Swiper -->--}}
                            {{--<div class="swiper-container cat_page_g_s1">--}}
                                {{--<div class="swiper-wrapper">--}}
                                    {{--@foreach($category->gallery as $gall)--}}
                                        {{--<div class="swiper-slide">--}}
                                            {{--<img src="{{url($gall->path)}}"/>--}}
                                        {{--</div>--}}
                                    {{--@endforeach--}}
                                {{--</div>--}}
                                {{--<div class="swiper-button-next"></div>--}}
                                {{--<div class="swiper-button-prev"></div>--}}
                                {{--<div class="swiper-pagination"></div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--@endif--}}
                {{--</div>--}}
                {{--<div class="col-md-3">--}}
                    {{--@if(count($category->gallery_2)>0)--}}
                    {{--<div class="slider_g_box">--}}
                        {{--<!-- Swiper -->--}}
                        {{--<div class="swiper-container cat_page_g_s">--}}
                            {{--<div class="swiper-wrapper">--}}
                                    {{--@foreach($category->gallery_2 as $gall)--}}
                                        {{--<div class="swiper-slide">--}}
                                            {{--<img src="{{url($gall->path)}}"/>--}}
                                        {{--</div>--}}
                                    {{--@endforeach--}}
                                {{--@foreach($category->gallery_2 as $pro)--}}
                                {{--<div class="swiper-slide">--}}
                                    {{--<a href="{{route('front.product.show',$pro->slug)}}">--}}
                                    {{--<div class="vip_box">--}}
                                        {{--<div class="vip_pic_box">--}}
                                            {{--<img src="{{$pro->thumbnail?url($pro->thumbnail):''}}" alt="{{$pro->title}}">--}}
                                        {{--</div>--}}
                                        {{--<div class="vip_info">--}}
                                            {{--<div class="name_box">--}}
                                                {{--<span>{{$pro->title}}</span>--}}
                                            {{--</div>--}}
                                            {{--<div class="pric_boxx">--}}
                                                {{--@if($pro->vip_default>0)--}}
                        {{--<span class="cart_price">--}}
                                        {{--<del>{{TL($pro->price_default)}} TL--}}
                                        {{--</del>--}}
                                    {{--</span>--}}
                                                        {{--<span class="cart_price_dis">--}}
                                        {{--{{TL($pro->vip_default)}}  TL--}}
                                                            {{--<i class="fa fa-lira-sign"></i>--}}
                                    {{--</span>--}}
                                                {{--@else--}}
                                                    {{--@if($pro->price_default>0)--}}
                        {{--<span class="cart_price_dis">--}}
                                        {{--{{TL($pro->price_default)}}  TL--}}
                            {{--<i class="fa fa-lira-sign"></i>--}}
                                    {{--</span>--}}
                                                    {{--@endif--}}
                                                {{--@endif--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--</a>--}}
                                {{--</div>--}}
                                {{--@endforeach--}}
                            {{--</div>--}}
                            {{--<div class="swiper-button-next"></div>--}}
                            {{--<div class="swiper-button-prev"></div>--}}
                            {{--<div class="swiper-pagination"></div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                        {{--@endif--}}
                {{--</div>--}}
                {{--@endif--}}

                    @if(count($category->children)>0)
                <div class="col-md-12">
                    <div class="category_box pt-3 pb-5 ">

                        <!-- Swiper -->
                        <h4 class="text-center">{{$category->name}}</h4>
                            <div class="swiper-container_page_cat">
                                <div class="swiper-wrapper justify-content-md-center">
                                    @foreach($category->children as $item)
                                        <div class="swiper-slide">
                                            <a class="w_100d" href="{{route('front.category',$item->slug)}}">
                                                <div class="product_box_p">

                                                    <div class="product_pic_box">
                                                        <img src="{{$item->photo?url($item->photo->path):''}}">
                                                    </div>
                                                    <div class="product_title_box">
                                                        <h5>{{$item->name}}</h5>
                                                    </div>
                                                </div>

                                            </a>

                                        </div>
                                    @endforeach

                                </div>
                                <!-- Add Pagination -->
                                <div class="swiper-pagination"></div>
                            </div>
                    </div>
                </div>
                    @endif
            </div>
        </div>
        {{--@if(auth()->check() && auth()->user()->id==1)--}}
        {{--@endif--}}
        <div class="container">
            @if(count($products)>0)
                <div class="row">
                    <div class="col-md-2 mx-auto">
                        <div class="filter_t text-center filter_set" id="filter_1">
                            filter <i class="fas fa-angle-down"></i>
                        </div>
                    </div>
                </div>
            <div class="box_f_filter box_f_filter_open" id="f_filter">
                <div class=" box_filter">

                    <form action="{{route('front.product.filter.category',$category?$category->slug:'')}}" method="get" class="row">
                        {{-- <div class="col-md-4">
                            <label class="mb-2"><strong>Fiyat</strong></label>
                            <div id="slider-range"></div>

                            <p>
                            <label for="amount">Fiyat aralığı:</label>
                            <input name="ttr" type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
                            </p> --}}


                            {{--<div class="wrap wrap--2x dir-ltr" style="--min: {{TlFilter($min_price_d)}}; --max: {{TlFilter($max_price_d)}}; --a: {{$min_price}}; --b: {{$max_price}}; --p: ' TL '">--}}
                                {{--<label class="sr-only" for="a">Value A:</label>--}}
                                {{--<input id="a" type="range" name="price_1" min="{{TlFilter($min_price_d)}}" max="{{TlFilter($max_price_d)}}" value="{{$min_price}}" step="10">--}}
                                {{--<output for="a" style="--c: var(--a)"></output>--}}
                                {{--<label class="sr-only" for="b">Value B:</label>--}}
                                {{--<input id="b" type="range" name="price_2" min="{{TlFilter($min_price_d)}}" max="{{TlFilter($max_price_d)}}" value="{{$max_price}}" step="10">--}}
                                {{--<output for="b" style="--c: var(--b)"></output>--}}
                            {{--</div>--}}
                        {{-- </div> --}}
                        <div class="col-md-2"></div>
                        <div class="col-md-3">
                            <label class="mb-2"><strong>sipariş</strong></label>
                            <select name="sort_product" class="form-control">
                                <option value="new" {{$sort_product=='new'?'selected':''}}>En yeni</option>
                                <option value="price_up" {{$sort_product=='price_up'?'selected':''}}>En pahalı</option>
                                <option value="price_down" {{$sort_product=='price_down'?'selected':''}}>En ucuz</option>
                                <option value="vip" {{$sort_product=='vip'?'selected':''}}>indirimler</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="mb-2"><strong>indirimler</strong></label>
                            <select name="vip_product" class="form-control">
                                <option value="no" {{$vip_product=='no'?'selected':''}}>Tüm ürünler</option>
                                <option value="yes" {{$vip_product=='yes'?'selected':''}}>Sadece indirimler</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-outline-filter">Filtre</button>
                        </div>
                        <div class="col-md-2"></div>
                    </form>
                </div>
            </div>

                                    <div class="row py-5">
                                        @foreach($products as $product)
                                            <div class="col-md-3 my-3">
                                                @include('includes.product.cart_4',['product_include'=>$product])

                                            </div>
                                        @endforeach


                                    </div>
                                    <div class="col-12">
                                        <div class="pagination_box">
                                            {{$products->appends(Request::except('page'))->links("pagination::bootstrap-4")}}
                    {{--                        {{ $products->links("pagination::bootstrap-4") }}--}}
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

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $( function() {
            $( "#slider-range" ).slider({
                range: true,
                min: {{$min_price_d}},
                max: {{$max_price_d}},
                values: [ {{$min_price_d}}, {{$max_price_d}} ],
                slide: function( event, ui ) {
                    $( "#amount" ).val( "" + ui.values[ 0 ] + "-" + ui.values[ 1 ] );
                }
            });
            $( "#amount" ).val( "" + $( "#slider-range" ).slider( "values", 0 ) +
                "-" + $( "#slider-range" ).slider( "values", 1 ) );
        } );
    </script>
@endsection