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
            select.form-control:not([size]):not([multiple]) {
                display: none;
            }
            .select2-results__options {
                background: wheat !important;
                max-height: 400px;
                overflow: auto;
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
                    {{ Form::open(array('route' => 'dashboard-store-factor', 'method' => 'POST', 'files' => true)) }}
                        <div class="row">
                            <div class="col-lg-auto mb-4">
                                <div class="form-group form-group-select">
                                    {{ Form::label('user_id', 'kullanıcı *') }}
                                    <select class="form-control select2" name="user_id">
                                        @foreach($users as $u => $user)
                                            <option value="{{$user->id}}">{{$user->first_name.' '.$user->last_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12"></div>

                            <div class="col-lg-6 col-md-6">
                                <div class="form-group form-group-select">
                                    {{ Form::label('product_id', 'ürün *') }}
                                    <select class="form-control select2 d_product_id" name="product_id">
                                        @foreach($products as $p => $product)
                                            <option value="{{$product->id}}">{{$product->title.' - T'.$product->price}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-auto col-md-6">
                                <div class="form-group">
                                    {{ Form::label('count', 'saymak *') }}
                                    {{ Form::number('count', 1, ['class' => 'form-control d_count']) }}
                                </div>
                            </div>
                            <div class="col-lg-auto col-12">
                                <div class="form-group">
                                    <div><a href="javascript:void(0);" class="btn btn-info" onclick="appendForm()">Faturaya ürün ekle *</a></div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="factors row mb-5"></div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('post_price', 'fiyat sonrası *') }}
                                    {{ Form::number('post_price', 0, ['class' => 'form-control']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('pay_mode', '  ödeme modeli *') }}
                                    <select class="form-control select2" name="pay_mode">
                                        <option value="payent">payent</option>
                                        <option value="iyzico">iyzico</option>
                                    </select>
                                </div>
                            </div>

                            {{ Form::hidden('total', 0, ['class' => 'form-control d_total']) }}

                        </div>
                        <br/>
                        <a href="{{ URL::previous() }}" class="btn btn-rounded btn-secondary float-right"><i class="fa fa-chevron-circle-right ml-1"></i>Geri</a>
                        {{ Form::button('<i class="fa fa-circle-o mtp-1 ml-1"></i>Ekle', array('type' => 'submit', 'class' => 'btn btn-rounded btn-primary float-left')) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    @endsection
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="{{ url('source/assets/editor/laravel-ckeditor/ckeditor.js') }}"></script>
        <script src="{{ url('source/assets/editor/laravel-ckeditor/adapters/jquery.js') }}"></script>

        <script>
            let numberLastForm  = 0;
            function appendForm() {
                let d_product_id    = document.querySelector('.d_product_id').value;
                let d_count         = document.querySelector('.d_count').value;

                numberLastForm += 1;
                let row     = document.querySelector('.factors')
                let endItem = document.createElement('div')
                endItem.setAttribute('class', 'col-12 border my-3')
                row.append(endItem)

                // product_id
                let div1    = document.createElement('div')
                div1.setAttribute('class', 'col-lg-6')
                row.append(div1)

                let div2    = document.createElement('div')
                div2.setAttribute('class', 'col-lg-6')
                row.append(div2)

                // count
                // label
                let label1  = document.createElement('label')
                label1.setAttribute('for', `p_id${numberLastForm}`)
                label1.innerHTML = 'barkod'
                div1.append(label1)
                // product id
                let input1  = document.createElement('input')
                input1.setAttribute('name', `p_id${numberLastForm}`)
                input1.setAttribute('class', 'form-control')
                input1.setAttribute('value', d_product_id)
                div1.append(input1)

                // label
                let label2 = document.createElement('label')
                label2.setAttribute('for', `c_id${numberLastForm}`)
                label2.innerHTML = 'ürün sayısı'
                div2.append(label2)
                // count
                let input2 = document.createElement('input')
                input2.setAttribute('name', `c_id${numberLastForm}`)
                input2.setAttribute('class', 'form-control')
                input2.setAttribute('value', d_count)
                div2.append(input2)

                document.querySelector('.d_total').value  = parseInt(numberLastForm)
            }

            $(document).ready(function() {
                $('.select2').select2();
            });

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
