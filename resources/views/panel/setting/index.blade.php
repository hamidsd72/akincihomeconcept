@component('layouts.back')

    @slot('title') مدیریت {{ $title }} @endslot

    @slot('body')
ddddd
        <div class="card">

            <div class="card-header archive-card-header">

                <div class="archive-circle-wrap">

                    <div class="archive-circle">
                        <a href="/" target="_blank">

                            <img src="{{ panel_logo() }}" style="margin-top: 10px;">
                        </a>
                    </div>

                    <h2>لیست {{ $title }}</h2>

                </div>

            </div>

            <div class="card-body">

                {{ Form::model($settings, ['route' => array('settingsUpdate', $settings->id), 'method' => 'post' , 'files' => true]) }}

                <div class="form-group">

                    {{ Form::label('title', 'Site Başlığı') }}

                    {{ Form::text('title', null, array('class' => 'form-control')) }}

                </div>

                <div class="form-group">

                    {{ Form::label('keywords', 'کلمات کلیدی') }}

                    {{ Form::text('keywords', null, array('class' => 'form-control')) }}

                </div>

                <div class="form-group">

                    {{ Form::label('description', 'توضیحات') }}

                    {{ Form::text('description', null, array('class' => 'form-control')) }}

                </div>

                <div class="form-group">

                    {{ Form::label('paginate', 'تعداد صفحه بندی') }}

                    {{ Form::text('paginate', null, array('class' => 'form-control')) }}

                </div>

                <div class="form-group">

                    {{ Form::label('link1', 'تنظیمات صفحه اصلی لینک اول') }}

                    {{ Form::text('link1', null, array('class' => 'form-control')) }}

                </div>

                <div class="form-group">

                    {{ Form::label('link2', 'تنظیمات صفحه اصلی لینک دوم') }}

                    {{ Form::text('link2', null, array('class' => 'form-control')) }}

                </div>

                <div class="form-group">

                    {{ Form::label('about', 'توضیحات درباره ما') }}

                    <div class="form-group form-group-post">

                        {{ Form::textarea('about', json_decode($settings->about), array('class' => 'form-control textarea')) }}

                    </div>

                </div>

                <div class="form-group">

                    {{ Form::label('photo', 'تصویر درباره ما') }}

                    {{ Form::file('photo', array('accept' => 'image/*')) }}

                </div>

                <div class="form-group">

                    {{ Form::label('photo', 'تصویر فعال') }}

                    <img src="{{url($settings->about_pic)}}">

                </div>

                <br/>

                <a href="{{ URL::previous() }}" class="btn btn-rounded btn-secondary float-right"><i class="fa fa-chevron-circle-right ml-1"></i>بازگشت</a>

                {{ Form::button('<i class="fa fa-circle-o mtp-1 ml-1"></i>ویرایش', array('type' => 'submit', 'class' => 'btn btn-rounded btn-primary float-left')) }}

                {{ Form::close() }}

            </div>

        </div>

    @endslot

    @push('scripts')

        <script src="{{ url('source/assets/editor/laravel-ckeditor/ckeditor.js') }}"></script>

        <script src="{{ url('source/assets/editor/laravel-ckeditor/adapters/jquery.js') }}"></script>

        <script type="text/javascript">

            var textareaOptions = {

                filebrowserImageBrowseUrl: '{{ url('filemanager?type=Images') }}',

                filebrowserImageUploadUrl: '{{ url('filemanager/upload?type=Images&_token=') }}',

                filebrowserBrowseUrl: '{{ url('filemanager?type=Files') }}',

                filebrowserUploadUrl: '{{ url('filemanager/upload?type=Files&_token=') }}',

                language: 'fa'

            };

            $('.textarea').ckeditor(textareaOptions);

            slug('#title', '#slug');
        </script>

    @endpush



@endcomponent