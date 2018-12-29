@extends('admin.layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            User Details
        </div>
        <div class="card-body table-bordered">
            <table class="table">
                <tr>
                    <td>Name</td>
                    <td>{{ $user->full_name }}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <td>Mobile Number</td>
                    <td>@if($user->mobile_number) {{ $user->mobile_number }} @else -- @endif</td>
                </tr>
                <tr>
                    <td>Registered on</td>
                    <td>{{ $user->created_at }}</td>
                </tr>
                <tr>
                    <td>Role</td>
                    <td>{{ $user->role->name }}</td>
                </tr>
                <tr>
                    <td>Group</td>
                    <td>{{ $user->group->name }}, {{$user->group->discount_type}}, {{ $user->group->discount }} @if ($user->group->discount_type === 'PERCENTAGE') % @endif</td>
                </tr>
                <tr>
                    <td>Avatar</td>
                    <td><img src="{{ $user->avatarURL() }}" /></td>
                </tr>
                <tr>
                    <td>Email Verified on</td>
                    <td>@if($user->email_verified_at) {{ $user->email_verified_at }} @else -- @endif</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>{{ $user->status() }}</td>
                </tr>
            </table>
            <div class="float-left">
                <form method="post" action="{{ route('admin.users.destroy', $user->id)  }}">
                    @csrf()
                    @method('delete')
                    <button
                            onClick="event.preventDefault();
                                    swal({
                                        dangerMode: true,
                                        title: 'Are you sure?',
                                        icon: 'warning',
                                        buttons: true,
                                        text: 'Once deleted, you will not be able to recover this User!',
                                    }).then((willDelete) => {
                                        if (willDelete) {
                                            jQuery(this).parents('form:first').submit();
                                        }
                                    });"
                            class="btn btn-danger">
                        Destroy
                    </button>
                </form>
            </div>
            <a class="btn" href="{{ route('admin.users.index') }}">Cancel</a>
        </div>
    </div>
@stop