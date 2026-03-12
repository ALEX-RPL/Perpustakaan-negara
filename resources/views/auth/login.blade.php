<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Masuk — Pustaka Digital</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=DM+Sans:opsz,wght@9..40,400;9..40,500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
    body{min-height:100vh;font-family:'DM Sans',sans-serif;background:#060a18;display:flex;-webkit-font-smoothing:antialiased;overflow:hidden;}

    /* Animated mesh background */
    .bg{position:fixed;inset:0;z-index:0;}
    .bg-blob{position:absolute;border-radius:50%;filter:blur(80px);opacity:.5;animation:floatBlob 8s ease-in-out infinite;}
    .b1{width:520px;height:520px;background:radial-gradient(circle,#4338ca,#7c3aed);top:-120px;left:-100px;animation-delay:0s;}
    .b2{width:400px;height:400px;background:radial-gradient(circle,#0ea5e9,#3b82f6);bottom:-60px;right:-80px;animation-delay:-3s;}
    .b3{width:300px;height:300px;background:radial-gradient(circle,#8b5cf6,#ec4899);top:40%;left:45%;animation-delay:-6s;}
    @keyframes floatBlob{0%,100%{transform:translate(0,0) scale(1);}33%{transform:translate(30px,-20px) scale(1.05);}66%{transform:translate(-20px,25px) scale(.96);}}
    .bg-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.025) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.025) 1px,transparent 1px);background-size:50px 50px;}

    /* Left panel */
    .panel-left{
        flex:1;display:flex;flex-direction:column;justify-content:center;padding:60px;
        position:relative;z-index:1;
    }
    @media(max-width:900px){.panel-left{display:none;}}

    .left-logo{display:flex;align-items:center;gap:12px;margin-bottom:60px;}
    .left-logo-icon{width:42px;height:42px;border-radius:12px;background:linear-gradient(135deg,#6366f1,#4338ca);display:flex;align-items:center;justify-content:center;box-shadow:0 8px 24px rgba(99,102,241,.4);}
    .left-logo-icon i{color:#fff;font-size:18px;}
    .left-logo h2{font-family:'Outfit',sans-serif;color:#fff;font-weight:700;font-size:18px;}

    .left-headline{font-family:'Outfit',sans-serif;color:#fff;font-size:48px;font-weight:800;line-height:1.1;letter-spacing:-.03em;margin-bottom:20px;}
    .left-headline em{font-style:normal;background:linear-gradient(135deg,#a5b4fc,#818cf8);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
    .left-sub{color:rgba(255,255,255,.5);font-size:16px;max-width:380px;line-height:1.65;}

    .left-stats{display:flex;gap:32px;margin-top:48px;}
    .ls-item .num{font-family:'Outfit',sans-serif;color:#fff;font-size:28px;font-weight:800;letter-spacing:-.02em;}
    .ls-item .lbl{color:rgba(255,255,255,.4);font-size:12px;margin-top:2px;}

    .left-badge{
        display:inline-flex;align-items:center;gap:8px;
        background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.12);
        border-radius:20px;padding:6px 14px;margin-bottom:28px;
        color:rgba(255,255,255,.65);font-size:12.5px;
        backdrop-filter:blur(8px);
    }
    .left-badge i{color:#a5b4fc;}

    /* Right panel */
    .panel-right{
        width:480px;flex-shrink:0;display:flex;align-items:center;justify-content:center;
        padding:40px;position:relative;z-index:1;
    }
    @media(max-width:900px){.panel-right{width:100%;}}

    .login-card{
        width:100%;background:rgba(255,255,255,.04);
        border:1px solid rgba(255,255,255,.1);
        border-radius:24px;padding:36px;
        backdrop-filter:blur(24px) saturate(150%);
        box-shadow:0 24px 80px rgba(0,0,0,.4),inset 0 1px 0 rgba(255,255,255,.08);
        animation:cardIn .5s cubic-bezier(.16,1,.3,1);
    }
    @keyframes cardIn{from{opacity:0;transform:translateY(24px) scale(.97);}to{opacity:1;transform:none;}}

    .card-logo{display:flex;align-items:center;gap:10px;margin-bottom:28px;}
    .card-logo-icon{width:36px;height:36px;border-radius:9px;background:linear-gradient(135deg,#6366f1,#4338ca);display:flex;align-items:center;justify-content:center;}
    .card-logo-icon i{color:#fff;font-size:15px;}
    .card-logo span{font-family:'Outfit',sans-serif;color:#fff;font-weight:700;font-size:15px;}

    .card-heading{font-family:'Outfit',sans-serif;color:#fff;font-size:22px;font-weight:750;letter-spacing:-.02em;margin-bottom:5px;}
    .card-sub{color:rgba(255,255,255,.4);font-size:13px;margin-bottom:28px;}

    .form-group{margin-bottom:14px;}
    .form-label{display:block;margin-bottom:5px;font-size:12px;font-weight:600;color:rgba(255,255,255,.6);letter-spacing:.03em;text-transform:uppercase;}
    .form-input{
        width:100%;padding:11px 13px;border-radius:10px;font-size:13.5px;
        background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);
        color:#fff;font-family:'DM Sans',sans-serif;outline:none;
        transition:all .2s;
    }
    .form-input:focus{background:rgba(255,255,255,.1);border-color:rgba(99,102,241,.6);box-shadow:0 0 0 3px rgba(99,102,241,.15);}
    .form-input::placeholder{color:rgba(255,255,255,.25);}
    .pw-wrap{position:relative;}
    .pw-wrap .form-input{padding-right:42px;}
    .pw-toggle{position:absolute;right:12px;top:50%;transform:translateY(-50%);color:rgba(255,255,255,.3);cursor:pointer;font-size:15px;transition:color .15s;}
    .pw-toggle:hover{color:rgba(255,255,255,.7);}

    .remember-row{display:flex;align-items:center;gap:8px;margin-bottom:18px;}
    .custom-cb{width:15px;height:15px;border-radius:4px;border:1.5px solid rgba(255,255,255,.2);appearance:none;background:rgba(255,255,255,.06);cursor:pointer;position:relative;transition:all .15s;flex-shrink:0;}
    .custom-cb:checked{background:#6366f1;border-color:#6366f1;}
    .custom-cb:checked::after{content:'✓';position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);color:#fff;font-size:9px;font-weight:800;}
    .remember-row label{font-size:12.5px;color:rgba(255,255,255,.4);cursor:pointer;}

    .btn-login{
        width:100%;padding:12px;border-radius:11px;
        background:linear-gradient(135deg,#6366f1,#4338ca);
        color:#fff;font-size:14px;font-weight:650;
        border:none;cursor:pointer;font-family:'DM Sans',sans-serif;
        box-shadow:0 4px 16px rgba(99,102,241,.4),inset 0 1px 0 rgba(255,255,255,.12);
        transition:all .2s cubic-bezier(.16,1,.3,1);
        display:flex;align-items:center;justify-content:center;gap:7px;
    }
    .btn-login:hover{transform:translateY(-1px);box-shadow:0 8px 28px rgba(99,102,241,.5);}
    .btn-login:active{transform:translateY(0);}

    .error-box{
        background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.25);
        border-radius:10px;padding:10px 13px;margin-bottom:16px;
        color:#fca5a5;font-size:12.5px;display:flex;align-items:center;gap:8px;
    }
    .divider-line{display:flex;align-items:center;gap:12px;margin:20px 0;}
    .divider-line::before,.divider-line::after{content:'';flex:1;height:1px;background:rgba(255,255,255,.08);}
    .divider-line span{font-size:11.5px;color:rgba(255,255,255,.3);}
    .register-link{text-align:center;font-size:13px;color:rgba(255,255,255,.4);}
    .register-link a{color:#a5b4fc;font-weight:600;text-decoration:none;transition:color .15s;}
    .register-link a:hover{color:#818cf8;}
    </style>
</head>
<body>
<div class="bg">
    <div class="bg-grid"></div>
    <div class="bg-blob b1"></div>
    <div class="bg-blob b2"></div>
    <div class="bg-blob b3"></div>
</div>

<!-- Left panel -->
<div class="panel-left">
    <div class="left-logo">
        <div class="left-logo-icon"><i class="bi bi-book-fill"></i></div>
        <h2>Pustaka Digital</h2>
    </div>
    <div class="left-badge"><i class="bi bi-stars"></i> Platform Perpustakaan Modern</div>
    <div class="left-headline">Temukan dunia<br>dalam setiap<br><em>halaman buku.</em></div>
    <p class="left-sub">Akses ribuan koleksi buku digital, kelola peminjaman, dan nikmati kemudahan membaca kapan saja.</p>
    <div class="left-stats">
        <div class="ls-item"><div class="num">500+</div><div class="lbl">Koleksi Buku</div></div>
        <div class="ls-item"><div class="num">1.2k</div><div class="lbl">Anggota Aktif</div></div>
        <div class="ls-item"><div class="num">98%</div><div class="lbl">Kepuasan</div></div>
    </div>
</div>

<!-- Right panel -->
<div class="panel-right">
    <div class="login-card">
        <div class="card-logo">
            <div class="card-logo-icon"><i class="bi bi-book-fill"></i></div>
            <span>Pustaka</span>
        </div>
        <div class="card-heading">Selamat datang</div>
        <p class="card-sub">Masuk untuk melanjutkan ke perpustakaan</p>

        @if($errors->any())
        <div class="error-box">
            <i class="bi bi-exclamation-circle-fill"></i>
            {{ $errors->first() }}
        </div>
        @endif
        @if(session('success'))
        <div class="error-box" style="background:rgba(16,185,129,.1);border-color:rgba(16,185,129,.25);color:#6ee7b7;">
            <i class="bi bi-check-circle-fill"></i>{{ session('success') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-input" placeholder="nama@email.com"
                    value="{{ old('email') }}" required autofocus>
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="pw-wrap">
                    <input type="password" name="password" class="form-input" placeholder="••••••••"
                        id="pwInput" required>
                    <i class="bi bi-eye pw-toggle" id="pwIcon" onclick="togglePw()"></i>
                </div>
            </div>
            <div class="remember-row">
                <input type="checkbox" class="custom-cb" name="remember" id="rem">
                <label for="rem">Ingat saya</label>
            </div>
            <button type="submit" class="btn-login">
                <i class="bi bi-box-arrow-in-right"></i> Masuk
            </button>
        </form>

        <div class="divider-line"><span>atau</span></div>
        <p class="register-link">Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></p>
    </div>
</div>

<script>
function togglePw(){
    const i=document.getElementById('pwInput'),ic=document.getElementById('pwIcon');
    i.type=i.type==='password'?'text':'password';
    ic.className='bi '+(i.type==='password'?'bi-eye':'bi-eye-slash')+' pw-toggle';
}
</script>
</body>
</html>
