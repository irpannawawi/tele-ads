@extends('layouts.public')

@section('content')
    {{-- button --}}
    <div class="d-flex justify-content-center align-items-center mt-1 pt-4">
        <div class="col card bg-dark-op75 rounded-5">
            <div class="card-body text-white fs-6" id="withdrawal-form">
                <form action="{{ route('user.requestWithdraw') }}" method="POST">
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-12">
                            <h3 class="text-center">Penarikan Saldo</h3>
                            <p class="text-center">Minimal Penarikan: Rp {{ env('MIN_WITHDRAW_POINTS') }} <br> Tersedia: <span id="available-withdrawal"></span></p>
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="nominal">Nominal Penarikan</label>
                        <input type="number" min="{{ env('MIN_WITHDRAW_POINTS') }}" class="form-control rounded-pill" id="nominal"
                            placeholder="Masukkan nominal" name="amount" value="{{ old('nominal') }}" required>
                        <input type="hidden" name="id" id="id" value="">
                    </div>
                    <div class="form-group mb-2">
                        <label for="metode">Metode Penarikan</label>
                        <select class="form-control rounded-pill" id="metode" name="method" required>
                            <option {{ old('metode') == 'dana' ? 'selected' : '' }} value="Dana">Dana</option>
                            <option {{ old('metode') == 'ovo' ? 'selected' : '' }} value="Ovo">Ovo</option>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="tujuan">Nomor Tujuan</label>
                        <input type="number" class="form-control rounded-pill" id="tujuan" placeholder="Masukkan nomor tujuan"
                            name="address" value="{{ old('tujuan') }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-2 rounded-pill disabled" id="btnSubmit">Tarik</button>
                </form>
            </div>
        </div>
    </div>

    <script defer>
        document.addEventListener('DOMContentLoaded', () => {

            // Access user data
            fetch("{{ url('/') }}" + "/api/user/" + userData.id, {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "Access-Control-Allow-Origin": "*",
                }
            }).then(response => response.json()).then(data => {
                if (data.user.status == 'suspended') {
                    document.getElementById('withdrawal-form').innerHTML = '';
                    document.getElementById('withdrawal-form').style.display = 'none';
                }
                let userId = document.getElementById("id");
                let availableWithdrawal = document.getElementById("available-withdrawal");
                availableWithdrawal.textContent = formatNumberShort(data.user.earned_points);
                userId.value = userData.id;
                if (userId.value != '') {
                    document.getElementById('btnSubmit').classList.remove('disabled');
                }

            });
        })
    </script>
@endsection
