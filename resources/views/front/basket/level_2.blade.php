@extends('front.layouts.user')
@section('css')
@endsection
@section('body')
    <div id="mySidenav_address" class="sidenav_address">
        <a href="javascript:void(0)" class="closebtn closenav_address ">&times;</a>
        <form action="{{route('front.type.address.set')}}" id="add_address" method="post">
            {{csrf_field()}}
            <h1>Adres ekle</h1>
            <p>
                <span>01 Kişisel Bilgileriniz</span>
            </p>
            <div class="col-12 mt-2">
                <label>Teslim alacak kişinin bilgileri</label>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 pl-0">
                            <input type="text" name="f_name" class="form-control" placeholder="AD">
                        </div>
                        <div class="col-md-6 pr-0">
                            <input type="text" name="l_name" class="form-control" placeholder="Soyad">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 number_mobile_div mt-2">
                <label>Telefon</label>
                <input type="number" class="form-control" name="mobile">
                <span class="number_span">(+90)</span>
            </div>
            <p>
                <span>02 Adres Bilgileriniz</span>
            </p>
            <div class="col-12 number_mobile_div state_address mt-2">
                <label>Şehir</label>
                <select class="form-control select_js state_id chosen-select" name="state" data-type="state_id" data-reply="city_id" data-name="Şehir">
                    <option value="">Seçiniz</option>
                    @foreach($states as $state)
                        <option value="{{$state->id}}">{{$state->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 city_address mt-2">
                <label>İlçe</label>
                <select class="form-control select_js city_id chosen-select" name="city" data-type="city_id" data-reply="loc_id" data-name="İlçe">
                    <option value="">Seçiniz</option>
                </select>
            </div>
            <div class="col-12 mt-2 loc_address d-none">
                <label>Mahalle</label>
                <select class="form-control loc_id chosen-select" name="loc">
                    <option value="">Seçiniz</option>
                </select>
            </div>
            <div class="col-12 mt-2">
                <label>Adres</label>
                <textarea class="form-control" name="address" rows="5" placeholder="Mahalle, sokak, cadde ve diğer bilgilerinizi girin"></textarea>
            </div>
            <div class="col-12 mt-2">
                <label>Bu adrese bir ad verin</label>
                <input type="text" class="form-control" name="address_name" placeholder="Örnek: Evim, İş yerim vb.">
            </div>
            <div class="col-12 mt-4">
                <a href="javascript:void(0)" onclick="return $('#add_address').submit()" class="btn_orginal1 float-left">Adresi kaydet</a>
                <a href="javascript:void(0)" class="btn_orginal2 closenav_address2 float-right">Vazgeç</a>
            </div>
        </form>

    </div>

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
                            Nasıl gönderilir
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <section class="container basket-page">
        <div class="row">
            <div class="col-md-9">
                <h3 class="mb-3">Teslimat adresi</h3>
                {{--        <a href="">افزودن آدرس جدید</a>--}}
                <a href="javascript:void(0);" class="opennav_address text_orginal"><i class="fas fa-plus"></i>  Yeni adres ekle </a>
                @if(count(auth()->user()->addresses))
                    <div class="address_wrapper_1ORR8 my-5">
                        @foreach(auth()->user()->addresses as $key=>$address)
                            <div data-test-class="address-item" data-key="{{$key+1}}" data-val="{{$address->id}}" data-count="{{count(auth()->user()->addresses)}}" class="address_item_1VcxP " id="item_{{$key+1}}">
                                <i class="fa fa-check checked_M0i6D" style="display: none" id="checked_{{$key+1}}"></i>
                                <div class="address_detail_ocp_2bwFM">
                                    <div>
                                        <h3>{{$address->first_name}} {{$address->last_name}}</h3>
                                        <p>{{$address->address_name}}</p>
                                    </div>
                                    <div class="city_detail_ocp_1QmiI">{{$address->address}} {{$address->district?$address->district->name:''}} {{$address->city?$address->city->name:''}} / {{$address->state?$address->state->name:''}} </div>
                                </div>
                                @if(count(auth()->user()->addresses)>1)
                                    <div class="menu_container_2d7_n">
                                        <a href="{{route('front.type.address.del',$address->id)}}" class="menu_button_2Nfcs menu-button-area">Sil</a>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="col-md-3">
                <div class="bascket_info">
                    <form action="{{route('front.type.send.basket')}}" method="post" id="address_form" >
                        {{csrf_field()}}
                        <input type="text" hidden name="address_val" id="address_val" >
                        <a class="sender_" > Davam Et</a>
                    </form>
                </div>

            </div>
        </div>

    </section>
@endsection
@section('js')
@endsection