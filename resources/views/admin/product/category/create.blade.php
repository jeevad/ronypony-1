@extends('admin.layouts.app')


@section('content')
<div id="admin-category-create-page">
    <div class="row">
        <div class="col-12">

            <div class="h1 mt-1">Create Category</div>

            <form method="post" action="{{ route('admin.category.store') }}">
                    @csrf()
                    @include('admin.product.category._fields')
                

                <button type="submit"  class="btn btn-primary category-save-button">Create Category</button>

                <a href="{{ route('admin.category.index') }}" class="btn btn-default">Cancel</a>
            </form>


        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
 var app = new Vue({
        el: '#admin-category-create-page',
        data : {
            category: {},
            autofocus:true
        },
        methods: {
            changeModelValue: function(val,fieldName) {
                this.category[fieldName] = val;
            }
        }
    });
</script>


@endpush