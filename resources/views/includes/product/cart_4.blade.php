@if(isset($product_include))
    <a href="{{route('front.product.show',$product_include->slug)}}">
        <div class="cart_item">
            <div class="cart_pic_box">
                <div class="orgin">
                    <img src="{{$product_include->thumbnail!=null?url($product_include->thumbnail):url($product_include->pic_hover)}}"
                         alt="{{$product_include->title}}">
                </div>
                <div class="hover">
                    <img src="{{$product_include->pic_hover!=null?url($product_include->pic_hover):url($product_include->thumbnail)}}"
                         alt="{{$product_include->title}}">
                </div>
            </div>
            <div class="cart_info_box py-2">
                <div class="name text-center">{{$product_include->title}}</div>
                @if($product_include->vip_default>0 and $product_include->price_default>$product_include->vip_default)
                    <div class="cart_price_box  my-2 text-center">
                        <span class="cart_price">
                                        <del>{{TL($product_include->price_default)}} TL
                                        </del>
                                    </span>
                        <span class="cart_price_dis">
                                        {{TL($product_include->vip_default)}}  TL
                                    </span>
                    </div>
                @else
                    @if($product_include->price_default>0)
                        <div class="cart_price_box  my-2">
                        <span class="cart_price_dis">
                                        {{TL($product_include->price_default)}}  TL
                                    </span>
                        </div>
                    @endif
                @endif


            </div>
        </div>

    </a>
@endif
