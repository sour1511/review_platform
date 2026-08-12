@extends('emails.layout')

@section('content')
    <h2 style="margin-top: 0;">Contact form message</h2>
    <p><strong>Name:</strong> {{ $name }}</p>
    <p><strong>Email:</strong> {{ $email }}</p>
    <p><strong>Subject:</strong> {{ $subject }}</p>
    <p><strong>Message:</strong></p>
    <p style="white-space: pre-wrap;">{{ $message }}</p>
@endsection
