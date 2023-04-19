@component('layouts.back')
@section('title') Yönetim @endsection
@section('body')
    <div class="card">

        <div class="card-header archive-card-header">
            <div class="archive-circle-wrap">
                <div class="archive-circle">
                    <a href="/" target="_blank">

                        <img src="{{ panel_logo() }}" style="margin-top: 10px;">
                    </a>
                </div>
                <h2> Liste </h2></div>


        </div>
        <div class="paginate p-3">
            <a href="{{route('product-create')}}" class="btn btn-rounded btn-primary float-left"><i
                        class="fa fa-circle-o ml-1"></i> Ekle </a>
        </div>

        <div class="col-md-6">
            <a class="btn btn-primary pull-left" href="{{route('export-excel-product')}}">Ürünler (Excel çıktısı)</a>
            <a class="btn btn-primary pull-left" href="" data-toggle="modal" data-target="#myModal">Ürünler (Excel girişi)</a>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Excel dosyasını seçin</h4>
                    </div>
                    <form action="{{route('import-excel-product')}}" class="modal-body" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="file" name="file" class="form-control">
                        <br/>
                        {{ Form::button('<i class="fa fa-circle-o mtp-1 ml-1"></i> Ekle', array('type' => 'submit', 'class' => 'btn btn-rounded btn-primary float-left')) }}

                    </form>

                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped">
                    <thead>
                    <tr>
                        <td><h6>ID</h6></td>
                        <td><h6>Ürün adı</h6></td>
                        <td><h6>Marka</h6></td>
                        <td><h6>Ürün Koduا</h6></td>
                        <td><h6>Gösteri</h6></td>
                        <td><h6>Fotoğraf</h6></td>
                        <td><h6>Fiyat</h6></td>
                           <!--<td><h6>oluşturulma tarihi</h6></td>-->
                        <td><h6>MOdelerı</h6></td>
                        <td><h6>eco</h6></td>
                        <td><h6>vip</h6></td>
                        <td><h6>İşlem</h6></td>

                    </tr>
                    </thead>
                    @php $models_count=0; @endphp
                    @foreach ($products as $product)
                        @php $models_count+=count($product->modelss);  @endphp
                        <tr>

                            <td>
                                {{ $product->id }}
                            </td>
                            <td>
                                <a href="{{route('front.product.show',$product->slug)}}"
                                   target="_blank"> {{ $product->title }} </a>
                            </td>
                            <td>
                                {{ $product->brand->brand }}
                            </td>
                            <td>
                                {{ $product->code }}
                            </td>
                            <td>
                                @if($product->show=='1')
                                    Göster
                                @else
                                    Gösterme
                                @endif
                                <br>
                                <div class="pretty p-switch">
                                    <input type="checkbox" class="active_item" data-title="{{$product->title}}"
                                           data-url="{{route('product.status',[$product->id,'show'])}}"
                                           @if($product->show=='1')  data-msg="blocked_vip" checked
                                           @else data-msg="active_vip" @endif />
                                    <div class="state p-success">
                                        <label></label>
                                    </div>
                                </div>


                            </td>

                            <td>
                                @if($product->icon)
                                    <img src="{{url($product->icon)}}"
                                         width="70px">
                                @else
                                    <img src="{{$product->thumbnail!=null?url($product->thumbnail):''}}"
                                         width="70px">
                                @endif
                            </td>

                            <td>
                                  @if((int)$product->price_product($product)[1] > 0)
                                    <del class="text-danger mx-2">{{number_format(TL($product->price_default))}}</del>
                                    <span class="mx-2">{{number_format(TL($product->vip_default))}}</span> TL
                                  @else
                                    <span class="mx-2">{{number_format(TL($product->price_default))}}</span> TL
                                  @endif
                            </td>
                            <!--<td>{{my_jdate($product->created_at , 'Y/m/d  H:i')}}</td>-->

                            <td>
                                @if($product->model_have=='yes')
                                    <a href="{{route('model-list' , $product->id)}}">Modeler
                                        @if(count($product->models)>0)
                                            ({{count($product->models)}})
                                        @endif
                                    </a>
                                @else
                                    Yok
                                @endif
                            </td>
                            <td>
                                @if($product->eco_status=='active')
                                    Aktif
                                @else
                                    Etkin değil
                                @endif
                                    <br>
                                <div class="pretty p-switch">
                                    <input type="checkbox" class="active_item" data-title="{{$product->title}}"
                                           data-url="{{route('product.status',[$product->id,'eco_status'])}}"
                                           @if($product->eco_status=='active')  data-msg="blocked_vip" checked
                                           @else data-msg="active_vip" @endif />
                                    <div class="state p-success">
                                        <label></label>
                                    </div>
                                </div>


                            </td>
                            <td>

                                @if($product->vip_status=='active')
                                    Aktif
                                @else
                                    Etkin değil
                                @endif
                                <br>
                                <div class="pretty p-switch">
                                    <input type="checkbox" class="active_item" data-title="{{$product->title}}"
                                           data-url="{{route('product.status',[$product->id,'vip_status'])}}"
                                           @if($product->vip_status=='active')  data-msg="blocked_vip" checked
                                           @else data-msg="active_vip" @endif />
                                    <div class="state p-success">
                                        <label></label>
                                    </div>
                                </div>


                            </td>
                            <td width="140">
                                <div class="btn-inline">
                                    {{--<a href="{{route('p-product-gallery',$product->id)}}" class="btn btn-sm btn-info float-left mr-1"><i class="fa fa-image ml-1"></i>گالری</a> <a href="{{route('product-info',$product->slug)}}" target="_blank" class="btn btn-sm btn-info float-left mr-1"><i class="fa fa-eye ml-1"></i>پیشنمایش</a>--}}
                                    <a href="{{route('product-edit',$product->id)}}"
                                       class="btn btn-sm btn-info float-left mr-1"><i class="fa fa-edit ml-1"></i> Düzenle</a>

                                    {!! Form::open(['method' => 'DELETE', 'route' => ['product-destroy', $product->id] ]) !!}
                                    {!! Form::hidden('redirects_to', URL::previous()) !!}
                                    {!! Form::button('<i class="fa fa-ban ml-1"></i> Sil', ['type' => 'submit', 'class' => 'btn btn-danger float-left', 'onclick' => 'return confirm("آیا مطمئن هستید؟")']) !!}
                                    {!! Form::close() !!}
                                </div>
                                {{--<div class="btn-inline">--}}
                                    {{--@if($product->article!=null)--}}
                                        {{--<a href="{{route('product-del-article',$product->id)}}"--}}
                                           {{--class="btn btn-sm btn-danger float-left mr-1"><i--}}
                                                    {{--class="fa fa-ban ml-1"></i>حذف مقاله</a>--}}
                                    {{--@endif--}}
                                    {{--@if($product->video!=null)--}}
                                        {{--<a href="{{route('product-del-video',$product->id)}}"--}}
                                           {{--class="btn btn-sm btn-danger float-left mr-1"><i--}}
                                                    {{--class="fa fa-ban ml-1"></i>حذف ویدئو</a>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            </td>


                        </tr>
                    @endforeach
                    تعداد : {{$models_count}}
                </table>
            </div>
            <div class="paginate p-3">
                <a href="{{route('product-create')}}" class="btn btn-rounded btn-primary float-left"><i
                            class="fa fa-circle-o ml-1"></i>Eklemek</a>
                {{--{{ $products->links() }}--}}
            </div>
        </div>
    </div>
    <script>
        function alert1() {
            alert("Ürün gösterimi devre dışı");
        }

    </script>
@endsection
@push('scripts')

    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable({
                "order": [[ 0, "desc" ]]
            });

        } );
    </script>
@endpush

@endcomponent
