@component('layouts.back')
    @section('title')Yönetim @endsection
    @section('body')
        <div class="card">
            <div class="card-header archive-card-header">
                <div class="archive-circle-wrap">
                    <div class="archive-circle">
                        <a href="/" target="_blank">

                            <img src="{{ panel_logo() }}" style="margin-top: 10px;">
                        </a>
                    </div>
                    <h2>liste</h2>
                </div>
            </div>
            <div class="card-body">
                <div class="dd">
                    <ol class="dd-list">
                        @foreach($categories as $category)
                            <li class="dd-item" data-id="{{ $category->id }}">
                                <div class="dd-handle">{{ $category->name }}</div>
                                <div class="btn-inline">
                                    <a href="{{ route('category-edit', $category->id) }}" class="btn float-left mr-1"><i class="fa fa-edit ml-1"></i>Düzenle</a>
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['category-destroy', $category->id] ]) !!}
                                    @if(!count($category->children))
                                        {!! Form::button('<i class="fa fa-ban ml-1"></i>Sil', ['type' => 'submit', 'class' => 'btn btn-danger float-left', 'onclick' => 'return confirm("Emin misin ?")']) !!}
                                    @endif
                                    {!! Form::close() !!}
                                </div>
                                @include('panel.categories.each', $category)
                            </li>
                        @endforeach
                            <div class="paginate p-3">

                                <a href="{{ route('category-create') }}" class="btn btn-rounded btn-primary float-left"><i class="fa fa-circle-o ml-1"></i>ekle</a>
                                {{-- {{$categories->appends(Request::except('page'))->links("pagination::bootstrap-4")}} --}}

                            </div>

                    </ol>
                </div>
            </div>
        </div>
    @endsection
    @push('scripts')
        <script type="text/javascript" src="{{ asset('source/assets/js/easing.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('source/assets/js/nestable.min.js') }}"></script>
        <script type="text/javascript">
            $('.dd').nestable();
            $('.dd').on('change', function () {
                $.post('{{ route('category-sort') }}', {
                    sort: JSON.stringify($('.dd').nestable('serialize')),
                    _token: '{{ csrf_token() }}'
                }, function () {
                    $.jGrowl('Kayit oldu', {life: 3000, position: 'bottom-right', theme: 'bg-success'});
                });
            });
        </script>
    @endpush
@endcomponent