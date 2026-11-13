<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MOVIX CINEMA')</title>
    <style>
        *{box-sizing:border-box}body{margin:0;background:#f5f5f7;color:#202124;font-family:Arial,Helvetica,sans-serif}
        a{color:inherit}.topbar{background:#991b1b;color:#fff;padding:17px max(5%,calc((100% - 1120px)/2));display:flex;justify-content:space-between;align-items:center;gap:16px;flex-wrap:wrap}
        .brand{font-size:22px;font-weight:800;letter-spacing:1px;text-decoration:none}.nav{display:flex;align-items:center;gap:18px}.nav a{color:#fff;text-decoration:none;font-size:14px}
        .nav form{margin:0}.nav button{border:1px solid #fecaca;background:transparent;color:#fff;padding:8px 12px;border-radius:7px;cursor:pointer}
        .container{max-width:1120px;margin:32px auto;padding:0 20px}.panel{background:#fff;border-radius:14px;padding:22px;box-shadow:0 5px 22px #1118270b}
        .btn{display:inline-block;background:#b91c1c;color:#fff;border:0;border-radius:8px;padding:10px 15px;text-decoration:none;cursor:pointer;font-weight:700}
        .btn-outline{display:inline-block;border:1px solid #b91c1c;color:#991b1b;background:#fff;border-radius:8px;padding:9px 14px;text-decoration:none;cursor:pointer}
        .muted{color:#6b7280}.field{display:block;width:100%;padding:12px;border:1px solid #d1d5db;border-radius:8px;margin:7px 0 15px;font-size:15px}
        label{font-weight:600;font-size:14px}.error{color:#b91c1c;font-size:13px;margin-top:-10px;margin-bottom:12px}
        .stats{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin:22px 0}.stat{background:#fff;padding:20px;border-radius:12px;box-shadow:0 4px 15px #1118270a}.stat strong{display:block;color:#991b1b;font-size:28px;margin-top:8px}
        .table-wrap{overflow-x:auto}.table{width:100%;border-collapse:collapse;min-width:720px}.table th,.table td{padding:13px 12px;text-align:left;border-bottom:1px solid #eee}.table th{font-size:13px;color:#991b1b;background:#fffafa}
        .pill{display:inline-block;padding:5px 9px;border-radius:20px;background:#fee2e2;color:#991b1b;font-size:12px;font-weight:700}.auth-wrap{max-width:440px;margin:55px auto;padding:0 18px}.auth-card{background:#fff;border-radius:15px;padding:28px;box-shadow:0 8px 30px #00000012}
        .auth-card h1{margin-top:0}.auth-card .btn{width:100%;padding:13px}.footer{text-align:center;color:#9ca3af;font-size:12px;padding:30px}
        @media(max-width:700px){.stats{grid-template-columns:1fr}.container{margin-top:22px}.topbar{padding:16px 20px}}
    </style>
</head>
<body>
<header class="topbar">
    <a class="brand" href="{{ url('/') }}">MOVIX CINEMA</a>
    <nav class="nav">
        <a href="{{ url('/') }}">Beranda</a>
        @auth
            <a href="{{ route('customer.dashboard') }}">Dashboard Saya</a>
            <form method="POST" action="{{ route('customer.logout') }}">
                @csrf
                <button type="submit">Keluar</button>
            </form>
        @else
            <a href="{{ route('customer.login') }}">Masuk</a>
            <a href="{{ route('customer.register') }}">Daftar</a>
        @endauth
    </nav>
</header>
<main>@yield('content')</main>
<footer class="footer">© {{ date('Y') }} MOVIX CINEMA · Your Movie, Your Experience</footer>
</body>
</html>
