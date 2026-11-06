<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Daftar - AulaKantor</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box}body{margin:0;font-family:Poppins,sans-serif;background:linear-gradient(135deg,#fff0f6,#ffdbe9);min-height:100vh;display:grid;place-items:center}.card{width:min(460px,92%);background:white;padding:34px;border-radius:25px;box-shadow:0 18px 50px #a33c6820}.logo{text-align:center;font-size:45px}.card h1{text-align:center;color:#d92e78;margin:5px 0}.sub{text-align:center;color:#8d7180;margin-bottom:25px}.group{margin-bottom:17px}label{display:block;font-weight:600;margin-bottom:6px}input{width:100%;padding:12px;border:1px solid #e8c8d7;border-radius:11px;box-sizing:border-box}.btn{width:100%;padding:13px;border:0;border-radius:11px;background:#ff4f9a;color:#fff;font-weight:700;cursor:pointer}.link{text-align:center;margin-top:18px;font-size:14px;color:#8d7180}.link a{color:#d92e78;font-weight:600}.error{background:#ffe7eb;color:#a51e2d;padding:10px;border-radius:10px;margin-bottom:15px}.errors{margin:0;padding-left:20px}
</style></head>
<body><div class="card">
<div class="logo">📝</div><h1>Buat Akun</h1><div class="sub">Daftar sebagai pengguna aula</div>
@if($errors->any())<div class="error"><ul class="errors">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
<form method="POST" action="{{ route('register.process') }}">@csrf
<div class="group"><label>Nama Lengkap</label><input name="name" value="{{ old('name') }}" required></div>
<div class="group"><label>Email</label><input type="email" name="email" value="{{ old('email') }}" required></div>
<div class="group"><label>Password</label><input type="password" name="password" required></div>
<div class="group"><label>Konfirmasi Password</label><input type="password" name="password_confirmation" required></div>
<button class="btn">Daftar</button></form>
<div class="link">Sudah punya akun? <a href="{{ route('login') }}">Login</a></div>
</div></body></html>
