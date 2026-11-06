<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pendaftaran Aula')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:Poppins,sans-serif;background:#fff5f9;color:#3c2631}
        a{text-decoration:none;color:inherit}
        button,input,select,textarea{font:inherit}
        .navbar{height:72px;background:linear-gradient(135deg,#ff4f9a,#ff80b8);color:white;display:flex;align-items:center;justify-content:space-between;padding:0 6%;box-shadow:0 4px 18px #e83d8025}
        .brand{font-size:21px;font-weight:700}
        .navlinks{display:flex;align-items:center;gap:12px}
        .navlinks a,.navlinks button{border:0;background:transparent;color:white;padding:10px 14px;border-radius:10px;cursor:pointer}
        .navlinks a:hover,.navlinks button:hover{background:#ffffff25}
        .container{width:min(1120px,92%);margin:30px auto}
        .hero{background:linear-gradient(135deg,#ff4f9a,#ff9bc6);color:white;border-radius:24px;padding:38px;margin-bottom:28px;box-shadow:0 15px 35px #f34c9525}
        .hero h1{font-size:30px;margin-bottom:8px}
        .hero p{opacity:.92}
        .grid{display:grid;grid-template-columns:repeat(2,1fr);gap:22px}
        .grid3{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}
        .card{background:white;border-radius:20px;padding:24px;box-shadow:0 7px 25px #8d486018;border:1px solid #f9d9e7}
        .aula-card{position:relative;overflow:hidden}
        .aula-icon{font-size:42px;margin-bottom:12px}
        .aula-card h3{font-size:21px;margin-bottom:6px}
        .capacity{display:inline-block;background:#ffe1ee;color:#d92e78;padding:7px 12px;border-radius:999px;font-weight:600;margin:10px 0}
        .btn{display:inline-block;border:0;border-radius:11px;padding:11px 18px;background:#ff4f9a;color:white;font-weight:600;cursor:pointer}
        .btn:hover{filter:brightness(.96)}
        .btn.secondary{background:#fff0f6;color:#d92e78}
        .btn.danger{background:#dc3545}
        .btn.success{background:#20a56a}
        .section-title{display:flex;justify-content:space-between;align-items:center;margin:28px 0 15px}
        .section-title h2{font-size:22px}
        .form-card{max-width:760px;margin:auto}
        .form-group{margin-bottom:18px}
        label{display:block;font-weight:600;margin-bottom:7px}
        input,select,textarea{width:100%;border:1px solid #e8c8d7;border-radius:11px;padding:12px 14px;outline:none;background:white}
        input:focus,select:focus,textarea:focus{border-color:#ff4f9a;box-shadow:0 0 0 3px #ff4f9a15}
        textarea{min-height:110px;resize:vertical}
        .two{display:grid;grid-template-columns:1fr 1fr;gap:16px}
        .alert{padding:13px 16px;border-radius:12px;margin-bottom:18px}
        .alert.success{background:#e7f8ef;color:#147548}
        .alert.error{background:#ffe9ec;color:#a6202d}
        .alert ul{padding-left:20px}
        table{width:100%;border-collapse:collapse;background:white}
        th,td{padding:13px 12px;text-align:left;border-bottom:1px solid #f2dfe8;font-size:14px;vertical-align:top}
        th{background:#fff0f6;color:#9c2b60}
        .table-wrap{overflow:auto;border-radius:16px}
        .badge{display:inline-block;padding:5px 10px;border-radius:999px;font-size:12px;font-weight:600}
        .badge.menunggu{background:#fff3cd;color:#8a6900}
        .badge.disetujui{background:#dff6e9;color:#177746}
        .badge.ditolak{background:#ffe1e5;color:#a61d2d}
        .badge.dibatalkan{background:#ececec;color:#666}
        .stats{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:25px}
        .stat{background:white;border:1px solid #f5d6e4;border-radius:18px;padding:20px}
        .stat small{color:#8b6b79}.stat strong{font-size:30px;display:block;margin-top:5px;color:#d92e78}
        .auth-wrap{min-height:100vh;display:grid;place-items:center;padding:25px;background:linear-gradient(135deg,#fff0f6,#ffe0ed)}
        .auth-card{width:min(430px,100%);background:white;border-radius:25px;padding:34px;box-shadow:0 15px 50px #a33c681f}
        .auth-card h1{margin-bottom:7px;color:#d92e78}.auth-card p{color:#8a6a78;margin-bottom:24px}
        .auth-footer{text-align:center;margin-top:20px;color:#8a6a78;font-size:14px}.auth-footer a{color:#d92e78;font-weight:600}
        .detail-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:15px}
        .detail-item{background:#fff7fa;padding:15px;border-radius:13px}.detail-item small{display:block;color:#987685;margin-bottom:4px}
        .actions{display:flex;gap:8px;flex-wrap:wrap}
        .empty{text-align:center;padding:35px;color:#907583}
        footer{text-align:center;padding:25px;color:#a1828f;font-size:13px}
        @media(max-width:800px){.grid,.grid3,.stats{grid-template-columns:1fr 1fr}.navbar{padding:0 4%}.navlinks a{display:none}.two,.detail-grid{grid-template-columns:1fr}}
        @media(max-width:560px){.grid,.grid3,.stats{grid-template-columns:1fr}.hero h1{font-size:24px}.navbar{height:auto;padding:15px 4%;gap:10px;align-items:flex-start}.navlinks{flex-wrap:wrap;justify-content:flex-end}.container{margin-top:20px}}
    </style>
</head>
<body>
@if(auth()->check())
<nav class="navbar">
    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}" class="brand">🏢 AulaKantor</a>
    <div class="navlinks">
        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.aulas') }}">Data Aula</a>
            <a href="{{ route('admin.history') }}">Riwayat</a>
        @else
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('pendaftaran.create') }}">Daftar Aula</a>
        @endif
        <form action="{{ route('logout') }}" method="POST">@csrf<button>Logout</button></form>
    </div>
</nav>
@endif

<main class="container">
    @if(session('success'))
        <div class="alert success">✓ {{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert error">
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</main>
<footer>Sistem Pendaftaran Aula Kantor © {{ date('Y') }}</footer>
</body>
</html>
