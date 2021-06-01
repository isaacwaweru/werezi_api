@extends('layouts.dashboard')

@section('content')
<!-- begin::page header -->
<div class="page-header">
    <h3>System Users</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
        </ol>
    </nav>
</div>
<!-- end::page header -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-head">
                    <h4 class="card-title">User Details</h4>
                </div>
                <div class="gaps-1x"></div>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Full Name</td>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <td>Phone Number</td>
                            <td>{{ $user->phone_number }}</td>
                        </tr>
                        <tr>
                            <td>Role</td>
                            <td>{{ $user->role }}</td>
                        </tr>
                        <tr>
                            <td>Actions</td>
                            <td>
                                @if($user->id != auth()->id())
                                <form
                                    action="{{ route('admin.users.destroy', $user->id) }}"
                                    method="post"
                                >
                                    {{ method_field('DELETE') }} {{ csrf_field()
                                    }}
                                    <button
                                        class="btn btn-danger btn-sm btn-auto"
                                    >
                                        Delete
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
