<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Daftar — Pustaka Digital</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=DM+Sans:opsz,wght@9..40,400;9..40,500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
    body{min-height:100vh;font-family:'DM Sans',sans-serif;background:#060a18;display:flex;align-items:center;justify-content:center;-webkit-font-smoothing:antialiased;padding:30px 20px;}
    .bg{position:fixed;inset:0;z-index:0;}
    .bg-blob{position:absolute;border-radius:50%;filter:blur(90px);opacity:.45;animation:fb 10s ease-in-out infinite;}
    .b1{width:500px;height:500px;background:radial-gradient(circle,#4338ca,#6366f1);top:-100px;left:-120px;}
    .b2{width:350px;height:350px;background:radial-gradient(circle,#0ea5e9,#06b6d4);bottom:-60px;right:-60px;animation-delay:-4s;}
    .b3{width:280px;height:280px;background:radial-gradient(circle,#8b5cf6,#a78bfa);top:50%;left:55%;animation-delay:-7s;}
    @keyframes fb{0%,100%{transform:translate(0,0);}50%{transform:translate(20px,-15px) scale(1.03);}}
    .bg-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.02) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.02) 1px,transparent 1px);background-size:50px 50px;}
    .card{
        position:relative;z-index:1;width:100%;max-width:560px;
        background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.1);
        border-radius:24px;padding:36px;
        backdrop-filter:blur(24px) saturate(150%);
        box-shadow:0 24px 80px rgba(0,0,0,.4),inset 0 1px 0 rgba(255,255,255,.07);
        animation:cIn .5s cubic-bezier(.16,1,.3,1);
    }
    @keyframes cIn{from{opacity:0;transform:translateY(20px);}to{opacity:1;transform:none;}}
    .logo{display:flex;align-items:center;gap:10px;margin-bottom:24px;}
    .logo-ic{width:36px;height:36px;border-radius:9px;background:linear-gradient(135deg,#6366f1,#4338ca);display:flex;align-items:center;justify-content:center;}
    .logo-ic i{color:#fff;font-size:15px;}
    .logo span{font-family:'Outfit',sans-serif;color:#fff;font-weight:700;font-size:15px;}
    h2{font-family:'Outfit',sans-serif;color:#fff;font-size:22px;font-weight:750;letter-spacing:-.02em;margin-bottom:4px;}
    .sub{color:rgba(255,255,255,.4);font-size:13px;margin-bottom:24px;}
    .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
    @media(max-width:480px){.grid-2{grid-template-columns:1fr;}}
    .fg{margin-bottom:0;}
    .lbl{display:block;margin-bottom:5px;font-size:11.5px;font-weight:600;color:rgba(255,255,255,.55);letter-spacing:.03em;text-transform:uppercase;}
    .req{color:#f87171;}
    .inp{width:100%;padding:10px 12px;border-radius:9px;font-size:13px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);color:#fff;font-family:'DM Sans',sans-serif;outline:none;transition:all .18s;}
    .inp:focus{background:rgba(255,255,255,.1);border-color:rgba(99,102,241,.6);box-shadow:0 0 0 3px rgba(99,102,241,.15);}
    .inp::placeholder{color:rgba(255,255,255,.22);}
    .err-box{background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.25);border-radius:10px;padding:10px 13px;margin-bottom:16px;color:#fca5a5;font-size:12.5px;}
    .err-box ul{list-style:none;display:flex;flex-direction:column;gap:3px;}
    .err-box li::before{content:'• ';color:#f87171;}
    .divider{grid-column:1/-1;height:1px;background:rgba(255,255,255,.07);margin:4px 0;}
    .btn-reg{width:100%;margin-top:20px;padding:12px;border-radius:11px;background:linear-gradient(135deg,#6366f1,#4338ca);color:#fff;font-size:13.5px;font-weight:650;border:none;cursor:pointer;font-family:'DM Sans',sans-serif;box-shadow:0 4px 16px rgba(99,102,241,.4);transition:all .2s cubic-bezier(.16,1,.3,1);display:flex;align-items:center;justify-content:center;gap:7px;}
    .btn-reg:hover{transform:translateY(-1px);box-shadow:0 8px 28px rgba(99,102,241,.5);}
    .signin-link{text-align:center;font-size:13px;color:rgba(255,255,255,.4);margin-top:18px;}
    .signin-link a{color:#a5b4fc;font-weight:600;text-decoration:none;}
    .signin-link a:hover{color:#818cf8;}
    .benefits{display:flex;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .benefit{display:flex;align-items:center;gap:6px;font-size:12px;color:rgba(255,255,255,.45);}
    .benefit i{color:#a5b4fc;font-size:13px;}
    </style>
</head>
<body>
<div class="bg"><div class="bg-grid"></div><div class="bg-blob b1"></div><div class="bg-blob b2"></div><div class="bg-blob b3"></div></div>

<div class="card">
    <div class="logo">
        <div class="logo-ic"><i class="bi bi-book-fill"></i></div>
        <span>Pustaka Digital</span>
    </div>
    <h2>Buat Akun Baru</h2>
    <p class="sub">Daftar gratis dan mulai akses perpustakaan digital</p>

    <div class="benefits">
        <div class="benefit"><i class="bi bi-check-circle-fill"></i> Akses 500+ buku</div>
        <div class="benefit"><i class="bi bi-check-circle-fill"></i> Pinjam hingga 3 buku</div>
        <div class="benefit"><i class="bi bi-check-circle-fill"></i> Gratis selamanya</div>
    </div>

    @if($errors->any())
    <div class="err-box">
        <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form method="POST" action="{{ route('register.post') }}">
        @csrf
        <div class="grid-2">
            <div class="fg">
                <label class="lbl">Nama Lengkap <span class="req">*</span></label>
                <input type="text" name="name" class="inp" value="{{ old('name') }}" placeholder="John Doe" required>
            </div>
            <div class="fg">
                <label class="lbl">Email <span class="req">*</span></label>
                <input type="email" name="email" class="inp" value="{{ old('email') }}" placeholder="nama@email.com" required>
            </div>
            <div class="fg">
                <label class="lbl">Password <span class="req">*</span></label>
                <input type="password" name="password" class="inp" placeholder="Min. 8 karakter" required minlength="8">
            </div>
            <div class="fg">
                <label class="lbl">Konfirmasi Password <span class="req">*</span></label>
                <input type="password" name="password_confirmation" class="inp" placeholder="Ulangi password" required>
            </div>
            <div class="divider"></div>
            <div class="fg">
                <label class="lbl">No. Telepon</label>
                <input type="text" name="no_telepon" class="inp" value="{{ old('no_telepon') }}" placeholder="08xxxxxxxxxx">
            </div>
            <div class="fg">
                <label class="lbl">Alamat</label>
                <input type="text" name="alamat" class="inp" value="{{ old('alamat') }}" placeholder="Kota / Kabupaten">
            </div>
        </div>
        <button type="submit" class="btn-reg">
            <i class="bi bi-person-check-fill"></i> Buat Akun
        </button>
    </form>
    <p class="signin-link">Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
</div>
</body>
</html>
