@component('layouts.back')
    @section('title') Eklemek @endsection
    @section('body')
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
                {{ Form::open(array('route' => 'category-store', 'method' => 'PUT','files' => true)) }}
                <div class="form-group">
                    {{ Form::label('name', 'Ad') }}
                    {{ Form::text('name', '', array('class' => 'form-control')) }}
                </div>
                <div class="form-group">
                    {{ Form::label('slug', 'Slug') }}
                    {{ Form::text('slug', '', array('class' => 'form-control')) }}
                </div>
                <div class="form-group">
                    {{ Form::label('start_price', 'Başlangıç ​​fiyatı') }}
                    {{ Form::text('start_price', '', array('class' => 'form-control')) }}
                </div>
                <div class="form-group form-group-select">
                    {{ Form::label('active', 'Menüde göster') }}
                    {{ Form::select('menu_status', array('canceled'=>'gösterme','active'=>'göster'), null, array('class' => 'form-control')) }}
                </div>
                <div class="form-group">
                    {{ Form::label('menu_sort_id', 'Menü ekranını düzenleyin') }}
                    {{ Form::text('menu_sort_id', '', array('class' => 'form-control')) }}
                </div>

                <div class="form-group form-group-select">
                    {{ Form::label('slider_type', 'kaydırıcı türü') }}
                    {{ Form::select('slider_type', array('1'=>'Bir sütun','2'=>'iki sütun'), null, array('class' => 'form-control')) }}
                </div>

                <div class="form-group form-group-select">
                    {{ Form::label('home_status', 'Ana ekranda göster') }}
                    {{ Form::select('home_status', array('no_active'=>'gösterme','active'=>'göster'), null, array('class' => 'form-control')) }}
                </div>
                <div class="form-group form-group-select">
                    {{ Form::label('home_status_top', 'Ana ekranda göster (kaydırıcının altında)') }}
                    {{ Form::select('home_status_top', array('no_active'=>'gösterme','active'=>'göster'), null, array('class' => 'form-control')) }}
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        {{ Form::label('photo', 'Fotoğraf') }}
                        {{ Form::file('photo', array('accept' => 'image/*')) }}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        {{ Form::label('icon', 'İcon') }}
                        {{ Form::file('icon', array('accept' => 'image/png')) }}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        {{ Form::label('menu_pic', 'Menü içindeki resim') }}
                        {{ Form::file('menu_pic', array('accept' => 'image/*')) }}
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        {{ Form::label('gallery[]', 'Fotoğraf Galerisi') }}
                        {{ Form::file('gallery[]', array('accept' => 'image/*' , 'multiple' => true)) }}
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        {{ Form::label('gallery_2[]', 'Fotoğraf Galerisi(küçük)') }}
                        {{ Form::file('gallery_2[]', array('accept' => 'image/*' , 'multiple' => true)) }}
                    </div>
                </div>



                <br/>
                <a href="{{ URL::previous() }}" class="btn btn-rounded btn-secondary float-right"><i
                            class="fa fa-chevron-circle-right ml-1"></i>Geri</a>
                {{ Form::button('<i class="fa fa-circle-o mtp-1 ml-1"></i>Ekle', array('type' => 'submit', 'class' => 'btn btn-rounded btn-primary float-left')) }}
                {{ Form::close() }}
            </div>
        </div>
    @endsection
    @push('scripts')
        <script type="text/javascript">
            slug('#name', '#slug');
        </script>
    @endpush
@endcomponent