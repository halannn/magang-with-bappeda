<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Status Magang Anda Diperbarui</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white text-slate-900 font-sans">
    <div class="container mx-auto max-w-2xl bg-white p-8 rounded-lg border border-slate-200">
        <h1 class="text-xl mb-4">Halo {{ $profile->user->name }},</h1>

        <p class="text-sm leading-relaxed my-2">Status pendaftaran magang Anda di <strong>Bappeda Litbang
                Balikpapan</strong> telah diperbarui oleh admin.</p>

        @php
            $status = strtolower($profile->status_magang);
            $statusClasses = [
                'aktif' => 'bg-emerald-50 text-emerald-800 border-l-4 border-emerald-500',
                'dikeluarkan' => 'bg-red-50 text-red-800 border-l-4 border-red-500',
                'pending' => 'bg-blue-50 text-blue-800 border-l-4 border-blue-500',
            ];
        @endphp

        <div
            class="p-3 my-5 rounded-md font-bold {{ $statusClasses[$status] ?? 'bg-blue-50 text-blue-800 border-l-4 border-blue-500' }}">
            Status terbaru: {{ $profile->status_magang }}
        </div>

        <div class="bg-slate-50 p-4 mt-4 border-l-4 border-blue-500 rounded-md">
            <strong>Balasan Admin:</strong><br>
            {{ $magang->balasan }}
        </div>

        @if ($status !== 'dikeluarkan')
            <p class="text-sm leading-relaxed my-2">Silakan login ke dashboard Anda untuk melihat detail lebih lanjut
                atau melakukan aktivitas magang.</p>
            <p class="text-center">
                <a href="{{ route('dashboard.index') }}"
                    class="inline-block bg-blue-500 text-white py-2 px-5 rounded-md no-underline text-sm mt-6"
                    target="_blank">Buka Dashboard</a>
            </p>
        @endif

        <p class="text-xs text-slate-500 text-center mt-8">
            Email ini dikirim secara otomatis. Harap tidak membalas email ini.<br>
            © {{ date('Y') }} BAPPEDA Litbang Balikpapan
        </p>
    </div>
</body>

</html>
