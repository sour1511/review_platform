@extends('emails.layout')

@section('content')
    <h2 style="margin-top: 0;">Welcome</h2>
    <p>Hi {{ $name }},</p>
    <p>Thanks for joining {{ config('app.name') }}.</p>
    <p><strong>Email:</strong> {{ $user_email }}</p>
    @if (!empty($join_date))
        <p><strong>Join date:</strong> {{ $join_date }}</p>
    @endif
@endsection
