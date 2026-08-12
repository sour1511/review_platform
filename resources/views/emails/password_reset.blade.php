@extends('emails.layout')

@section('content')
    <h2 style="margin-top: 0;">{{ __('messages.reset_password') }}</h2>
    <p>Hi {{ $name }},</p>
    <p>{{ $sub_msg1 }}</p>
    <p style="margin: 28px 0;">
        <a href="{{ $link }}"
            style="background: #0d6efd; color: #fff; text-decoration: none; padding: 12px 18px; border-radius: 4px; display: inline-block;">
            {{ __('messages.reset_password') }}
        </a>
    </p>
    <p style="font-size: 13px; color: #666;">
        Or copy this link into your browser:<br>
        <a href="{{ $link }}">{{ $link }}</a>
    </p>
@endsection
