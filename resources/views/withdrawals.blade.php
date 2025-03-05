@extends('layouts.public')

@section('content')
    {{-- button --}}
    <div class="d-flex justify-content-center align-items-center mt-1 pt-4">
        <div class="col card bg-dark-op75">
            <div class="card-body text-white fs-6">
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
                    <div class="form-group mb-2">
                        <label for="nominal">Nominal Penarikan</label>
                        <input type="number" class="form-control" id="nominal" placeholder="Masukkan nominal" name="amount" value="{{old('nominal')}}"
                            required>
                            <input type="hidden" name="id" id="id" value="">
                    </div>
                    <div class="form-group mb-2">
                        <label for="metode">Metode Penarikan</label>
                        <select class="form-control" id="metode" name="method" required>
                            <option {{ old('metode') == 'dana' ? 'selected' : '' }} value="Dana">Dana</option>
                            <option {{ old('metode') == 'ovo' ? 'selected' : '' }} value="Ovo">Ovo</option>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="tujuan">Nomor Tujuan</label>
                        <input type="number" class="form-control" id="tujuan" placeholder="Masukkan nomor tujuan"
                            name="address" value="{{old('tujuan')}}" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-2 disabled" id="btnSubmit">Tarik</button>
                </form>
            </div>
        </div>
    </div>
@endsection
