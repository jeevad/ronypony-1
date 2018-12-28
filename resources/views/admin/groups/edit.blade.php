@extends('admin.layouts.app')

@section('content')
    <div id="admin-user-groups-edit-page">
        <div class="row">
            <div class="col-12">
                <div class="h1 mt-1">Edit User Group</div>

                <form action="{{ route('admin.user-groups.update', $model->id) }}" method="post">
                    @csrf()
                    @method('put')
                    @include('admin.groups._fields')
                    <button type="submit" class="btn n btn-primary  user-group-save-button">Edit User Group</button>

                    <a href="{{ route('admin.user-groups.index') }}" class="btn btn-default">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    var app = new Vue({
        el: '#admin-user-groups-edit-page',
        data: {
            user_groups: {!! $model !!},
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