<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $replySubject }}</title>
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
        .original-message {
            background: white;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #6366f1;
        }
        .reply-section {
            background: #e0f2fe;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #0ea5e9;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            color: #6c757d;
            font-size: 14px;
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
    </style>
</head>
<body>
    <div class="header">
        <h1>📧 Balasan dari SecondCycle</h1>
        <p>Platform Motor Bekas Berkualitas</p>
    </div>

    <div class="content">
        <h3>Halo {{ $contactMessage->name }},</h3>
        
        <p>Terima kasih telah menghubungi SecondCycle. Kami telah menerima pesan Anda dan kami senang dapat memberikan tanggapan.</p>
        
        <div class="original-message">
            <h4>📝 Pesan Anda:</h4>
            <p><strong>Subjek:</strong> {{ $contactMessage->subject }}</p>
            @if($contactMessage->department)
                <p><strong>Departemen:</strong> <span class="department-badge">{{ ucfirst($contactMessage->department) }}</span></p>
            @endif
            <p><strong>Pesan:</strong></p>
            <p>{{ nl2br(e($contactMessage->message)) }}</p>
            <p><small><em>Dikirim pada: {{ $contactMessage->created_at->format('d M Y H:i') }}</em></small></p>
        </div>

        <div class="reply-section">
            <h4>💬 Balasan Kami:</h4>
            <p>{{ nl2br(e($replyContent)) }}</p>
        </div>

        <p>Jika Anda memiliki pertanyaan lebih lanjut, jangan ragu untuk menghubungi kami kembali.</p>

        <div style="background: #fef3c7; padding: 15px; border-radius: 5px; margin-top: 20px;">
            <h4 style="margin: 0 0 10px 0; color: #d97706;">📞 Hubungi Kami:</h4>
            <ul style="margin: 0; padding-left: 20px;">
                <li>📧 Email: info@secondcycle.id</li>
                <li>📱 WhatsApp: +62 877-6900-2763</li>
                <li>🌐 Website: www.secondcycle.id</li>
                <li>📍 Alamat: Jl. Sudirman No. 123, Jakarta Pusat</li>
            </ul>
        </div>
    </div>

    <div class="footer">
        <p><strong>SecondCycle Indonesia</strong></p>
        <p>Jl. Sudirman No. 123, Jakarta Pusat</p>
        <p>📞 +62 877-6900-2763 | 🌐 www.secondcycle.id</p>
        <p style="font-size: 12px; margin-top: 15px;">
            Email ini adalah balasan otomatis dari sistem kontak SecondCycle. 
            Jika Anda tidak meminta balasan ini, silakan abaikan.
        </p>
    </div>
</body>
</html>
