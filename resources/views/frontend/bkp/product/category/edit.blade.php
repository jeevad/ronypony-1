@extends('admin.layouts.app')

@section('content')
<div id="admin-category-edit-page">
    <div class="row">
        <div class="col-12">
            <div class="h1 mt-1">Edit Category</div>

            <form action="{{ route('admin.category.update', $model->id) }}" method="post">
                @csrf()
                @method('put')
                @include('admin.product.category._fields')
                <button type="submit"  class="btn n btn-primary  category-save-button">Edit Category</button>

                <a href="{{ route('admin.category.index') }}" class="btn btn-default">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script>

 var app = new Vue({
        el: '#admin-category-edit-page',
        data : {
            category: {!! $model !!},
            autofocus: true
        },
        methods: {
            changeModelValue: function(val,fieldName) {
                this.category[fieldName] = val;
            }
        }
    });

</script>


@endpush