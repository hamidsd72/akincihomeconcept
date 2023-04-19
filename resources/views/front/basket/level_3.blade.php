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
                            <a href="{{route('front.level_1')}}">Araba</a> /
                        </li>
                        <li>
                            <a href="{{route('front.level_2')}}"> Nasıl gönderilir </a>/
                        </li>
                        <li>
                            Ödeme şekli
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <section class="container-fluid px-md-4 px-2 mb-70-md mt-3 basket-page basket-payment">
        <form class="row" action="{{route('front.end.basket',$factor->order_code)}}" method="post">
            <div class="col-md-8">
                <div class="col-12 send_order mt-3">
                    <div class="container-fluid send_order_in mb-3 py-3 px-0">
                        <h4 class="mb-4 px-3 title-dot">Sipariş detaylarınız</h4>
                        <div class="table-responsive">
                            <table class="table table-striped min-w-500px">
                                <thead>
                                <tr>
                                    <th class="text-start">Resim</th>
                                    <th class="text-start">Ürün adı</th>
                                    <th class="text-start">Numara</th>
                                    <th class="text-start">Birim fiyat</th>
                                    <th class="text-start">Toplam fiyat</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($basket as $value)
                                    <tr>
                                        @if(isset($value['model']->id))

                                            <td>

                                                <div class="level_3_img_box">
                                                    <img src="@if(!is_null($value['model']->photo)) {{url($value['model']->photo->path)}} @else {{$value['model']->product->thumbnail ?url($value['model']->product->thumbnail): url('source/assets/front/img/nopic.jpg')}} @endif"
                                                         alt="{{$value['model']->product->title}}">
                                                </div>

                                            </td>
                                            <td>{{$value['model']->product->title}}
                                                _{{$value['model']->type.':'.$value['model']->type_val}}</td>
                                            <td class="text-center">{{$value['number']}}</td>
                                            <td class="text-left">
                                                @if($value['model']->price_vip && $value['model']->price_vip > 0)
                                                    <strong class="text-success d-block">{{TL($value['model']->price_vip)}}</strong>
                                                @else
                                                    <strong class="text-success d-block">{{TL($value['model']->price)}}</strong>
                                                @endif
                                            </td>
                                            <td class="text-success text-left">
                                                @if($value['model']->price_vip && $value['model']->price_vip > 0)
                                                    <strong class="text-success">{{TL(intval($value['model']->price_vip)*intval($value['number']))}}</strong>
                                                @else
                                                    <strong class="text-success">{{TL(intval($value['model']->price)*intval($value['number']))}}</strong>
                                                @endif
                                            </td>
                                        @else
                                            <td>

                                                <div class="level_3_img_box">
                                                    <img src="@if(!is_null($value['product']->thumbnail)) {{url($value['product']->thumbnail)}}  @endif"
                                                         alt="{{$value['product']->title}}">
                                                </div>

                                            </td>
                                            <td>{{$value['product']->title}}</td>
                                            <td class="text-center">{{$value['number']}}</td>
                                            <td class="text-left">

                                                @if($value['product']->vip_default && (int)$value['product']->vip_default > 0)
                                                    <strong class="text-success d-block">{{TL($value['product']->vip_default)}}</strong>
                                                @else
                                                    <strong class="text-success d-block">{{TL($value['product']->price_default)}}</strong>
                                                @endif
                                            </td>
                                            <td class="text-success text-left">
                                                @if($value['product']->vip_default && (int)$value['product']->vip_default > 0)
                                                    <strong class="text-success">{{TL(intval($value['product']->vip_default)*intval($value['number']))}}</strong>
                                                @else
                                                    <strong class="text-success">{{TL(intval($value['product']->price_default)*intval($value['number']))}}</strong>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($reserv=='pending')

                            <div class="d-flex align-items-center justify-content-between px-4 mt-4">
                                <span>nakliye maliyeti</span><strong class="text-success">
                                    {{$factor->post_price>0?TL($factor->post_price).' TL':'Bedava'}}
                                </strong>
                            </div>
                        @endif
                        <div class="d-flex align-items-center justify-content-between px-4 mt-3">
                            <span>Toplam</span>
                            <strong class="text-success">
                                {{TL($all_price+$factor->post_price)}}
                            </strong>
                        </div>
                        <hr class="discont_set_yes" style="display: none"/>
                        <div class="align-items-center justify-content-between px-4 mt-4 discont_set_yes"
                             style="display: none">
                            <span>مقدار تخفیف</span>
                            <strong class="text-success float-left">
                                 <span class="discont_val">
                                </span>
                                تومان
                            </strong>
                        </div>
                        <div class="align-items-center justify-content-between px-4 mt-3 discont_set_yes"
                             style="display: none">
                            <span>مبلغ قابل پرداخت</span>
                            <strong class="text-success float-left">
                                <span class="discount_sum">
                                </span>
                                تومان
                            </strong>
                        </div>
                    </div>
                </div>
            </div>
            <aside class="col-md-4">
                <h4 class="title-dot">Ödeme türünü seçin</h4>
                <div class="col-12">
                    {{csrf_field()}}
                    <fieldest name="method">
                        <div class="radio_pay radio_pay_mode_click  " id="cart_pay" data-type="cart">
                            <input class="pay_modes" type="radio" name="pay_mode" id="radio_cart" value="payent"
                                   checked>
                            <label for="pay_mode" class="pay_mode">
                                <img src="{{url('source/assets/img/icon/payent.png')}}" alt="cart">
                            </label>
                        </div>
                        <div class="card_number" style="display: none">
                            <p>{{$setting->card_number}}</p>
                        </div>

                    </fieldest>
{{--                    <form action = "{{route('front.end.basket',$factor->order_code)}}" method="POST" >--}}
{{--                        @csrf--}}
{{--                        <script--}}
{{--                                class="paynet-button"--}}
{{--                                type="text/javascript"--}}
{{--                                src="https://pj.paynet.com.tr/public/js/paynet.min.js"--}}
{{--                                                src="https://pts-pj.paynet.com.tr/public/js/paynet.min.js"--}}
{{--                                data-key="pbk_di1MXqDzzKdzDSKxf08AtOY6vhLy"--}}
{{--                                data-amount="{{$all_price+$factor->post_price}}"--}}
{{--                                data-amount="1000"--}}
{{--                                data-button_label="Nihai ödeme ve kayıt">--}}
{{--                        </script>--}}
{{--                    </form>--}}
                    <button type="submit" class="btn btn-digi btn-block mb-3">
                        <i class="fas fa-check"></i>
                        <span>Nihai ödeme ve kayıt</span>
                    </button>
                </div>
            </aside>
        </form>
    </section>
@endsection
@section('js')
@endsection