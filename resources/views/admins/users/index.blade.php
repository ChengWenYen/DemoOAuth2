@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Users Management</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-inline-flex align-items-center">
                                <h3 class="card-title">Users</h3>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-capitalize">No.</th>
                                        <th class="text-capitalize">Channel</th>
                                        <th class="text-capitalize">Name</th>
                                        <th class="text-capitalize">Picture</th>
                                        <th class="text-capitalize">Email</th>
                                        <th class="text-capitalize">Subscription</th>
                                        <th class="text-capitalize">Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($users->total() == 0)
                                        <tr>
                                            <td colspan="6" class="text-center">No data.</td>
                                        </tr>
                                    @else
                                        @foreach ($users as $index => $user)
                                            <tr>
                                                <td>
                                                    {{ ($users->currentPage()-1) * $users->perPage() + ($index+1) }}
                                                </td>
                                                <td>
                                                    {{ $user->channel }}
                                                </td>
                                                <td>
                                                    {{ $user->name }}
                                                </td>
                                                <td>
                                                    <img src="{{ $user->picture }}" class="img-circle elevation-2" style="width: 40px; height: 40px;" alt="User Image">
                                                </td>
                                                <td>
                                                    {{ $user->email }}
                                                </td>
                                                <td>
                                                    @if (!is_null($user->notify_access_token))
                                                        <span class="badge badge-info">Active</span>
                                                    @else
                                                        &nbsp;
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $user->created_at }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        {{ $users->links('layouts.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
