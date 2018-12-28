@extends('admin.layouts.app')

@section('content')
    <div id="admin-roles-edit-page">
        <div class="row">
            <div class="col-12">
                <div class="h1 mt-1">Edit Role</div>

                <form action="{{ route('admin.roles.update', $model->id) }}" method="post">
                    @csrf()
                    @method('put')
                    @include('admin.roles._fields')
                    <button type="submit" class="btn n btn-primary  role-save-button">Edit Role</button>

                    <a href="{{ route('admin.roles.index') }}" class="btn btn-default">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    var app = new Vue({
        el: '#admin-roles-edit-page',
        data: {
            role: {!! $model !!},
            autofocus: true
        },
        methods: {
            changeModelValue: function (val, fieldName) {
                this.role[fieldName] = val;
            }
        }
    });
</script>
@endpush