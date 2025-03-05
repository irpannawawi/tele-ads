@extends('layouts.public')

@section('content')
        {{-- button --}}

        <div class="d-flex flex-column align-items-center mt-1 pt-4 overflow-auto " style="height: 400px;">
            <h1 class="h3 mb-1 text-white text-center">Withdraw History</h1>    
            <table class="table table-sm table-hover table-bordered datatable-desc">
                <thead >
                    <tr class="bg-dark">
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="list-withdraw-history">
                </tbody>
            </table>
        </div>

        <script defer>
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
                        }else if (status == 'approved') {
                            label = 'success'
                        }else {
                            label = 'danger'
                        }
                        list += `<tr>
                            <td>${new Date(data[i].created_at).toLocaleString()}</td>
                            <td nowrap>Rp. ${new Intl.NumberFormat('id-ID', { style: 'decimal' }).format(data[i].amount)}</td>
                            <td class="text-${label}">${data[i].status}</td>
                            </tr>`;
                        }
                        document.getElementById('list-withdraw-history').innerHTML = list;
                    })
                });
                
        </script>
@endsection