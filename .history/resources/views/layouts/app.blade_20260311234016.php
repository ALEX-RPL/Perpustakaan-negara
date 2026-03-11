<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pustaka') — Perpustakaan Digital</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    :root {
        --brand-50:#eef2ff;--brand-100:#e0e7ff;--brand-400:#818cf8;
        --brand-500:#6366f1;--brand-600:#4f46e5;--brand-700:#4338ca;
        --sidebar-bg:#0d0f1a;--sidebar-border:rgba(255,255,255,.07);
        --sidebar-w:256px;--sidebar-mini:70px;
        --surface:#f4f6fb;--card:#ffffff;--card-border:rgba(99,102,241,.09);
        --card-shadow:0 1px 3px rgba(0,0,0,.04),0 8px 24px rgba(99,102,241,.06);
        --card-hover:0 4px 20px rgba(0,0,0,.07),0 24px 60px rgba(99,102,241,.13);
        --text-1:#0d0f1a;--text-2:#4b5563;--text-3:#94a3b8;
        --r-sm:8px;--r-md:12px;--r-lg:16px;--r-xl:22px;
        --ease:cubic-bezier(.16,1,.3,1);
        --t1:.15s var(--ease);--t2:.25s var(--ease);
        --green:#10b981;--green-bg:#ecfdf5;--green-b:#a7f3d0;
        --amber:#f59e0b;--amber-bg:#fffbeb;--amber-b:#fde68a;
        --red:#ef4444;--red-bg:#fef2f2;--red-b:#fecaca;
        --blue:#3b82f6;--blue-bg:#eff6ff;--blue-b:#bfdbfe;
        --purple:#8b5cf6;--purple-bg:#f5f3ff;--purple-b:#ddd6fe;
    }
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
    html{scroll-behavior:smooth;}
    body{font-family:'DM Sans',sans-serif;background:var(--surface);color:var(--text-1);min-height:100vh;font-size:14px;line-height:1.6;-webkit-font-smoothing:antialiased;}

    /* ── SIDEBAR ── */
    .sb{
        position:fixed;left:0;top:0;bottom:0;width:var(--sidebar-w);
        background:var(--sidebar-bg);border-right:1px solid var(--sidebar-border);
        display:flex;flex-direction:column;z-index:200;
        transition:width var(--t2);
        /* NO overflow:hidden — prevents toggle & dropdown clipping */
    }
    .sb.mini{width:var(--sidebar-mini);}
    .sb::after{
        content:'';position:absolute;top:-60px;left:-60px;
        width:260px;height:260px;border-radius:50%;
        background:radial-gradient(circle,rgba(99,102,241,.1) 0%,transparent 70%);
        pointer-events:none;z-index:0;
    }
    .sb-brand{
        padding:18px 16px 14px;border-bottom:1px solid var(--sidebar-border);
        display:flex;align-items:center;gap:10px;position:relative;z-index:1;flex-shrink:0;
        overflow:hidden; /* clip brand text only */
    }
    .sb-logo{
        width:34px;height:34px;border-radius:9px;flex-shrink:0;
        background:linear-gradient(135deg,var(--brand-500),var(--brand-700));
        display:flex;align-items:center;justify-content:center;
        box-shadow:0 4px 12px rgba(99,102,241,.35);
        transition:transform var(--t2);cursor:default;
    }
    .sb-logo:hover{transform:rotate(-6deg) scale(1.07);}
    .sb-logo i{color:#fff;font-size:15px;}
    .sb-name{overflow:hidden;transition:opacity var(--t2),max-width var(--t2);max-width:180px;}
    .sb-name h6{font-family:'Outfit',sans-serif;color:#fff;font-weight:700;font-size:13.5px;letter-spacing:-.01em;white-space:nowrap;}
    .sb-name span{font-size:10.5px;color:rgba(255,255,255,.3);white-space:nowrap;}
    .sb.mini .sb-name{opacity:0;max-width:0;}

    /* Toggle: fixed so it's always visible, never clipped */
    .sb-toggle{
        position:fixed;
        left:calc(var(--sidebar-w) - 12px);
        top:22px;
        width:24px;height:24px;border-radius:50%;
        background:var(--card);border:1.5px solid #e2e8f0;
        cursor:pointer;display:flex;align-items:center;justify-content:center;
        box-shadow:0 2px 8px rgba(0,0,0,.12);
        transition:left .25s cubic-bezier(.16,1,.3,1), background .15s, border-color .15s;
        z-index:210;
    }
    .sb-toggle:hover{background:var(--brand-50);border-color:var(--brand-100);}
    .sb-toggle i{font-size:10px;color:var(--text-2);transition:transform .25s cubic-bezier(.16,1,.3,1);}
    .sb-toggle.mini-mode{left:calc(var(--sidebar-mini) - 12px);}
    .sb-toggle.mini-mode i{transform:rotate(180deg);}

    .sb-scroll{flex:1;overflow-y:auto;overflow-x:hidden;padding:10px 10px;position:relative;z-index:1;scrollbar-width:none;}
    .sb-scroll::-webkit-scrollbar{display:none;}

    .sb-section{font-size:9.5px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:rgba(255,255,255,.2);padding:10px 8px 4px;white-space:nowrap;max-width:100%;overflow:hidden;transition:all var(--t2);}
    .sb.mini .sb-section{opacity:0;height:0;padding:0;}

    .sb-item{margin-bottom:1px;}
    .sb-link{
        display:flex;align-items:center;gap:10px;padding:8px 8px;border-radius:10px;
        color:rgba(255,255,255,.45);text-decoration:none;font-size:13px;font-weight:450;
        transition:all var(--t1);white-space:nowrap;position:relative;
        min-width:0; /* allow flex children to shrink */
    }
    .sb-link-icon{
        width:30px;height:30px;border-radius:7px;flex-shrink:0;
        display:flex;align-items:center;justify-content:center;font-size:14px;
        transition:all var(--t1);background:transparent;
    }
    .sb-link:hover{background:rgba(255,255,255,.06);color:rgba(255,255,255,.8);}
    .sb-link:hover .sb-link-icon{background:rgba(255,255,255,.08);}
    .sb-link.active{background:linear-gradient(135deg,rgba(99,102,241,.22),rgba(79,70,229,.12));color:#fff;box-shadow:inset 0 0 0 1px rgba(99,102,241,.22);}
    .sb-link.active .sb-link-icon{background:linear-gradient(135deg,var(--brand-500),var(--brand-700));color:#fff;box-shadow:0 3px 10px rgba(99,102,241,.4);}
    .sb-link-txt{transition:opacity var(--t2),max-width var(--t2);max-width:180px;overflow:hidden;}
    .sb.mini .sb-link-txt{opacity:0;max-width:0;}
    .sb-badge{margin-left:auto;flex-shrink:0;background:rgba(99,102,241,.3);color:var(--brand-400);font-size:9.5px;font-weight:700;padding:1px 6px;border-radius:20px;transition:opacity var(--t2);}
    .sb.mini .sb-badge{opacity:0;width:0;padding:0;overflow:hidden;}

    .sb-user{padding:10px 10px;border-top:1px solid var(--sidebar-border);position:relative;z-index:5;flex-shrink:0;}
    .sb-user-card{
        display:flex;align-items:center;gap:9px;padding:8px 10px;border-radius:11px;
        background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.06);
        cursor:pointer;text-decoration:none;transition:all var(--t1);
        min-width:0; /* no overflow:hidden — would clip dropdown */
    }
    .sb-user-card:hover{background:rgba(255,255,255,.09);}
    .sb-avatar{
        width:30px;height:30px;border-radius:8px;flex-shrink:0;
        background:linear-gradient(135deg,var(--brand-400),var(--brand-600));
        display:flex;align-items:center;justify-content:center;
        color:#fff;font-weight:700;font-size:11px;font-family:'Outfit',sans-serif;
    }
    .sb-user-info{overflow:hidden;transition:opacity var(--t2);flex:1;min-width:0;}
    .sb-user-info .n{font-size:12px;font-weight:600;color:rgba(255,255,255,.8);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
    .sb-user-info .r{font-size:10px;color:rgba(255,255,255,.28);}
    .sb.mini .sb-user-info{opacity:0;width:0;}

    /* ── MAIN ── */
    .main{margin-left:var(--sidebar-w);transition:margin-left var(--t2);min-height:100vh;display:flex;flex-direction:column;min-width:0;overflow-x:hidden;}
    .main.mini{margin-left:var(--sidebar-mini);}

    /* ── TOPBAR ── */
    .topbar{
        position:sticky;top:0;z-index:100;
        background:rgba(244,246,251,.88);backdrop-filter:blur(20px) saturate(180%);-webkit-backdrop-filter:blur(20px) saturate(180%);
        border-bottom:1px solid rgba(99,102,241,.07);
        padding:0 24px;height:60px;
        display:flex;align-items:center;justify-content:space-between;
        min-width:0; /* prevent topbar from pushing layout wide */
    }
    .page-title{font-family:'Outfit',sans-serif;font-size:17px;font-weight:700;color:var(--text-1);letter-spacing:-.02em;}
    .tb-right{display:flex;align-items:center;gap:8px;}
    .tb-btn{width:36px;height:36px;border-radius:9px;border:1.5px solid #e8ecf4;background:var(--card);display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--text-2);font-size:15px;transition:all var(--t1);}
    .tb-btn:hover{background:var(--brand-50);border-color:var(--brand-100);color:var(--brand-600);}
    .role-tag{padding:3px 10px;border-radius:20px;font-size:10.5px;font-weight:600;letter-spacing:.04em;text-transform:uppercase;}
    .rt-admin{background:var(--red-bg);color:var(--red);border:1px solid var(--red-b);}
    .rt-petugas{background:var(--amber-bg);color:#92400e;border:1px solid var(--amber-b);}
    .rt-peminjam{background:var(--blue-bg);color:var(--blue);border:1px solid var(--blue-b);}

    /* ── CONTENT ── */
    .content{padding:22px;flex:1;min-width:0;overflow-x:hidden;}
    .content>*{animation:slideUp .35s var(--ease) both;}
    .content>*:nth-child(1){animation-delay:.02s;}
    .content>*:nth-child(2){animation-delay:.06s;}
    .content>*:nth-child(3){animation-delay:.1s;}
    .content>*:nth-child(4){animation-delay:.14s;}
    .content>*:nth-child(5){animation-delay:.18s;}
    @keyframes slideUp{from{opacity:0;transform:translateY(10px);}to{opacity:1;transform:none;}}

    /* ── CARDS ── */
    .card{background:var(--card);border-radius:var(--r-lg);border:1px solid var(--card-border);box-shadow:var(--card-shadow);overflow:hidden;}
    .card-header{padding:16px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;}
    .card-title{font-family:'Outfit',sans-serif;font-size:14.5px;font-weight:650;color:var(--text-1);letter-spacing:-.01em;display:flex;align-items:center;gap:7px;}
    .card-body{padding:20px;}

    /* ── STAT CARDS ── */
    .stat-card{
        background:var(--card);border-radius:var(--r-lg);border:1px solid var(--card-border);
        box-shadow:var(--card-shadow);padding:18px 20px;
        position:relative;overflow:hidden;transition:all var(--t2);
    }
    .stat-card:hover{transform:translateY(-3px);box-shadow:var(--card-hover);}
    .stat-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--a1,#6366f1),var(--a2,#8b5cf6));opacity:0;transition:opacity var(--t2);}
    .stat-card:hover::before{opacity:1;}
    .stat-ring{position:absolute;right:-28px;bottom:-28px;width:110px;height:110px;border-radius:50%;background:var(--a1,#6366f1);opacity:.05;}
    .stat-icon{width:42px;height:42px;border-radius:11px;display:flex;align-items:center;justify-content:center;font-size:17px;flex-shrink:0;}
    .stat-num{font-family:'Outfit',sans-serif;font-size:26px;font-weight:800;letter-spacing:-.04em;line-height:1.1;color:var(--text-1);}
    .stat-lbl{font-size:11.5px;color:var(--text-3);font-weight:500;margin-top:2px;}
    .stat-delta{font-size:10.5px;font-weight:600;padding:2px 6px;border-radius:6px;display:inline-flex;align-items:center;gap:3px;margin-top:6px;}

    /* Accent variants */
    .ac-indigo{--a1:#6366f1;--a2:#8b5cf6;}
    .ac-emerald{--a1:#10b981;--a2:#059669;}
    .ac-amber{--a1:#f59e0b;--a2:#d97706;}
    .ac-rose{--a1:#ef4444;--a2:#dc2626;}
    .ac-blue{--a1:#3b82f6;--a2:#2563eb;}
    .ac-purple{--a1:#8b5cf6;--a2:#7c3aed;}

    /* ── TABLE ── */
    .tbl-wrap{overflow-x:auto;}
    .tbl{width:100%;border-collapse:collapse;}
    .tbl thead tr{background:#f8fafc;}
    .tbl thead th{padding:10px 16px;font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--text-3);white-space:nowrap;border-bottom:1.5px solid #eef2f7;text-align:left;}
    .tbl tbody tr{border-bottom:1px solid #f4f7fb;transition:background var(--t1);}
    .tbl tbody tr:last-child{border-bottom:none;}
    .tbl tbody tr:hover{background:#f9fafb;}
    .tbl td{padding:12px 16px;font-size:13px;vertical-align:middle;}

    /* ── BADGES ── */
    .badge{display:inline-flex;align-items:center;gap:5px;padding:3px 9px;border-radius:20px;font-size:11px;font-weight:600;letter-spacing:.01em;}
    .badge::before{content:'';width:5px;height:5px;border-radius:50%;background:currentColor;flex-shrink:0;}
    .b-green{background:var(--green-bg);color:var(--green);}
    .b-amber{background:var(--amber-bg);color:#92400e;}
    .b-red{background:var(--red-bg);color:var(--red);}
    .b-blue{background:var(--blue-bg);color:var(--blue);}
    .b-purple{background:var(--purple-bg);color:var(--purple);}
    .b-gray{background:#f1f5f9;color:#64748b;}

    /* ── BUTTONS ── */
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 15px;border-radius:9px;font-size:13px;font-weight:550;border:none;cursor:pointer;transition:all var(--t1);text-decoration:none;white-space:nowrap;font-family:'DM Sans',sans-serif;}
    .btn i{font-size:13px;}
    .btn-primary{background:linear-gradient(135deg,var(--brand-500),var(--brand-700));color:#fff;box-shadow:0 2px 8px rgba(99,102,241,.28),inset 0 1px 0 rgba(255,255,255,.12);}
    .btn-primary:hover{transform:translateY(-1px);box-shadow:0 6px 18px rgba(99,102,241,.38);}
    .btn-ghost{background:transparent;color:var(--text-2);border:1.5px solid #e8ecf4;}
    .btn-ghost:hover{background:var(--brand-50);color:var(--brand-600);border-color:var(--brand-100);}
    .btn-red{background:var(--red-bg);color:var(--red);border:1.5px solid var(--red-b);}
    .btn-red:hover{background:var(--red);color:#fff;}
    .btn-green{background:var(--green-bg);color:var(--green);border:1.5px solid var(--green-b);}
    .btn-green:hover{background:var(--green);color:#fff;}
    .btn-sm{padding:5px 11px;font-size:12px;border-radius:7px;}
    .btn-icon{width:32px;height:32px;padding:0;justify-content:center;border-radius:8px;}
    .btn-icon.btn-sm{width:28px;height:28px;font-size:12px;}

    /* ── FORMS ── */
    .fg{margin-bottom:16px;}
    .lbl{display:block;margin-bottom:5px;font-size:12px;font-weight:600;color:var(--text-1);letter-spacing:.01em;}
    .lbl .req{color:var(--red);}
    .input,.select,.textarea{width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;color:var(--text-1);background:var(--card);font-family:'DM Sans',sans-serif;transition:all var(--t1);outline:none;appearance:none;}
    .input:focus,.select:focus,.textarea:focus{border-color:var(--brand-400);box-shadow:0 0 0 3px rgba(99,102,241,.1);}
    .input::placeholder{color:var(--text-3);}
    .hint{font-size:11px;color:var(--text-3);margin-top:4px;}
    .err{font-size:11px;color:var(--red);margin-top:4px;}
    .input.invalid,.select.invalid{border-color:var(--red);}
    .input-icon-wrap{position:relative;}
    .input-icon-wrap i{position:absolute;left:11px;top:50%;transform:translateY(-50%);color:var(--text-3);font-size:14px;pointer-events:none;}
    .input-icon-wrap .input{padding-left:36px;}

    /* ── ALERTS ── */
    .alert{padding:12px 15px;border-radius:11px;font-size:13px;display:flex;align-items:flex-start;gap:9px;border:1px solid;margin-bottom:14px;animation:slideUp .3s var(--ease);}
    .alert-success{background:var(--green-bg);color:#065f46;border-color:var(--green-b);}
    .alert-danger{background:var(--red-bg);color:#991b1b;border-color:var(--red-b);}
    .alert-warning{background:var(--amber-bg);color:#92400e;border-color:var(--amber-b);}
    .alert-close{margin-left:auto;cursor:pointer;background:none;border:none;opacity:.5;font-size:15px;transition:opacity var(--t1);color:inherit;}
    .alert-close:hover{opacity:1;}

    /* ── SEARCH ── */
    .search{display:flex;align-items:center;gap:8px;background:var(--card);border:1.5px solid #e2e8f0;border-radius:9px;padding:0 12px;transition:all var(--t1);}
    .search:focus-within{border-color:var(--brand-400);box-shadow:0 0 0 3px rgba(99,102,241,.1);}
    .search i{color:var(--text-3);font-size:14px;}
    .search input{border:none;outline:none;background:transparent;font-size:13px;color:var(--text-1);padding:8px 0;width:100%;font-family:'DM Sans',sans-serif;}
    .search input::placeholder{color:var(--text-3);}

    /* ── MODAL ── */
    .modal-bg{position:fixed;inset:0;background:rgba(10,12,26,.45);backdrop-filter:blur(4px);z-index:500;display:none;align-items:center;justify-content:center;padding:20px;}
    .modal-bg.open{display:flex;animation:fadeIn .2s ease;}
    @keyframes fadeIn{from{opacity:0;}to{opacity:1;}}
    .modal{background:var(--card);border-radius:var(--r-xl);width:100%;max-width:460px;box-shadow:0 24px 80px rgba(0,0,0,.18);animation:modalPop .28s var(--ease);overflow:hidden;}
    @keyframes modalPop{from{opacity:0;transform:translateY(18px) scale(.95);}to{opacity:1;transform:none;}}
    .modal-head{padding:20px 22px 0;display:flex;align-items:center;justify-content:space-between;}
    .modal-title{font-family:'Outfit',sans-serif;font-size:16px;font-weight:700;color:var(--text-1);}
    .modal-close-btn{width:28px;height:28px;border-radius:7px;display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--text-3);background:none;border:none;font-size:14px;transition:all var(--t1);}
    .modal-close-btn:hover{background:#f1f5f9;color:var(--text-1);}
    .modal-body{padding:14px 22px 22px;}
    .modal-foot{padding:14px 22px;border-top:1px solid #f1f5f9;display:flex;align-items:center;justify-content:flex-end;gap:8px;}

    /* ── DROPDOWN ── */
    .dd{position:relative;}
    .dd-menu{
        position:absolute;top:calc(100% + 5px);right:0;
        background:var(--card);border-radius:var(--r-md);
        border:1px solid #e8ecf4;box-shadow:0 8px 30px rgba(0,0,0,.15);
        min-width:200px;padding:5px;
        z-index:500; /* high enough to escape any stacking context */
        display:none;
    }
    .dd-menu.open{display:block;animation:ddIn .2s var(--ease);}
    /* .up = menu opens upward (for user card at bottom of sidebar) */
    .dd-menu.up{bottom:calc(100% + 5px);top:auto;right:0;}
    @keyframes ddIn{from{opacity:0;transform:translateY(-6px);}to{opacity:1;transform:none;}}
    .dd-menu.up.open{animation:ddInUp .2s var(--ease);}
    @keyframes ddInUp{from{opacity:0;transform:translateY(6px);}to{opacity:1;transform:none;}}
    .dd-item{display:flex;align-items:center;gap:8px;padding:7px 9px;border-radius:7px;font-size:12.5px;color:var(--text-1);cursor:pointer;text-decoration:none;transition:background var(--t1);background:none;border:none;width:100%;font-family:inherit;text-align:left;}
    .dd-item:hover{background:#f8fafc;}
    .dd-item.danger{color:var(--red);}
    .dd-item.danger:hover{background:var(--red-bg);}
    .dd-sep{height:1px;background:#f1f5f9;margin:4px 0;}
    .dd-head{padding:5px 9px;font-size:10px;font-weight:700;color:var(--text-3);text-transform:uppercase;letter-spacing:.08em;word-break:break-all;}

    /* ── EMPTY STATE ── */
    .empty{text-align:center;padding:50px 20px;}
    .empty-icon{width:64px;height:64px;border-radius:18px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;font-size:26px;color:var(--text-3);}
    .empty h6{font-family:'Outfit',sans-serif;font-size:15px;font-weight:650;color:var(--text-1);margin-bottom:5px;}
    .empty p{font-size:12.5px;color:var(--text-3);}

    /* ── GRID ── */
    .grid{display:grid;gap:16px;}
    .g2{grid-template-columns:repeat(2,minmax(0,1fr));}
    .g3{grid-template-columns:repeat(3,minmax(0,1fr));}
    .g4{grid-template-columns:repeat(4,minmax(0,1fr));}
    .gstats{grid-template-columns:repeat(auto-fit,minmax(180px,1fr));}
    @media(max-width:1024px){.g4{grid-template-columns:repeat(2,minmax(0,1fr));}}
    @media(max-width:900px){.g3{grid-template-columns:repeat(2,minmax(0,1fr));}}
    @media(max-width:640px){.g4,.g3,.g2{grid-template-columns:minmax(0,1fr);}}

    /* ── UTILS ── */
    .flex{display:flex;}.items-center{align-items:center;}.items-start{align-items:flex-start;}
    .justify-between{justify-content:space-between;}.justify-end{justify-content:flex-end;}
    .flex-wrap{flex-wrap:wrap;}.flex-1{flex:1;min-width:0;}
    .gap-1{gap:4px;}.gap-2{gap:8px;}.gap-3{gap:12px;}.gap-4{gap:16px;}.gap-6{gap:22px;}
    .mb-1{margin-bottom:4px;}.mb-2{margin-bottom:8px;}.mb-3{margin-bottom:12px;}.mb-4{margin-bottom:16px;}.mb-6{margin-bottom:22px;}
    .mt-3{margin-top:12px;}.mt-4{margin-top:16px;}.mt-6{margin-top:22px;}
    .ml-auto{margin-left:auto;}.mr-auto{margin-right:auto;}
    .p-5{padding:20px;}.p-4{padding:16px;}.px-4{padding-left:16px;padding-right:16px;}
    .w-full{width:100%;max-width:100%;}
    .text-sm{font-size:12.5px;}.text-xs{font-size:11px;}
    .text-muted{color:var(--text-3);}.text-2{color:var(--text-2);}
    .font-bold{font-weight:700;}.font-med{font-weight:500;}.font-sem{font-weight:600;}
    .truncate{overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:100%;}
    .rounded-full{border-radius:9999px;}.overflow-hidden{overflow:hidden;}
    .code{font-family:'Fira Code',monospace;font-size:11.5px;background:#f1f5f9;padding:1px 6px;border-radius:5px;color:var(--brand-600);white-space:nowrap;}
    .avatar{width:34px;height:34px;border-radius:9px;background:linear-gradient(135deg,var(--brand-400),var(--brand-600));color:#fff;font-weight:700;font-size:12px;display:flex;align-items:center;justify-content:center;font-family:'Outfit',sans-serif;flex-shrink:0;}

    /* ── MOBILE ── */
    .mob-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:150;backdrop-filter:blur(2px);}
    @media(max-width:768px){
        .sb{transform:translateX(-100%);width:var(--sidebar-w)!important;}
        .sb.open{transform:translateX(0);}
        .main{margin-left:0!important;}
        .mob-overlay{display:block;opacity:0;pointer-events:none;transition:opacity var(--t2);}
        .mob-overlay.show{opacity:1;pointer-events:auto;}
        .content{padding:14px;}
        .topbar{padding:0 14px;}
        .hide-mob{display:none!important;}
        .sb-toggle{display:none!important;} /* hide desktop toggle on mobile */
    }
    body{overflow-x:hidden;} /* prevent any horizontal scrollbar */
    @media print{.sb,.topbar,.sb-toggle{display:none!important;}.main{margin-left:0!important;}.content{padding:0!important;}}
    </style>
</head>
<body>
<div class="mob-overlay" id="mobOverlay" onclick="closeSb()"></div>

<aside class="sb" id="sb">
    <div class="sb-brand">
        <div class="sb-logo"><i class="bi bi-book-fill"></i></div>
        <div class="sb-name"><h6>Pustaka</h6><span>Digital Library</span></div>
    </div>
    <div class="sb-scroll">
        @auth
            @if(auth()->user()->isAdministrator()) @include('layouts.partials.nav-admin')
            @elseif(auth()->user()->isPetugas())    @include('layouts.partials.nav-petugas')
            @else                                   @include('layouts.partials.nav-peminjam')
            @endif
        @endauth
    </div>
    @auth
    <div class="sb-user">
        <div class="dd">
            <div class="sb-user-card" onclick="ddToggle('udMenu')">
                <div class="sb-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
                <div class="sb-user-info">
                    <div class="n">{{ auth()->user()->name }}</div>
                    <div class="r">{{ ucfirst(auth()->user()->role) }}</div>
                </div>
                <i class="bi bi-three-dots-vertical" style="color:rgba(255,255,255,.22);font-size:12px;margin-left:auto;flex-shrink:0;"></i>
            </div>
            <div class="dd-menu up" id="udMenu">
                <div class="dd-head">{{ Str::limit(auth()->user()->email, 26) }}</div>
                <div class="dd-sep"></div>
                <a href="{{ route('profile.edit') }}" class="dd-item"><i class="bi bi-person"></i>Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dd-item danger"><i class="bi bi-box-arrow-right"></i>Keluar</button>
                </form>
            </div>
        </div>
    </div>
    @endauth
</aside>

{{-- Toggle button: lives OUTSIDE sidebar so it's never clipped --}}
<button class="sb-toggle" id="sbToggle" onclick="toggleSb()" title="Toggle sidebar">
    <i class="bi bi-chevron-left" id="sbToggleIcon"></i>
</button>

<div class="main" id="main">
    <header class="topbar">
        <div class="flex items-center gap-3">
            <button class="tb-btn" id="mobBtn" onclick="openSb()" style="display:none;"><i class="bi bi-list"></i></button>
            <h1 class="page-title">@yield('page-title','Dashboard')</h1>
        </div>
        <div class="tb-right">
            @auth
            <span class="role-tag rt-{{ auth()->user()->role }}">{{ ucfirst(auth()->user()->role) }}</span>
            @endauth
        </div>
    </header>

    <main class="content">
        @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
            <button class="alert-close" onclick="this.parentElement.remove()"><i class="bi bi-x"></i></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-circle-fill"></i>
            <span>{{ session('error') }}</span>
            <button class="alert-close" onclick="this.parentElement.remove()"><i class="bi bi-x"></i></button>
        </div>
        @endif
        @yield('content')
    </main>
</div>

<script>
const sb      = document.getElementById('sb');
const mainEl  = document.getElementById('main');
const overlay = document.getElementById('mobOverlay');
const toggle  = document.getElementById('sbToggle');
const togIcon = document.getElementById('sbToggleIcon');

let mini = localStorage.getItem('sbMini') === 'true';

function applyMini(isMini) {
    sb.classList.toggle('mini', isMini);
    mainEl.classList.toggle('mini', isMini);
    toggle.classList.toggle('mini-mode', isMini);
}

// Init
applyMini(mini);

function toggleSb() {
    mini = !mini;
    applyMini(mini);
    localStorage.setItem('sbMini', mini);
}

function openSb() {
    sb.classList.add('open');
    overlay.classList.add('show');
}
function closeSb() {
    sb.classList.remove('open');
    overlay.classList.remove('show');
}

// Dropdown
function ddToggle(id) {
    const m = document.getElementById(id);
    m.classList.toggle('open');
}
document.addEventListener('click', e => {
    document.querySelectorAll('.dd-menu.open').forEach(m => {
        if (!m.closest('.dd').contains(e.target)) m.classList.remove('open');
    });
});

// Mobile menu button visibility
const mobBtn = document.getElementById('mobBtn');
function checkMobile() {
    const isMob = window.innerWidth <= 768;
    if (mobBtn) mobBtn.style.display = isMob ? 'flex' : 'none';
    if (toggle) toggle.style.display = isMob ? 'none' : 'flex';
}
checkMobile();
window.addEventListener('resize', checkMobile);

// Auto-dismiss alerts
setTimeout(() => {
    document.querySelectorAll('.alert').forEach(a => {
        a.style.transition = 'opacity .5s, transform .5s';
        a.style.opacity = '0';
        a.style.transform = 'translateY(-6px)';
        setTimeout(() => a.remove(), 500);
    });
}, 4000);
</script>
@stack('scripts')
</body>
</html>
