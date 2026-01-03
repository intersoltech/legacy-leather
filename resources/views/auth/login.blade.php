{{-- resources/views/auth/login.blade.php --}}
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login — Legacy Leather Works</title>

  <link rel="stylesheet" href="{{ asset('assets/style.css') }}" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"/>
  <style>
    {!! file_get_contents(public_path('assets/inline-home.css')) ?? '' !!}

    body{background: radial-gradient(1200px 600px at 20% 0%, rgba(107,63,42,.20), transparent 60%),
                 radial-gradient(900px 500px at 80% 20%, rgba(210,170,120,.18), transparent 55%),
                 #0f0f10;}
    .authWrap{min-height:100vh;display:flex;align-items:center;justify-content:center;padding:40px 16px;}
    .cardAuth{
      width:min(520px, 100%);
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

    .infoBox{
      background:rgba(210,170,120,.08);
      border:1px solid rgba(210,170,120,.20);
      border-radius:14px;
      padding:14px;
      margin-bottom:18px;
    }
    .infoBox h3{
      color:#d2aa78;
      font-size:13px;
      letter-spacing:.12em;
      text-transform:uppercase;
      margin:0 0 10px;
      display:flex;
      align-items:center;
      gap:8px;
    }
    .infoBox ul{
      margin:0;
      padding-left:20px;
      color:rgba(255,255,255,.80);
      font-size:12px;
      line-height:1.8;
    }
    .infoBox li{margin:4px 0;}
    .roleTabs{
      display:flex;
      gap:8px;
      margin-bottom:16px;
      border-bottom:1px solid rgba(255,255,255,.10);
      padding-bottom:12px;
    }
    .roleTab{
      flex:1;
      padding:10px 12px;
      background:rgba(255,255,255,.04);
      border:1px solid rgba(255,255,255,.10);
      border-radius:10px;
      text-align:center;
      cursor:default;
      transition:all 0.2s;
    }
    .roleTab.active{
      background:rgba(210,170,120,.15);
      border-color:rgba(210,170,120,.30);
    }
    .roleTab i{
      display:block;
      font-size:18px;
      margin-bottom:6px;
      color:#d2aa78;
    }
    .roleTab span{
      display:block;
      font-size:11px;
      letter-spacing:.10em;
      text-transform:uppercase;
      color:rgba(255,255,255,.90);
      font-weight:600;
    }
    .roleTab small{
      display:block;
      font-size:10px;
      color:rgba(255,255,255,.60);
      margin-top:4px;
      text-transform:none;
      letter-spacing:0;
    }

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
    .chk{display:flex;align-items:center;gap:8px;color:rgba(255,255,255,.75);font-size:13px;}
    .link{color:#d2aa78;text-decoration:none;font-size:13px;}
    .link:hover{text-decoration:underline}
    .errors{background:rgba(255,80,80,.12);border:1px solid rgba(255,80,80,.25);color:#ffd6d6;padding:10px 12px;border-radius:14px;font-size:13px;line-height:1.5;margin-bottom:12px;}
    .registerHint{
      margin-top:16px;
      padding-top:16px;
      border-top:1px solid rgba(255,255,255,.10);
      text-align:center;
      color:rgba(255,255,255,.70);
      font-size:12px;
    }
    .registerHint a{
      color:#d2aa78;
      text-decoration:none;
      font-weight:600;
    }
    .registerHint a:hover{text-decoration:underline;}
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
            <span>Sign In</span>
          </div>
        </div>
        <a class="link" href="{{ url('/') }}">Go Website</a>
      </div>

      <div class="cardBody">
        <h1 class="title">Login</h1>
        <p class="sub">Sign in to access your account. The system will automatically route you to the appropriate dashboard based on your role.</p>

        {{-- Role Information Tabs --}}
        <div class="roleTabs">
          <div class="roleTab active">
            <i class="bi bi-person"></i>
            <span>Customer</span>
            <small>Track Orders</small>
          </div>
          <div class="roleTab active">
            <i class="bi bi-person-gear"></i>
            <span>Admin / Staff</span>
            <small>Manage Store</small>
          </div>
        </div>

        {{-- Information Box --}}
        <div class="infoBox">
          <h3><i class="bi bi-info-circle"></i> Account Access</h3>
          <ul>
            <li><strong>Customers:</strong> Track orders, view order history, and manage your profile</li>
            <li><strong>Admin/Staff:</strong> Manage products, orders, categories, banners, and site settings</li>
            <li><strong>Note:</strong> Admin access must be granted by an existing administrator</li>
          </ul>
        </div>

        @if(app()->environment('local'))
        <div class="infoBox" style="background:rgba(107,63,42,.12);border-color:rgba(107,63,42,.25);">
          <h3 style="color:#d2aa78;"><i class="bi bi-code-slash"></i> Development Mode</h3>
          <ul style="color:rgba(255,255,255,.70);">
            <li><strong>Admin Test Account:</strong> admin@legacy.com / admin12345</li>
            <li>Create customer accounts via the registration page</li>
          </ul>
        </div>
        @endif

        {{-- errors --}}
        @if ($errors->any())
          <div class="errors">
            @foreach ($errors->all() as $error)
              • {{ $error }} <br>
            @endforeach
          </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
          @csrf

          <div class="row">
            <div class="label">Email</div>
            <input class="input"
                   type="email"
                   name="email"
                   value="{{ old('email') }}"
                   required autofocus autocomplete="username"
                   placeholder="you@example.com">
          </div>

          <div class="row">
            <div class="label">Password</div>
            <input class="input"
                   type="password"
                   name="password"
                   required autocomplete="current-password"
                   placeholder="••••••••">
          </div>

          <div class="metaRow">
            <label class="chk">
              <input type="checkbox" name="remember">
              Remember me
            </label>

            @if (Route::has('password.request'))
              <a class="link" href="{{ route('password.request') }}">Forgot password?</a>
            @endif
          </div>

          <button class="btn" type="submit">
            <i class="bi bi-box-arrow-in-right" style="margin-right:6px;"></i>
            Sign In
          </button>
        </form>

        <div class="registerHint">
          Don't have an account? <a href="{{ route('register') }}">Create a customer account</a>
        </div>
      </div>

    </div>
  </div>
</body>
</html>
