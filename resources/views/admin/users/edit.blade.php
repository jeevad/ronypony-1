@extends('admin.layouts.app')
@section('content')
    <div id="admin-user-edit-page">
        <div class="row">
            <div class="col-12">
                <div class="h1 mt-1">Edit User</div>
                <form action="{{ route('admin.users.update', $model->id) }}" method="post">
                    @csrf()
                    @method('put')
                    @include('admin.users._fields')
                    <button type="submit" class="btn n btn-primary  category-save-button">Edit User</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-default">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

<script>
    var app = new Vue({
        el: '#admin-user-edit-page',
        data: {
            user: {!! $model !!},
            autofocus: true
        },
        methods: {
            changeModelValue: function (val, fieldName) {
                this.user[fieldName] = val;
            }
        }
    });
</script>
@endpush