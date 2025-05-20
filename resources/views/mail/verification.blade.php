<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Status Magang Anda Diperbarui</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: hsl(0, 0%, 100%);
            color: hsl(222.2, 84%, 4.9%);       
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: hsl(0, 0%, 100%); 
            color: hsl(222.2, 84%, 4.9%);       
            padding: 2rem;
            border-radius: 8px;
            border: 1px solid hsl(214.3, 31.8%, 91.4%);
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
            background-color: hsl(210, 40%, 96.1%); 
            color: hsl(222.2, 47.4%, 11.2%);       
            padding: 10px 15px;
            border-left: 4px solid hsl(221.2, 83.2%, 53.3%);
            margin: 1rem 0;
            border-radius: 6px;
            font-weight: bold;
        }

        .button {
            display: inline-block;
            color: hsl(210, 40%, 98%);                 
            background-color: hsl(221.2, 83.2%, 53.3%); 
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            margin-top: 1rem;
        }

        .footer {
            font-size: 12px;
            color: hsl(215.4, 16.3%, 46.9%);
            text-align: center;
            margin-top: 2rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Halo {{ $profile->user->name }},</h1>

        <p>Status pendaftaran magang Anda di <strong>BAPPEDA Litbang Balikpapan</strong> telah diperbarui oleh admin.</p>

        <div class="status-box">
            Status terbaru: {{ strtoupper($profile->status_magang) }}
        </div>

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
    </div>
</body>

</html>
