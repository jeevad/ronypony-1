@extends('admin.layouts.app')
@section('content')
    <div id="admin-user-groups-create-page">
        <div class="row">
            <div class="col-12">
                <div class="h1 mt-1">Create User Group</div>
                <form method="post" action="{{ route('admin.user-groups.store') }}">
                    @csrf()
                    @include('admin.groups._fields')
                    <button type="submit" class="btn btn-primary category-save-button">Create User Group</button>

                    <a href="{{ route('admin.roles.index') }}" class="btn btn-default">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    var app = new Vue({
        el: '#admin-user-groups-create-page',
        data: {
            user_groups: {},
            autofocus: true
        },
        methods: {
            changeModelValue: function (val, fieldName) {
                this.user_groups[fieldName] = val;
            }
        }
    });
</script>
@endpush