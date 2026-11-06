<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Login - AulaKantor</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box}body{margin:0;font-family:Poppins,sans-serif;background:linear-gradient(135deg,#fff0f6,#ffdbe9);min-height:100vh;display:grid;place-items:center}.card{width:min(420px,92%);background:white;padding:34px;border-radius:25px;box-shadow:0 18px 50px #a33c6820}.logo{text-align:center;font-size:45px}.card h1{text-align:center;color:#d92e78;margin:5px 0}.sub{text-align:center;color:#8d7180;margin-bottom:25px}.group{margin-bottom:17px}label{display:block;font-weight:600;margin-bottom:6px}input{width:100%;padding:12px;border:1px solid #e8c8d7;border-radius:11px;box-sizing:border-box}.btn{width:100%;padding:13px;border:0;border-radius:11px;background:#ff4f9a;color:#fff;font-weight:700;cursor:pointer}.link{text-align:center;margin-top:18px;font-size:14px;color:#8d7180}.link a{color:#d92e78;font-weight:600}.error{background:#ffe7eb;color:#a51e2d;padding:10px;border-radius:10px;margin-bottom:15px}
</style></head>
<body><div class="card">
<div class="logo">🏢</div><h1>AulaKantor</h1><div class="sub">Login Sistem Pendaftaran Aula</div>
@if(session('success'))<div style="background:#e5f7ed;color:#167346;padding:10px;border-radius:10px;margin-bottom:15px">{{ session('success') }}</div>@endif
@if($errors->any())<div class="error">{{ $errors->first() }}</div>@endif
<form method="POST" action="{{ route('login.process') }}">@csrf
<div class="group"><label>Email</label><input type="email" name="email" value="{{ old('email') }}" required autofocus></div>
<div class="group"><label>Password</label><input type="password" name="password" required></div>
<div class="group"><label><input type="checkbox" name="remember" style="width:auto"> Ingat saya</label></div>
<button class="btn">Masuk</button></form>
<div class="link">Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></div>
</div></body></html>
