@component('layouts.back')
    @section('title') {{$title}} @endsection
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
                {{ Form::open(array('route' => 'dashboard-user-store', 'method' => 'POST','files' => true)) }}
                    <div class="form-group">
                        {{ Form::label('first_name', 'isim *') }}
                        {{ Form::text('first_name', null, array('class' => 'form-control' ,'required' => 'required')) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('last_name', 'Soyadı *') }}
                        {{ Form::text('last_name', null, array('class' => 'form-control' ,'required' => 'required')) }}
                    </div>

                    <div class="form-group">
                        {{ Form::label('email', 'E-posta adresi *') }}
                        {{ Form::email('email', null, array('class' => 'form-control' ,'required' => 'required')) }}
                    </div>
                    <div class="form-group form-group-select">
                        {{ Form::label('mobile', 'Telefon numarası *') }}
                        {{ Form::text('mobile', null, array('class' => 'form-control' ,'required' => 'required')) }}
                    </div>
                    <div class="form-group form-group-select">
                        {{ Form::label('address', 'Adres') }}
                        {{ Form::text('address', null, array('class' => 'form-control')) }}
                    </div>
                    
                    <div class="form-group form-group-select">
                        {{ Form::label('password', 'Parola *') }}
                        {{ Form::text('password', null, array('class' => 'form-control' ,'required' => 'required', 'minlength' => '8')) }}
                    </div>

                    <div class="form-group form-group-select">
                        {{ Form::label('password_confirmation', 'Şifreyi tekrar girin *') }}
                        {{ Form::text('password_confirmation', null, array('class' => 'form-control' ,'required' => 'required', 'minlength' => '8')) }}
                    </div>

                    <br/>
                    <a href="{{ URL::previous() }}" class="btn btn-rounded btn-secondary float-right"><i class="fa fa-chevron-circle-right ml-1"></i>Geri</a>
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
