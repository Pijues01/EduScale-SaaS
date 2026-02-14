@extends('dashboard.layout.master')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('/website/img/notice-watermark.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .notice-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 2px solid #000;
            background: url('/website/img/notice-watermark.jpg') no-repeat center center;
            background-size: cover;
        }
        .school-header {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }
        .notice-title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            text-decoration: underline;
        }
        .notice-content {
            font-size: 18px;
            margin-top: 20px;
        }
        .footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 40px;
        }
        .seal {
            width: 120px;
            height: 120px;
            background: url('/website/img/logo.jpeg') no-repeat center center;
            background-size: cover;
        }
        .signature img {
            width: 150px;
            height: auto;
        }
        @media (max-width: 576px) {
            .footer {
                flex-direction: column;
                text-align: center;
            }
            .seal {
                margin-bottom: 20px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="notice-container shadow-lg p-4">
            <div class="school-header">Inspire Coaching Academy</div>
            <hr>
            <div class="notice-title">NOTICE</div>
            <p class="text-end"><strong>Date:</strong> {{ $notice->created_at->format('d M Y') }}</p>

            <div class="notice-content">
                <p><strong>Subject:</strong> {{ $notice->title }}</p>
                <p>{!! nl2br(e($notice->description)) !!}</p>
            </div>

            @if($notice->attachment)
                <div class="mt-4">
                    <a href="{{ asset($notice->attachment) }}" target="_blank" class="btn btn-outline-primary">
                        <i class="fas fa-paperclip"></i> View Attachment
                    </a>
                </div>
            @endif

            <div class="footer mt-5">
                <div class="seal"></div>
                <div class="signature">
                    <img src="/website/img/signature.png" alt="Principal Signature">
                    <p><strong>Principal</strong></p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <!-- Optional JS if needed -->
@endpush
