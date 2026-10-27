<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Website Contact Form Submission</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f4f4f5;
            color: #18181b;
            line-height: 1.6;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e4e4e7;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        .header {
            background-color: #1c1917;
            color: #ffffff;
            padding: 28px 32px;
            text-align: center;
            border-bottom: 3px solid #722121;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: #ffffff;
        }
        .header p {
            margin: 6px 0 0 0;
            font-size: 12px;
            color: #a8a29e;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }
        .content {
            padding: 32px;
        }
        .badge {
            display: inline-block;
            background-color: #fdf2f2;
            color: #722121;
            border: 1px solid #fecaca;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 20px;
            letter-spacing: 0.5px;
        }
        .table-info {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        .table-info td {
            padding: 10px 12px;
            border-bottom: 1px solid #f4f4f5;
            font-size: 14px;
        }
        .table-info td.label {
            width: 32%;
            font-weight: 600;
            color: #71717a;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
        }
        .table-info td.value {
            color: #09090b;
            font-weight: 500;
        }
        .message-box {
            background-color: #fafaf9;
            border: 1px solid #e7e5e4;
            border-left: 4px solid #722121;
            padding: 16px 20px;
            border-radius: 6px;
            margin-top: 16px;
            margin-bottom: 24px;
        }
        .message-box h4 {
            margin: 0 0 8px 0;
            font-size: 12px;
            color: #71717a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .message-box p {
            margin: 0;
            white-space: pre-line;
            color: #1c1917;
            font-size: 14px;
        }
        .actions {
            text-align: center;
            margin: 28px 0 12px 0;
        }
        .btn {
            display: inline-block;
            background-color: #722121;
            color: #ffffff !important;
            padding: 12px 24px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
            text-decoration: none;
            letter-spacing: 0.5px;
        }
        .footer {
            background-color: #fafaf9;
            border-top: 1px solid #e7e5e4;
            padding: 20px 32px;
            text-align: center;
            font-size: 12px;
            color: #a8a29e;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Torre T&oacute;r&ograve;</h1>
            <p>Commercial Architecture &amp; Interior Design</p>
        </div>

        <div class="content">
            <span class="badge">New Inquiry Received</span>

            <p style="margin-top: 0; font-size: 14px; color: #52525b;">
                A new contact submission has been submitted on the website:
            </p>

            <table class="table-info">
                <tr>
                    <td class="label">Client Name</td>
                    <td class="value"><strong>{{ $inquiry->name }}</strong></td>
                </tr>
                <tr>
                    <td class="label">Email Address</td>
                    <td class="value">
                        <a href="mailto:{{ $inquiry->email }}" style="color: #722121; text-decoration: none;">{{ $inquiry->email }}</a>
                    </td>
                </tr>
                @if($inquiry->phone)
                <tr>
                    <td class="label">Phone Number</td>
                    <td class="value">
                        <a href="tel:{{ preg_replace('/\s+/', '', $inquiry->phone) }}" style="color: #722121; text-decoration: none;">{{ $inquiry->phone }}</a>
                    </td>
                </tr>
                @endif
                @if($inquiry->company)
                <tr>
                    <td class="label">Company / Brand</td>
                    <td class="value">{{ $inquiry->company }}</td>
                </tr>
                @endif
                <tr>
                    <td class="label">Inquiry Type</td>
                    <td class="value">{{ ucwords(str_replace('_', ' ', $inquiry->type ?? 'General Contact')) }}</td>
                </tr>
                @if($inquiry->service_requested)
                <tr>
                    <td class="label">Service</td>
                    <td class="value">{{ $inquiry->service_requested }}</td>
                </tr>
                @endif
                @if($inquiry->preferred_date)
                <tr>
                    <td class="label">Preferred Date</td>
                    <td class="value">{{ $inquiry->preferred_date }}</td>
                </tr>
                @endif
                <tr>
                    <td class="label">Website Region</td>
                    <td class="value">{{ $domain?->name ?? 'Global' }} ({{ strtoupper($domain?->code ?? 'global') }})</td>
                </tr>
                <tr>
                    <td class="label">Received At</td>
                    <td class="value">{{ $inquiry->created_at ? $inquiry->created_at->format('M d, Y H:i:s') : date('M d, Y H:i:s') }} UTC</td>
                </tr>
            </table>

            @if($inquiry->message)
            <div class="message-box">
                <h4>Client Message</h4>
                <p>{{ $inquiry->message }}</p>
            </div>
            @endif

            <div class="actions">
                <a href="{{ url('/admin/inquiries/' . $inquiry->id) }}" class="btn">View in Admin Portal &rarr;</a>
            </div>
        </div>

        <div class="footer">
            This automated email alert was dispatched to <strong>kater@torretoro.com</strong> from Torre T&oacute;r&ograve; Website System.<br>
            Reply directly to this email to respond to <strong>{{ $inquiry->name }}</strong> ({{ $inquiry->email }}).
        </div>
    </div>
</body>
</html>
