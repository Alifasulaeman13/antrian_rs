<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login Sukses</title>
        <style>
            body { font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Noto Sans, Ubuntu, Cantarell, Helvetica Neue, Arial, "Apple Color Emoji", "Segoe UI Emoji"; padding: 2rem; background: #f9fafb; color: #111827; }
            .card { max-width: 720px; margin: 0 auto; background: white; border: 1px solid #e5e7eb; border-radius: .5rem; padding: 1.25rem; }
            .muted { color: #6b7280; font-size: .875rem; }
            code { background: #f3f4f6; padding: .25rem .375rem; border-radius: .25rem; }
            .row { margin-top: .75rem; }
            .btn { display: inline-block; padding: .5rem .75rem; border-radius: .375rem; background: #111827; color: white; text-decoration: none; }
            .btn + .btn { margin-left: .5rem; }
            .mt { margin-top: 1rem; }
            .warn { color: #b45309; }
        </style>
    </head>
    <body>
        <div class="card">
            <h1>Login dengan Google Berhasil</h1>
            @php($user = session('user'))
            @php($token = session('token'))

            @if ($user)
                <div class="row">
                    <div><strong>Nama</strong>: {{ $user->name }}</div>
                    <div><strong>Email</strong>: {{ $user->email }}</div>
                </div>
            @endif

            @if ($token)
                <div class="row">
                    <div><strong>API Token (Sanctum)</strong>:</div>
                    <div class="muted">Gunakan untuk memanggil endpoint API yang membutuhkan autentikasi.</div>
                    <div class="mt"><code>{{ $token }}</code></div>
                    <div class="muted warn mt">Simpan token ini secara aman. Untuk produksi, hindari menampilkan token di halaman.</div>
                </div>
            @endif

            <div class="row mt">
                <a class="btn" href="/">Kembali ke Beranda</a>
                <a class="btn" href="/auth/google">Login Ulang</a>
            </div>
        </div>
    </body>
    </html>


