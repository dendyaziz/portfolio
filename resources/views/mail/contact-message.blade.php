<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        .title {
            font-weight: 700;
            margin-bottom: .25rem;
            font-size: 1.5rem;
        }

        .label {
            font-weight: 500;
            font-size: .95rem;
            color: #aaaaaa;
        }

        .value {
            font-weight: 500;
            color: #222222;
            font-size: .95rem;
        }

        .form-group {
            margin-bottom: 1.5rem;

        }

        .row, .form-row {
            display: flex;
        }

        .col-auto {
            width: auto;
        }

        .row .col-auto {
            margin-right: 4rem;
        }

        .form-row .col-auto {
            width: auto;
            margin-right: .75rem;
        }

        @media (max-width: 576px) {
            .row:not(.no-wrap), .form-row:not(.no-wrap) {
                display: block;
            }
        }

        .capitalize {
            text-transform: capitalize;
        }

        .rounded-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            overflow: hidden;
            background-color: #ccc;
        }

        .rounded-avatar.avatar-sm {
            width: 50px;
            height: 50px;
        }

        .center-vertical {
            display: flex;
            margin-top: auto;
            margin-bottom: auto;
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .mb-4 {
            margin-bottom: 2rem;
        }

        .rounded-box {
            padding: .75rem 1.25rem;
            border: 1px solid #ddd;
            border-radius: .5rem;
        }

        .overflow-hidden {
            overflow: hidden;
        }

        .ellipsis {
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
        }
    </style>
</head>
<body style="font-family: 'Roboto', sans-serif; margin: 2rem 1rem; max-width: 550px">
<div class="form-group">
    <div class="title">New message sent from your portfolio website</div>
    <div class="value">Show detail of this message <a href="{{ env('APP_URL') }}/messages/{{$contactMessage->id}}">here</a>.</div>
</div>
<div class="form-group">
    <div class="label">Sender:</div>
    <div class="value capitalize">{{ $contactMessage->contact->name }}</div>
    <div class="value"><a href="mailto:{{ $contactMessage->contact->email }}" title="Send Email">
            {{ $contactMessage->contact->email }}</a></div>
</div>
<div class="form-group">
    <div class="label">Message:</div>
    <div class="value">{{ $contactMessage->message }}</div>
</div>
<div class="form-group">
    <div class="label">Sent:</div>
    <div class="value">{{ $contactMessage->created_at->format('d M Y, H:i') }}</div>
</div>
</body>
</html>
