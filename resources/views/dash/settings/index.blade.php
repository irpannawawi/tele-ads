@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

        </div>
        <div class="row">
            {{-- App Setting --}}
            <div class="col-lg-6 mb-2">
                <div class="card">
                    <div class="card-header">Setting</div>
                    <div class="card-body">
                        <form accept-charset="utf-8" action="{{ route('settings.update.app') }}" method="post">
                            @csrf
                            @method('PUT')
                            <h5>App Setting</h5>
                            <div class="form-group mb-3">
                                <label for="APP_NAME" class="form-label">App Name</label>
                                <input name="APP_NAME" type="text" placeholder="App Name" value="{{ env('APP_NAME') }}"
                                    class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="env" class="form-label">App Environement</label>
                                    <select name="APP_ENV" id="env" class="form-control">
                                        <option value="local" {{ env('APP_ENV') == 'local' ? 'selected' : '' }}>Local
                                        </option>
                                        <option value="production" {{ env('APP_ENV') == 'production' ? 'selected' : '' }}>
                                            Production</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="APP_URL" class="form-label">App URL</label>
                                    <input name="APP_URL" type="text" placeholder="App URL" value="{{ env('APP_URL') }}"
                                        class="form-control">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="APP_DEBUG" class="form-label">App Debug</label>
                                    <select name="APP_DEBUG" class="form-control">
                                        <option value="true" {{ env('APP_DEBUG') ? 'selected' : '' }}>True</option>
                                        <option value="false" {{ !env('APP_DEBUG') ? 'selected' : '' }}>False</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="APP_KEY" class="form-label">App Key</label>
                                    <input name="APP_KEY" type="text" placeholder="App Key" value="{{ env('APP_KEY') }}"
                                        class="form-control">
                                </div>

                            </div>

                            <div class="d-flex justify-content-end">
                                <div class="p-1">
                                    <button type="submit" class="btn btn-primary ">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- App Setting --}}
            {{-- mini App --}}
            <div class="col-lg-6 mb-2">
                <div class="card">
                    <div class="card-header">Mini App</div>
                    <div class="card-body">
                        <form accept-charset="utf-8" action="{{ route('settings.update.app') }}" method="post">
                            @csrf
                            @method('PUT')


                            <div class="row mb-2">

                                <div class="col-md-6">
                                    <label for="MAX_ADS_PER_DAY" class="form-label">Maximum Ads Per Day</label>
                                    <input name="MAX_ADS_PER_DAY" type="number" placeholder="Minimum Withdraw Points"
                                        value="{{ env('MAX_ADS_PER_DAY') }}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="POINTS_PER_AD" class="form-label">Points Per Ad</label>
                                    <input name="POINTS_PER_AD" type="number" placeholder="Minimum Withdraw Points"
                                        value="{{ env('POINTS_PER_AD') }}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="MIN_WITHDRAW_POINTS" class="form-label">Minimum Withdraw Points</label>
                                    <input name="MIN_WITHDRAW_POINTS" type="number"
                                        placeholder="Minimum Withdraw Points" value="{{ env('MIN_WITHDRAW_POINTS') }}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <div class="p-1">
                                    <button type="submit" class="btn btn-primary ">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- mini App --}}            
            {{-- telegram setting --}}
            <div class="col-lg-6 mb-2">
                <div class="card">
                    <div class="card-header">Telegram</div>
                    <div class="card-body">
                        <form accept-charset="utf-8" action="{{ route('settings.update.app') }}" method="post">
                            @csrf
                            @method('PUT')

                            <div class="row mb-2">
                                <div class="col">
                                    <label for="bot_token" class="form-label">Bot Token</label>
                                    <input name="bot_token" type="text" placeholder="Bot Token"
                                        value="{{ env('BOT_TOKEN') }}" class="form-control">
                                </div>
                                <div class="col">
                                    <label for="broadcast_channel" class="form-label">Broadcast Channel</label>
                                    <input name="broadcast_channel" type="text" placeholder="Broadcast Channel"
                                        value="{{ env('BROADCAST_CHANNEL') }}" class="form-control">
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- telegram setting --}}


            {{-- monetag setting --}}
            <div class="col-lg-6 mb-2">
                <div class="card">
                    <div class="card-header">Monetag</div>
                    <div class="card-body">
                        <form accept-charset="utf-8" action="{{ route('settings.update.app') }}" method="post">
                            @csrf
                            @method('PUT')


                            <div class="row mb-2">
                                <div class="col">
                                    <label for="ads_id" class="form-label">Ad ID</label>
                                    <input name="ads_id" type="text" placeholder="Ad ID" value="{{ env('ADS_ID') }}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <div class="p-1">
                                    <button type="submit" class="btn btn-primary ">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- monetag setting --}}



        </div>
    </div>
@endsection
