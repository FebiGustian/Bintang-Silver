<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/favicon.png') }}">
    <title>@yield('title') | Bintang Silver</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f4f7fb; color: #172033; }
        .sidebar { position: fixed; inset: 0 auto 0 0; width: 245px; background: #101b35; color: white; padding: 28px 18px; }
        .brand { font-size: 25px; font-weight: bold; margin: 0 10px 45px; letter-spacing: 1px; }
        .brand span { color: #60a5fa; }
        .menu-label { color: #8290aa; font-size: 11px; margin: 25px 12px 12px; }
        .menu a { display: block; color: #bdc8dc; text-decoration: none; padding: 13px 14px; border-radius: 8px; margin-bottom: 5px; font-size: 14px; }
        .menu a:hover, .menu a.active { background: #2563eb; color: white; }
        .main { margin-left: 245px; padding: 32px 38px; }
        .top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 35px; }
        .top small { color: #78849a; }
        h1 { margin: 0 0 8px; font-size: 27px; }
        .subtitle { color: #8490a3; font-size: 14px; }
        .button { display: inline-block; background: #2563eb; color: white; text-decoration: none; border: 0; border-radius: 8px; padding: 12px 18px; cursor: pointer; font-size: 13px; }
        .button-secondary { background: #e2e8f0; color: #172033; }
        .toolbar { display: flex; justify-content: space-between; gap: 15px; margin: 25px 0 18px; }
        input[type=search] { width: 330px; max-width: 100%; padding: 12px 14px; border: 1px solid #e0e6ef; border-radius: 8px; font-size: 14px; }
        .panel { background: white; border: 1px solid #e9edf4; border-radius: 12px; padding: 22px; box-shadow: 0 3px 15px #1e293b08; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th { text-align: left; color: #8490a3; font-size: 11px; padding: 15px 10px; border-bottom: 1px solid #edf0f5; }
        td { padding: 16px 10px; border-bottom: 1px solid #f0f2f6; }
        .sku { color: #64748b; }
        .status { color: #15803d; background: #dcfce7; padding: 5px 9px; border-radius: 20px; font-size: 11px; }
        .low { color: #b45309; background: #fef3c7; padding: 5px 9px; border-radius: 20px; font-size: 11px; }
        .actions { display: flex; gap: 10px; align-items: center; }
        .actions a { color: #2563eb; text-decoration: none; }
        .actions button { border: 0; background: none; color: #dc2626; cursor: pointer; font-size: 13px; }
        .pagination { margin-top: 20px; }
        .alert { padding: 13px; background: #dcfce7; color: #166534; border-radius: 8px; margin-bottom: 18px; }
        .alert-error { background: #fee2e2; color: #991b1b; }
        .empty { text-align: center; padding: 45px; color: #8490a3; }
        .form-panel { max-width: 560px; margin-left: auto; }
        .actions .button { background: #2563eb; color: white; padding: 12px 18px; border-radius: 8px; font-size: 13px; }
        .actions .button-secondary { background: #e2e8f0; color: #172033; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-size: 13px; margin-bottom: 6px; color: #475569; }
        .form-group input[type=text], .form-group input[type=number], .form-group select, .form-group textarea { width: 100%; padding: 12px 14px; border: 1px solid #e0e6ef; border-radius: 8px; font-size: 14px; font-family: inherit; }
        .form-group input[type=color] { width: 60px; height: 40px; padding: 2px; border: 1px solid #e0e6ef; border-radius: 8px; }
        .error-text { color: #dc2626; font-size: 12px; margin: 6px 0 0; }
        .swatch { display: inline-block; width: 18px; height: 18px; border-radius: 4px; border: 1px solid #e0e6ef; vertical-align: middle; }
        @media(max-width: 800px) {
            .sidebar { width: 190px; }
            .main { margin-left: 190px; padding: 22px 15px; overflow-x: auto; }
        }
    </style>
    @include('layouts.theme')
</head>
<body>
<aside class="sidebar">
    <div class="brand" style="display:flex;align-items:center;gap:10px">
        <img src="{{ asset('images/logo.png') }}" alt="" style="width:42px;height:42px;border-radius:50%">
        <span style="color:inherit">BINTANG SILVER</span>
    </div>
    <div class="menu-label">MAIN MENU</div>
    <nav class="menu">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">▦ &nbsp; Dashboard</a>
        <a href="{{ route('barang.index') }}" class="{{ request()->routeIs('barang.*') ? 'active' : '' }}">▤ &nbsp; Products</a>
        <a href="{{ route('kategori.index') }}" class="{{ request()->routeIs('kategori.*') ? 'active' : '' }}">▧ &nbsp; Categories</a>
        <a href="#">♙ &nbsp; Suppliers</a>
    </nav>
    <div class="menu-label">INVENTORY</div>
    <nav class="menu">
        <a href="#">↓ &nbsp; Stock In</a>
        <a href="#">↑ &nbsp; Stock Out</a>
        <a href="#">▤ &nbsp; Reports</a>
    </nav>
</aside>

<main class="main">
    <header class="top">
        <div>
            <h1>@yield('title')</h1>
            <div class="subtitle">@yield('subtitle')</div>
        </div>
        <div style="display:flex;align-items:center;gap:14px">
            <small>{{ auth()->user()->name }}, cabang {{ \App\Models\Cabang::find(session('cabang_id'))?->nama_cabang ?? 'semua' }}</small>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="button button-secondary" style="padding:8px 14px">Keluar</button>
            </form>
        </div>

    </header>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-error">
            <strong>Data belum bisa disimpan:</strong>
            <ul style="margin:8px 0 0 18px;padding:0">
                @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</main>
</body>
</html>
