<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('images/favicon.png') }}">
    <title>Masuk - BINTANG SILVER</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center; background: #f3f4f6; font-family: system-ui, sans-serif; }
        .card { width: 100%; max-width: 380px; background: #fff; padding: 32px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,.08); }
        .brand { display: flex; align-items: center; gap: 10px; justify-content: center; margin-bottom: 24px; font-weight: 700; font-size: 18px; }
        .brand img { width: 42px; height: 42px; border-radius: 50%; }
        label { display: block; margin: 14px 0 6px; font-size: 14px; }
        input, select { width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 15px; }
        .remember { display: flex; align-items: center; gap: 8px; margin-top: 14px; }
        .remember input { width: auto; }
        button { width: 100%; margin-top: 22px; padding: 11px; border: 0; border-radius: 8px; background: #111827; color: #fff; font-size: 15px; cursor: pointer; }
        .error { margin-top: 14px; padding: 10px 12px; background: #fee2e2; color: #991b1b; border-radius: 8px; font-size: 14px; }
    </style>
</head>
<body>
    <div class="card">
        <div class="brand">
            <img src="{{ asset('images/logo.png') }}" alt="">
            <span>BINTANG SILVER</span>
        </div>

        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('login.attempt') }}" method="POST">
            @csrf

            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>

            <label for="password">Kata sandi</label>
            <input id="password" type="password" name="password" required>

            <label for="cabang_id">Cabang</label>
            <select id="cabang_id" name="cabang_id" required>
                <option value="">Pilih cabang</option>
                @foreach ($cabangs as $wilayah => $items)
                    <optgroup label="{{ $wilayah }}">
                        @foreach ($items as $cabang)
                            <option value="{{ $cabang->id }}" @selected(old('cabang_id') == $cabang->id)>{{ $cabang->nama_cabang }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>

            <label class="remember">
                <input type="checkbox" name="remember" value="1"> Ingat saya
            </label>

            <button type="submit">Masuk</button>
        </form>
    </div>
</body>
</html>