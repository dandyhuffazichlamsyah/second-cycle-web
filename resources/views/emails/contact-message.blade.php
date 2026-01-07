<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Baru dari SecondCycle</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .field {
            margin-bottom: 20px;
        }
        .field-label {
            font-weight: bold;
            color: #6366f1;
            margin-bottom: 5px;
        }
        .field-value {
            background: white;
            padding: 10px;
            border-radius: 5px;
            border-left: 4px solid #6366f1;
        }
        .department-badge {
            display: inline-block;
            background: #10b981;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            color: #6c757d;
            font-size: 14px;
        }
        .urgent {
            background: #fef2f2;
            border-left: 4px solid #ef4444;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📧 Pesan Baru dari Customer</h1>
        <p>SecondCycle - Platform Motor Bekas Berkualitas</p>
    </div>

    <div class="content">
        <div class="field">
            <div class="field-label">👤 Nama Lengkap</div>
            <div class="field-value">{{ $contactMessage->name }}</div>
        </div>

        <div class="field">
            <div class="field-label">📧 Email</div>
            <div class="field-value">{{ $contactMessage->email }}</div>
        </div>

        @if($contactMessage->phone)
        <div class="field">
            <div class="field-label">📱 Nomor Telepon</div>
            <div class="field-value">{{ $contactMessage->phone }}</div>
        </div>
        @endif

        <div class="field">
            <div class="field-label">🏢 Departemen</div>
            <div class="field-value">
                @if($contactMessage->department)
                    <span class="department-badge">
                        {{ ucfirst($contactMessage->department) }}
                    </span>
                @else
                    <em>Umum</em>
                @endif
            </div>
        </div>

        <div class="field">
            <div class="field-label">📝 Subjek</div>
            <div class="field-value {{ str_contains(strtolower($contactMessage->subject), 'urgent') || str_contains(strtolower($contactMessage->subject), 'darurat') || str_contains(strtolower($contactMessage->subject), 'penting') ? 'urgent' : '' }}">
                <strong>{{ $contactMessage->subject }}</strong>
            </div>
        </div>

        <div class="field">
            <div class="field-label">💬 Pesan</div>
            <div class="field-value">
                {{ nl2br(e($contactMessage->message)) }}
            </div>
        </div>

        @if($contactMessage->newsletter)
        <div class="field">
            <div class="field-label">📢 Newsletter</div>
            <div class="field-value">
                <span style="color: #10b981;">✅ Customer ingin menerima newsletter</span>
            </div>
        </div>
        @endif

        <div style="background: #e0f2fe; padding: 15px; border-radius: 5px; margin-top: 20px;">
            <h4 style="margin: 0 0 10px 0; color: #0369a1;">🚀 Tindakan Cepat:</h4>
            <ul style="margin: 0; padding-left: 20px;">
                @if($contactMessage->phone)
                <li>Hubungi customer: <a href="tel:{{ $contactMessage->phone }}">{{ $contactMessage->phone }}</a></li>
                @endif
                <li>Balas email: <a href="mailto:{{ $contactMessage->email }}?subject=Re: {{ $contactMessage->subject }}">{{ $contactMessage->email }}</a></li>
                <li>Waktu pengiriman: {{ $contactMessage->created_at->format('d M Y H:i') }}</li>
            </ul>
        </div>
    </div>

    <div class="footer">
        <p><strong>SecondCycle Indonesia</strong></p>
        <p>Jl. Sudirman No. 123, Jakarta Pusat</p>
        <p>📞 +62 877-6900-2763 | 🌐 www.secondcycle.id</p>
        <p style="font-size: 12px; margin-top: 15px;">
            Email ini dikirim otomatis dari sistem kontak SecondCycle. 
            Mohon tidak membalas email ini.
        </p>
    </div>
</body>
</html>
