@extends('avored-framework::layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
        <h1>
            <span class="main-title-wrap">{{ __('avored-framework::property.list') }}</span>
            <a style="" href="{{ route('admin.property.create') }}"
               class="btn btn-primary float-right">
                {{ __('avored-framework::property.create') }}
            </a>
        </h1>
        {!! DataGrid::render($dataGrid) !!}
    </div>
    </div>
@stop
