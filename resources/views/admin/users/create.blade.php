@extends('admin.layouts.app')
@section('content')
    <div id="admin-user-create-page">
        <div class="row">
            <div class="col-12">

                <div class="h1 mt-1">Create User</div>

                <form method="post" action="{{ route('admin.users.store') }}">
                    @csrf()
                    @include('admin.users._fields')
                    <button type="submit" class="btn btn-primary category-save-button">Create User</button>

                    <a href="{{ route('admin.users.index') }}" class="btn btn-default">Cancel</a>
                </form>


            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    var app = new Vue({
        el: '#admin-user-create-page',
        data: {
            user: {},
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