@extends('admin.layouts.app')
@section('content')
    <div id="admin-roles-create-page">
        <div class="row">
            <div class="col-12">
                <div class="h1 mt-1">Create Role</div>
                <form method="post" action="{{ route('admin.roles.store') }}">
                    @csrf()
                    @include('admin.roles._fields')
                    <button type="submit" class="btn btn-primary category-save-button">Create Role</button>

                    <a href="{{ route('admin.roles.index') }}" class="btn btn-default">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    var app = new Vue({
        el: '#admin-roles-create-page',
        data: {
            role: {},
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