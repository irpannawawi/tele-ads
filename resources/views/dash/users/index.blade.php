@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title">
                            <i class="fab fa-telegram"></i> Telegram Users
                        </div>
                        <a href="{{ route('recalculate') }}" class="btn btn-sm btn-primary"
                            onclick="return confirm('Are you sure?')">Refresh</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover table-bordered" id="userTable">
                                <thead>
                                    <tr>
                                        <th class="bg-dark text-center text-white">#</th>
                                        <th class="bg-dark text-center text-white">Registered At</th>
                                        <th class="bg-dark text-center text-white">ID</th>
                                        <th class="bg-dark text-center text-white">User</th>
                                        <th class="bg-dark text-center text-white">All time Ads</th>
                                        <th class="bg-dark text-center text-white">Today Ad's Watched</th>
                                        <th class="bg-dark text-center text-white">Current Point</th>
                                        <th class="bg-dark text-center text-white">Withdrawn</th>
                                        <th class="bg-dark text-center text-white">Status</th>
                                        <th class="bg-dark text-center text-white">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                {{-- <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <th scope="row">{{ $user->id }}</th>
                                            <th scope="row">
                                                {{ Illuminate\Support\Carbon::parse($user->created_at)->format('d-m-Y h:i') }}
                                            </th>
                                            <th scope="row">{{ $user->phone }}</th>
                                            <td>{{ $user->first_name . ' ' . $user->last_name }}
                                                ({{ $user->username == null ? '' : '@' . $user->username }})
                                            </td>
                                            <td>{{ $user->log->count() }}</td>
                                            <td>{{ $user->watched_ads_count }}</td>
                                            <td class="text-end">
                                                {{ $user->earned_points }}
                                            </td>
                                            <td class="text-end">
                                                {{ $user->total_withdraw }}
                                            </td>
                                            @php
                                                $status = $user->status;
                                                $label = $status != 'suspended' ? 'success' : 'danger';
                                            @endphp
                                            <td class="text-center ">
                                                @if ($user->status == 'suspended')
                                                    <a class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Do you want to activate user?')"
                                                        href="{{ route('users.activate', $user->id) }}">Suspended</a>
                                                @else
                                                    <a class="btn btn-sm btn-success"
                                                        onclick="return confirm('Do you want to suspend user?')"
                                                        href="{{ route('users.suspend', $user->id) }}">Active</a>
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('users.destroy', ['id' => $user->phone]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-success"
                                                            onclick="changegiftId({{ $user->id }})" data-toggle="modal"
                                                            data-target="#giftModal"><i class="fa fa-gift"></i></button>
                                                        <a class="btn btn-sm btn-warning"
                                                            onclick="return confirm('Are you sure?')"
                                                            href="{{ route('users.reset', $user->id) }}">Reset</a>
                                                        <button class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure?')"><i
                                                                class="fa fa-trash"></i></button>

                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody> --}}
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- @include('dash.users.gift-modal') --}}
    <script>
        function changegiftId(id) {
            $('#gift_user_id').val(id);
        }
    </script>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#userTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('dt.users') }}",
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'phone',
                            name: 'phone'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'watched_ads_count',
                            name: 'watched_ads_count'
                        },
                        {
                            data: 'today_watched',
                            name: 'today_watched'
                        },
                        {
                            data: 'earned_points',
                            name: 'earned_points'
                        },
                        {
                            data: 'total_withdraw',
                            name: 'total_withdraw'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        },
                    ],
                    order: [
                        [0, 'desc']
                    ],
                    pageLength: 25,

                });
            });
        </script>
    @endpush
@endsection
