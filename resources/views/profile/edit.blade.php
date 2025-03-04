@extends('layouts.app')
@section('content')
    <x-slot name="header">
        <h2 class="display-5 fw-bold lh-1 mb-3">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
