@extends('layouts.skeleton')

<section class="section">
        <div class="section-header">
            <h1>Verifikasi Akun Anda</h1>
        </div>
            
        <div class="section-body">
        <div class="container-fluid mt-3">
        <div class="card">
            <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                     @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }}
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
        </div>
    </div>
        </div>
    </section>


