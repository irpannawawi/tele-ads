@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">

        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header"><i class="fas fa-file-alt"></i> Logs</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover table-bordered" id="logTable">
                                <thead >
                                    <tr>
                                        <th class="bg-dark text-center text-white">ID</th>
                                        <th class="bg-dark text-center text-white">User</th>
                                        <th class="bg-dark text-center text-white">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach($logs as $log)
                                        <tr>
                                            <th scope="row">{{$log->user->phone}}</th>
                                            <td>{{$log->user->first_name.' '.$log->user->last_name}} ({{ $log->user->username==null?'':'@'.$log->user->username }})</td>
                                            <td class="text-end">Membuka iklan {{ Illuminate\Support\Carbon::parse($log->created_at)->diffForHumans() }}</td>
                                        </tr>
                                    @endforeach --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#logTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('dt.logs') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'user',
                        name: 'user'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    }
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