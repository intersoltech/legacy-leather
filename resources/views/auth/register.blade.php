{{-- resources/views/auth/register.blade.php --}}
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register — Legacy Leather Works</title>

  <link rel="stylesheet" href="{{ asset('assets/style.css') }}" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"/>
  <style>
    {!! file_get_contents(public_path('assets/inline-home.css')) ?? '' !!}

    body{background: radial-gradient(1200px 600px at 20% 0%, rgba(107,63,42,.20), transparent 60%),
                 radial-gradient(900px 500px at 80% 20%, rgba(210,170,120,.18), transparent 55%),
                 #0f0f10;}
    .authWrap{min-height:100vh;display:flex;align-items:center;justify-content:center;padding:40px 16px;}
    .cardAuth{
      width:min(460px, 100%);
      background:rgba(255,255,255,.06);
      border:1px solid rgba(255,255,255,.10);
      backdrop-filter: blur(14px);
      border-radius:22px;
      box-shadow:0 30px 90px rgba(0,0,0,.45);
      overflow:hidden;
    }
    .cardTop{
      padding:18px 18px 12px;
      border-bottom:1px solid rgba(255,255,255,.10);
      display:flex;gap:12px;align-items:center;justify-content:space-between;
    }
    .brandMini{display:flex;gap:10px;align-items:center;}
    .brandMini img{width:36px;height:36px;border-radius:10px;object-fit:cover;}
    .brandMini b{color:#fff;letter-spacing:.12em;text-transform:uppercase;font-size:12px;}
    .brandMini span{display:block;color:rgba(255,255,255,.70);font-size:12px;margin-top:2px}
    .cardBody{padding:18px;}
    .title{color:#fff;font-family: ui-serif, Georgia, "Times New Roman", serif;letter-spacing:.14em;text-transform:uppercase;font-size:18px;margin:0 0 10px;}
    .sub{color:rgba(255,255,255,.70);font-size:13px;margin:0 0 16px;line-height:1.6}

    .label{color:rgba(255,255,255,.75);font-size:11px;letter-spacing:.14em;text-transform:uppercase;margin:0 0 8px;}
    .input{
      width:100%;
      border:1px solid rgba(255,255,255,.18);
      background:rgba(255,255,255,.06);
      color:#fff;
      border-radius:14px;
      padding:12px 12px;
      outline:none;
      font-size:13px;
    }
    .input:focus{border-color:rgba(210,170,120,.55);box-shadow:0 0 0 4px rgba(210,170,120,.12);}
    .input::placeholder{color:rgba(255,255,255,.40);}
    .row{margin-top:12px;}
    .btn{
      width:100%;
      border:none;
      border-radius:14px;
      padding:14px;
      background:linear-gradient(180deg,#6B3F2A 0%, #4c2b1c 100%);
      color:#fff;
      font-size:12px;
      letter-spacing:.14em;
      text-transform:uppercase;
      cursor:pointer;
      margin-top:14px;
    }
    .btn:hover{filter:brightness(.96)}
    .metaRow{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-top:12px;}
    .link{color:#d2aa78;text-decoration:none;font-size:13px;}
    .link:hover{text-decoration:underline}
    .errors{background:rgba(255,80,80,.12);border:1px solid rgba(255,80,80,.25);color:#ffd6d6;padding:10px 12px;border-radius:14px;font-size:13px;line-height:1.5;margin-bottom:12px;}
    .hint{color:rgba(255,255,255,.50);font-size:12px;margin-top:6px;line-height:1.5;}
  </style>
</head>

<body>
  <div class="authWrap">
    <div class="cardAuth">

      <div class="cardTop">
        <div class="brandMini">
          <img src="{{ asset('assets/img/logo.png') }}" alt="LLW">
          <div>
            <b>Legacy Leather Works</b>
            <span>Create Account</span>
          </div>
        </div>
        <a class="link" href="{{ url('/') }}">Go Website</a>
      </div>

      <div class="cardBody">
        <h1 class="title">Create Account</h1>
        <p class="sub">Register as a customer to track orders and manage your profile. Admin access is granted separately.</p>

        {{-- errors --}}
        @if ($errors->any())
          <div class="errors">
            @foreach ($errors->all() as $error)
              • {{ $error }} <br>
            @endforeach
          </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
          @csrf

          <div class="row">
            <div class="label">Email Address</div>
            <input class="input"
                   type="email"
                   name="email"
                   value="{{ old('email') }}"
                   required autofocus autocomplete="username"
                   placeholder="your@email.com">
            <div class="hint">We'll use this to identify you. Your name will be auto-generated from your email.</div>
          </div>

          <div class="row">
            <div class="label">Password</div>
            <input class="input"
                   type="password"
                   name="password"
                   required autocomplete="new-password"
                   placeholder="Minimum 6 characters">
            <div class="hint">Choose a password with at least 6 characters.</div>
          </div>

          <div class="row">
            <div class="label">Confirm Password</div>
            <input class="input"
                   type="password"
                   name="password_confirmation"
                   required autocomplete="new-password"
                   placeholder="Re-enter your password">
          </div>

          <button class="btn" type="submit">Create Account</button>

          <div class="metaRow" style="margin-top:16px;">
            <a class="link" href="{{ route('login') }}">
              Already have an account? Login
            </a>
          </div>
        </form>
      </div>

    </div>
  </div>
</body>
</html>
