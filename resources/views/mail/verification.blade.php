<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Status Magang Anda Diperbarui</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            color: #0f172a;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        h1 {
            font-size: 20px;
            margin-bottom: 1rem;
        }

        p {
            font-size: 14px;
            line-height: 1.6;
        }

        .status-box {
            padding: 10px 15px;
            margin: 1rem 0;
            border-radius: 6px;
            font-weight: bold;
        }

        .status-aktif {
            background-color: #ecfdf5;
            color: #065f46;
            border-left: 4px solid #10b981;
        }

        .status-dikeluarkan {
            background-color: #fef2f2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }

        .status-pending {
            background-color: #eff6ff;
            color: #1e40af;
            border-left: 4px solid #3b82f6;
        }

        .button {
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            margin-top: 1rem;
            display: inline-block;
        }

        .footer {
            font-size: 12px;
            color: #64748b;
            text-align: center;
            margin-top: 2rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Halo {{ $profile->user->name }},</h1>

        <p>Status pendaftaran magang Anda di <strong>BAPPEDA Litbang Balikpapan</strong> telah diperbarui oleh admin.
        </p>

        @php
            $status = strtolower($profile->status_magang);
        @endphp

        <div
            class="status-box 
            {{ $status === 'aktif' ? 'status-aktif' : ($status === 'dikeluarkan' ? 'status-dikeluarkan' : 'status-pending') }}">
            Status terbaru: {{ strtoupper($profile->status_magang) }}
        </div>

        @if ($status !== 'dikeluarkan')
            <p>Silakan login ke dashboard Anda untuk melihat detail lebih lanjut.</p>

            <p style="text-align: center;">
                <a href="{{ route('dashboard.index') }}" class="button" target="_blank">
                    Buka Dashboard
                </a>
            </p>

            <p class="footer">
                Email ini dikirim secara otomatis. Harap tidak membalas email ini.<br>
                © {{ date('Y') }} BAPPEDA Litbang Balikpapan
            </p>
        @endif
    </div>
</body>

</html>
