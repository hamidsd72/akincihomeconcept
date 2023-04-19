@component('layouts.back')
    @section('title') Eklemek @endsection
    @section('body')
        <style>
            .box-feature {
                background-color: #fbfbfb;
                padding: 20px;
                border: 1px solid #a3a3a3;
                margin-top: 1px;
            }

            .remover {
                float: left;
                color: red;
                font-size: 15px;
                cursor: pointer;
            }
        </style>
        <div class="card">
            <div class="card-header archive-card-header">
                <div class="archive-circle-wrap">
                    <div class="archive-circle">
                        <a href="/" target="_blank">

                            <img src="{{ panel_logo() }}" style="margin-top: 10px;">
                        </a>
                    </div>
                    <h2> Eklemek </h2>
                </div>
            </div>
            <div class="card-body">
                <div class="post">
                    {{ Form::open(array('route' => 'product-store', 'method' => 'PUT', 'files' => true)) }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-group-select">
                                {{ Form::label('category_id', 'Gruplama') }}

                                <select class="form-control" name="category_id">
                                    @foreach($categories as $key => $val)

                                        @include('component.select' , ['item' => $val, 'id' => -1])
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-select">
                                {{ Form::label('other_category', 'Çeşitli kategoriler') }}

                                <select class="form-control" name="other_category[]" multiple>
                                    @foreach($categories as $key => $val)

                                        @include('component.select' , ['item' => $val, 'id' => -1])
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-select">
                                {{ Form::label('brand_id', ' Marka') }}
                                <select class="form-control" name="brand_id">
                                    @foreach($brands as $key => $val)
                                        <optgroup label="{{$key}}">
                                            @foreach($val as $value)
                                                <option value="{{$value[0]}}">{{$value[1]}}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-select">
                                {{ Form::label('home_page', 'Ana Sayfayı Göster') }}
                                {{ Form::select('home_page',[0 => 'Gösterme'  , 1 => 'Göster'], '', array('class' => 'form-control')) }}

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group form-group-select">
                                {{ Form::label('show', 'Durum') }}
                                {{ Form::select('show',[0 => 'Gösterme'  , 1 => 'Göster'], null, array('class' => 'form-control')) }}

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('title', 'Ad') }}
                                {{ Form::text('title', '', array('class' => 'form-control')) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('slug', 'Slug') }}
                                {{ Form::text('slug', '', array('class' => 'form-control')) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('code', 'Ürün kodu') }}
                                {{ Form::text('code', null, array('class' => 'form-control')) }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('sort', 'Gösteri Aranjmanı') }}
                                {{ Form::text('sort', null, array('class' => 'form-control')) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('model_have', 'Modelı var') }}
                                {{ Form::checkbox('model_have',null,null, array('class' => 'form-control model_check')) }}
                            </div>
                        </div>
                        <div class="col-md-6 def_box">
                            <div class="form-group">
                                {{ Form::label('inventory_default', 'Ürün envanteri') }}
                                {{ Form::text('inventory_default', null, array('class' => 'form-control def_val')) }}
                            </div>
                        </div>
                        <div class="col-md-6 def_box">
                            <div class="form-group">
                                {{ Form::label('price_default', 'Ürün Fiyatı') }}
                                {{ Form::text('price_default', null, array('class' => 'form-control def_val')) }}
                            </div>
                        </div>
                        <div class="col-md-6 def_box">
                            <div class="form-group">
                                {{ Form::label('vip_default', 'İndirimli Fiyatı') }}
                                {{ Form::text('vip_default', null, array('class' => 'form-control def_val')) }}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Kısa açıklama</label>
                            <div class="form-group form-group-post">
                                {{ Form::textarea('short_text', '', array('class' => 'form-control ' , 'rows' => 2 )) }}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Ürün açıklaması ve incelemesi</label>
                            <div class="form-group form-group-post">
                                {{ Form::textarea('text', '', array('class' => 'form-control textarea')) }}
                            </div>
                        </div>
                        <div class="col-md-12 ">
                            <label>Öznitellikler</label>
                            <hr/>
                            <div class="col-md-12 text-left">
                                <button type="button" class="btn btn-info btn-add ">Ekle</button>
                            </div>
                            <div class="append-feature">
                                <div class="box-feature">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <i class="remover fa fa-close"></i>
                                        </div>
                                        <div class="col-md-6">
                                            {{ Form::label('feature[]', 'Unvan') }}
                                            {{ Form::text('feature[]', '', array('class' => 'form-control'  , 'required' => true)) }}
                                        </div>
                                        <div class="col-md-6">
                                            {{ Form::label('feature[]', 'miktarı') }}
                                            {{ Form::text('feature[]', '', array('class' => 'form-control' , 'required' => true)) }}
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <hr/>

                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('photo_large', '  Büyük resim  ') }}
                                {{ Form::file('photo_large', array('accept' => 'image/*')) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('photo_small', '  küçük resim  ') }}
                                {{ Form::file('photo_small', array('accept' => 'image/*')) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('pic_hover', '  fareyle üzerine gelin  ') }}
                                {{ Form::file('pic_hover', array('accept' => 'image/*')) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('gallery[]', ' Fotoğraf Galerisi  ') }}
                                {{ Form::file('gallery[]', array('accept' => 'image/*' , 'multiple' => true)) }}
                            </div>
                        </div>

                    </div>
                    <br/>
                    <a href="{{ URL::previous() }}" class="btn btn-rounded btn-secondary float-right"><i
                            class="fa fa-chevron-circle-right ml-1"></i>Geri</a>
                    {{ Form::button('<i class="fa fa-circle-o mtp-1 ml-1"></i>Ekle', array('type' => 'submit', 'class' => 'btn btn-rounded btn-primary float-left')) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    @endsection
    @push('scripts')
        <script src="{{ url('source/assets/editor/laravel-ckeditor/ckeditor.js') }}"></script>
        <script src="{{ url('source/assets/editor/laravel-ckeditor/adapters/jquery.js') }}"></script>
        <script type="text/javascript">


            $(document).ready(function () {
                $('.model_check').click(function () {

                    if(this.checked==true){
                        $(".def_val").prop('disabled', true);
                        $(".def_box").hide();
                    }else {
                        $(".def_val").prop('disabled', false);
                        $(".def_box").show();

                    }
                })

                var tag_feature = $('.box-feature').first().html();
                $('.btn-add').click(function () {
                    $('.append-feature').append('<div class="box-feature"> ' + tag_feature + ' </div>');

                    remover();
                });

                $('.remover').click(function () {
                    $(this).parent().parent().parent().remove();
                });
            });


            function remover() {
                $('.remover').click(function () {
                    $(this).parent().parent().parent().remove();
                });

            }


            var textareaOptions = {
                filebrowserImageBrowseUrl: '{{ url('filemanager?type=Images') }}',
                filebrowserImageUploadUrl: '{{ url('filemanager/upload?type=Images&_token=') }}',
                filebrowserBrowseUrl: '{{ url('filemanager?type=Files') }}',
                filebrowserUploadUrl: '{{ url('filemanager/upload?type=Files&_token=') }}',
                language: 'en'
            };
            $('.textarea').ckeditor(textareaOptions);
            slug('#title', '#slug');
        </script>
    @endpush
@endcomponent
