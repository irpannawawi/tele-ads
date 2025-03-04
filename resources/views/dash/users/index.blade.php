@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header"><i class="fab fa-telegram"></i> Telegram Users</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover table-bordered datatable-desc">
                                <thead>
                                    <tr>
                                        <th class="bg-dark text-center text-white">#</th>
                                        <th class="bg-dark text-center text-white">ID</th>
                                        <th class="bg-dark text-center text-white">User</th>
                                        <th class="bg-dark text-center text-white">Today Ad's Watched</th>
                                        <th class="bg-dark text-center text-white">Current Point</th>
                                        <th class="bg-dark text-center text-white">Withdrawn</th>
                                        <th class="bg-dark text-center text-white">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <th scope="row">{{ $user->id }}</th>
                                            <th scope="row">{{ $user->phone }}</th>
                                            <td>{{ $user->first_name . ' ' . $user->last_name }}
                                                ({{ $user->username == null ? '' : '@' . $user->username }})</td>
                                            <td>{{ $user->watched_ads_count }}</td>
                                            <td class="text-end">Rp. {{ number_format($user->earned_points, 0, ',', '.') }},-
                                            </td>
                                            <td class="text-end">Rp.{{ number_format($user->total_withdraw, 0, ',', '.') }},-
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-sm btn-success"
                                                        onclick="changegiftId({{ $user->id }})" data-toggle="modal"
                                                        data-target="#giftModal"><i class="fa fa-gift"></i></button>
                                                    <a class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure?')"
                                                        href="{{ route('users.reset', $user->id) }}">Reset</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('dash.users.gift-modal')
    <script>
        function changegiftId(id) {
            $('#gift_user_id').val(id);
        }
    </script>
@endsection
