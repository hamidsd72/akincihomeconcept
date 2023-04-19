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
                        </li>
                        <li>
                            Araba
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <section class="container-fluid px-md-4 px-2 mb-70-md mt-3 basket-page">
        <div class="row">

            <div class="col-md-8">
                <div class="basket-items-wrapper mb-5">
                    <h4>SEPETİM</h4>
                    <hr>
                    @if(count($basket)>0)
                        @foreach($basket as $key=>$model)
                            @if($key!=0)
                                <hr>
                            @endif
                            @if(isset($model['model']->id))
                                <div class="basket-item row">
                                    <div class="col-12">
                                        <a href="javascript:void(0);"
                                           data-title="{{$model['model']->product->title}}"
                                           data-model="{{$model['model']->type}}: {{$model['model']->type_val}}"
                                           data-url="{{route('front.del.basket' , [$model['model']->id,$model['model']->product_id])}}"
                                           class="remove del_basket float-end">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                    <div class="basket-item__image">
                                        <img src="@if(!is_null($model['model']->photo)) {{url($model['model']->photo->path)}} @else {{$model['model']->product->thumbnail ?url($model['model']->product->thumbnail): url('source/assets/front/img/nopic.jpg')}} @endif"
                                             alt="{{$model['model']->product->title}}">
                                    </div>
                                    <div class="basket-item__body row">
                                        <div class="col-4">
                                            <div class=" align-items-center justify-content-between">
                                                <h3>{{$model['model']->product->title}}</h3>
                                                <span>{{$model['model']->type}}: {{$model['model']->type_val}}</span>


                                            </div>
                                        </div>
                                        <div class="col-4">

                                            <div class="product-count basket-item-wrapper__count"><span>Numara:</span>
                                                <br>
                                                <div class="product-count-wrapper">
                                                    <a href="{{route('front.update.basket',[$model['model']->product_id,$model['model']->id,intval($model['number'])+1])}}"
                                                       class="basket-item-wrapper__count__plus"><i
                                                                class="fas fa-plus"></i></a>
                                                    <span class="item_count">{{$model['number']}}</span>
                                                    <a @if($model['number']>1) href="{{route('front.update.basket',[$model['model']->product_id,$model['model']->id,intval($model['number'])-1])}}"
                                                       @else href="javascript:void(0);"
                                                       @endif class="basket-item-wrapper__count__minus {{$model['number']<=1?'btn-disabled':''}}"><i
                                                                class="fas fa-minus"></i></a>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-4">
                                        <div class=" align-items-end justify-content-between">
                                            <div class="d-flex align-items-end justify-content-end flex-column">
                                                <small>Birim fiyat:</small>
                                                @if($model['model']->price_vip && $model['model']->price_vip > 0)
                                                    <s>{{TL($model['model']->price)}} TL</s>
                                                    <strong class="text-success">{{TL($model['model']->price_vip)}}
                                                        TL
                                                    </strong>
                                                @else
                                                    <strong class="text-success">{{TL($model['model']->price)}}
                                                        TL
                                                    </strong>
                                                @endif
                                            </div>

                                        </div>
                                        </div>
                                    </div>

                                </div>
                            @else
                                <div class="basket-item row">
                                    <div class="col-12">
                                        <a href="javascript:void(0);"
                                           data-title="{{$model['product']->title}}"
                                           data-model=""
                                           data-url="{{route('front.del.basket' , [0,$model['product']->id])}}"
                                           class="remove del_basket float-end">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                    <div class="basket-item__image">
                                        <img src="@if(!is_null($model['product']->thumbnail)) {{url($model['product']->thumbnail)}} @else url('source/assets/front/img/nopic.jpg')}} @endif"
                                             alt="{{$model['product']->title}}">
                                    </div>
                                    <div class="basket-item__body row">
                                        <div class="col-4">
                                            <div class=" align-items-center justify-content-between">
                                                <h3>{{$model['product']->title}}</h3>

                                            </div>
                                        </div>
                                        <div class="col-4">

                                        <div class=" align-items-end justify-content-between">

                                            <div class="product-count basket-item-wrapper__count"><span>Numara:</span>
                                                <div class="product-count-wrapper">
                                                    <a href="{{route('front.update.basket',[$model['product']->id,0,intval($model['number'])+1])}}"
                                                       class="basket-item-wrapper__count__plus"><i
                                                                class="fas fa-plus"></i></a>
                                                    <span class="item_count">{{$model['number']}}</span>
                                                    <a @if($model['number']>1) href="{{route('front.update.basket',[$model['product']->id,0,intval($model['number'])-1])}}"
                                                       @else href="javascript:void(0);"
                                                       @endif class="basket-item-wrapper__count__minus {{$model['number']<=1?'btn-disabled':''}}"><i
                                                                class="fas fa-minus"></i></a>
                                                </div>
                                            </div>

                                        </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="d-flex align-items-end justify-content-end flex-column">
                                                <small>Birim fiyat:</small>
                                                @if($model['product']->vip_default && $model['product']->vip_default > 0)
                                                    <s>{{Tl($model['product']->price_default)}} TL
                                                    </s>
                                                    <strong class="text-success">{{TL($model['product']->vip_default)}}
                                                        TL
                                                    </strong>
                                                @else
                                                    <strong class="text-success">{{TL($model['product']->price_default)}}
                                                        TL
                                                    </strong>
                                                @endif
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            @endif
                        @endforeach
                    @else
                        <div class="alert alert-danger text-center">
                            Sepetiniz boş
                        </div>
                    @endif
                </div>
            </div>

            <aside class="col-md">
                <div class="box_level_1">
                    <h4 class="title-dot">Satın alma faturanız</h4>
                    <div class="info_price_backet">
                        <table>
                            <tr>
                                <td>
                                    <i>+</i>
                                    <p>Genel sipariş toplamı</p>
                                </td>
                                <td>
                                    <strong class="float-end">
                                        {{TL($all_price)}}
                                        Tl
                                    </strong>
                                </td>
                            </tr>
                            <tr class="br_b_ta">
                                <td>
                                    <i>-</i> <p>İndirim:</p>
                                </td>
                                <td>
                                    <strong class="float-end">
                                        {{TL($discount_price)}}
                                        Tl
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <i>=</i>  <p>Ödediğiniz miktar</p>

                                </td>
                                <td>
                                    <strong>
                                        {{TL($total_price)}}
                                        TL
                                    </strong>
                                </td>
                            </tr>
                        </table>

                    </div>

                </div>
                @if(Auth::check())
                    @if(count($basket)>0)
                        <a class="btn btn-digi btn-block my-3" href="{{route('front.level_2')}}" >
                            <span>SEPETİ ONAYLA</span>
                        </a>
                    @endif
                @else
                    <div id="new-comment-blog" class="">
                        Devam etmek için <a href="{{route('login')}}" class="lob_bas"> giriş </a> yap
                    </div>
                @endif

            </aside>


            {{--products--}}
            {{--@if(count($products)>0)--}}
                {{--<section class="container-fluid px-md-4 px-2 mb-70-md my-5 slider_sale">--}}
                    {{--<div class="row">--}}
                        {{--<div class="col-12 position-relative">--}}
                            {{--<h3>محصولاتی که اغلب همراه محصولات شما خریداری شده‌اند</h3>--}}
                        {{--                            <p class="p_orginal_color">اولین کسی باشید که سفارش می‌دهید</p>--}}
                        {{--<!-- Add Arrows -->--}}
                            {{--<div class="swiper-button-next new_arrow">--}}
                                {{--<i class="fas fa-arrow-right"></i>--}}
                            {{--</div>--}}
                            {{--<div class="swiper-button-prev new_arrow">--}}
                                {{--<i class="fas fa-arrow-left"></i>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-12 new_product mt-4">--}}
                            {{--<!-- Swiper -->--}}
                            {{--<div class="new_product_slider swiper-container">--}}
                                {{--<div class="swiper-wrapper">--}}
                                    {{--@foreach($products as $model)--}}
                                        {{--<div class="swiper-slide">--}}
                                            {{--@include('includes.product.card_2',['model'=>$model])--}}
                                        {{--</div>--}}
                                    {{--@endforeach--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</section>--}}
            {{--@endif--}}
        </div>
    </section>
@endsection
@section('js')
@endsection