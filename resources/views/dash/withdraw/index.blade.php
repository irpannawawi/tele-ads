@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">

        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header"><i class="fab fa-telegram"></i> Withdraw Request</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover table-bordered table-striped datatable">
                                <thead >
                                    <tr>
                                        <th class="bg-dark text-center text-white">ID</th>
                                        <th class="bg-dark text-center text-white">User</th>
                                        <th class="bg-dark text-center text-white">Phone Address</th>
                                        <th class="bg-dark text-center text-white">Amout</th>
                                        <th class="bg-dark text-center text-white">Status</th>
                                        <th class="bg-dark text-center text-white">Request Date</th>
                                        <th class="bg-dark text-center text-white">Updated At</th>
                                        <th class="bg-dark text-center text-white">Action</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 14px">
                                    @foreach($wd_requests as $item)
                                        <tr>
                                            <th>{{$loop->iteration}}</th>
                                            <th scope="row">{{$item->user->first_name.' '.$item->user->last_name}} ({{ $item->user->username==null?'':'@'.$item->user->username }})</th>
                                            <td>{{$item->address}} ({{$item->method}})</td>
                                            <td class="text-end">Rp. {{ number_format($item->amount, 0, ',','.')}},-</td>

                                            @php
                                                $status = $item->status;
                                                switch ($status) {
                                                    case 'pending':
                                                        $status = 'warning';
                                                        break;
                                                    case 'approved':
                                                        $status = 'success';
                                                        break;
                                                    case 'rejected':
                                                        $status = 'danger';
                                                        break;
                                                }
                                            @endphp
                                            <td class="text-end"><span class="badge text-white bg-{{ $status }}">{{ $item->status }}</span></td>
                                            <td>{{date('d M Y H:i   ', strtotime($item->created_at))}}</td>
                                            <td>{{$item->updated_at==$item->created_at?'-':date('d M Y H:i   ', strtotime($item->updated_at))}}</td>
                                            
                                            <td class="text-end">
                                                <div class="btn-group {{ $item->status!='pending'?'d-none':''}}">
                                                    <a href="{{route('withdraw.approve',[$item->id])}}" class="btn btn-success btn-sm" onclick="return confirm('Are you sure?')"><i class="fas fa-check"></i></a>
                                                    <button class="btn btn-danger btn-sm" onclick="reject({{$item->id}})" data-toggle="modal" data-target="#rejectModal"><i class="fas fa-times"></i></button>
                                                </div>
                                                @if($item->status=='approved')
                                                <a href="{{ route('withdraw.resend',[$item->id]) }}" class="btn btn-info btn-sm" onclick="return confirm('Are you sure?') }}"><i class="fa fa-paper-plane"></i></a>
                                                @endif
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


  <!-- Modal -->
  <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="rejectModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('withdraw.reject') }}" method="POST">
            @csrf
            <input type="text" name="id" id="id-wd" hidden="true">
            <textarea name="reason" id="reason" class="form-control"></textarea>
            <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox" value="true" name="refund" id="refundCheckbox">
                <label class="form-check-label" for="refundCheckbox">
                  Refund Balance
                </label>
              </div>
            <button type="submit" class="btn btn-primary mt-2">Send</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    function reject(id) {
      $('#rejectModal').modal('show');
      $('#id-wd').val(id);
    }
  </script>
@endsection