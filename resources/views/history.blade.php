@extends('layouts.public')

@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    {{-- button --}}
    <style>
        #loader {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
@endpush
@section('content')
    
    <div class="d-flex flex-column align-items-center mt-1 pt-4 overflow-auto bg-dark-op75 text-white table-responsive rounded-4"
        style="height: 500px; padding-left: 10px; ">
        <h1 class="h3 mb-1 text-white text-center">Withdraw History</h1>
        <table class="table table-hover ">
            <thead>
                <tr class="bg-dark">
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="list-withdraw-history">
                <div id="loader" class="d-none">
                    <div class="spinner-border text-light" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </tbody>
        </table>
    </div>

    <script defer>
        function showLoader() {
            document.getElementById('loader').classList.remove('d-none');
        }
        showLoader();

        function hideLoader() {
            document.getElementById('loader').classList.add('d-none');
        }
        document.addEventListener('DOMContentLoaded', () => {
            fetch("{{ route('getWithdrawHistory') }}", {
                method: "POST",
                dataType: "json",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "Access-Control-Allow-Origin": "*",
                },
                body: JSON.stringify({
                    id: userData?.id,
                })
            }).then(response => response.json()).then(data => {
                console.log(data);
                var list = '';
                for (let i = 0; i < data.length; i++) {
                    status = data[i].status
                    if (status == 'pending') {
                        label = 'warning'
                    } else if (status == 'approved') {
                        label = 'success'
                    } else {
                        label = 'danger'
                    }
                    list += `<tr>
                            <td>${new Date(data[i].created_at).toLocaleString()}</td>
                            <td nowrap>Rp. ${new Intl.NumberFormat('id-ID', { style: 'decimal' }).format(data[i].amount)}</td>
                            <td class="text-${label}">${data[i].status}</td>
                            </tr>`;
                }
                hideLoader();
                document.getElementById('list-withdraw-history').innerHTML = list;
                $('table').DataTable({
                    "order": [
                        [0, "desc"]
                    ],
                    "lengthChange": false
                });
            })
        });
    </script>


@endsection
@push('js')
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>

@endpush