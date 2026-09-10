<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Perpustakaan</title>
  <link rel="stylesheet" href="https://public.codepenassets.com/css/normalize-5.0.0.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    @import url("https://fonts.googleapis.com/css?family=Montserrat:400,600,700");

    *, *::after, *::before {
      margin: 0;
      padding: 0;
      box-sizing: inherit;
    }

    html {
      height: 100%;
      font-size: 65.2%;
      box-sizing: border-box;
      font-family: Montserrat, sans-serif;
      -webkit-font-smoothing: antialiased;
      font-weight: 400;
    }

    body {
      height: 100%;
      background: #e9ebee;
      display: flex;
      align-items: center;
      flex-direction: column;
      justify-content: center;
      perspective: 1500px;
    }

    #container {
      width: 95%;
      max-width: 800px;
      height: 570px;
      position: relative;
      border-radius: 20px;
      box-shadow: 0 14px 28px -10px rgba(0, 0, 0, 0.12), 0 10px 10px -10px rgba(0, 0, 0, 0.04);
      transform-style: preserve-3d;
      background: #ffffff;
    }

    #container > div {
      position: absolute;
      width: 50%;
      min-width: 350px;
      height: 100%;
      top: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    .content {
      width: 100%;
      padding: 1.8em 3.2em;
      text-align: center;
      box-sizing: border-box;
    }

    .register .content {
      padding: 1.2em 3em;
    }

    .login {
      left: 0;
      background: #ffffff;
      border-radius: 20px 0 0 20px;
    }

    .register {
      right: 0;
      z-index: 1;
      border-radius: 0 20px 20px 0;
      background: #ffffff;
    }

    .login h1, .register h1 {
      font-weight: 700;
      font-size: 3.2em;
      color: #0F2854;
      text-align: center;
      margin-bottom: 0.3em;
    }

    .register h1 {
      font-size: 2.8em;
      margin-bottom: 0.2em;
    }

    /* Clean, tasteful inputs */
    form input[type="text"],
    form input[type="email"],
    form input[type="password"] {
      background: #f1f3f5;
      border: 1px solid #e1e4e8;
      border-radius: 8px;
      padding: 11px 14px;
      margin: 6px 0;
      width: 100%;
      font-size: 1.35em;
      color: #333;
      font-family: inherit;
      box-sizing: border-box;
      transition: background 0.2s ease, border-color 0.2s ease;
    }

    .register form input[type="text"],
    .register form input[type="email"],
    .register form input[type="password"] {
      padding: 8px 12px;
      margin: 3.5px 0;
      font-size: 1.25em;
      border-radius: 7px;
    }

    form input[type="text"]:focus,
    form input[type="email"]:focus,
    form input[type="password"]:focus {
      outline: none;
      background: #ffffff;
      border-color: #0F2854;
      box-shadow: 0 0 0 2px rgba(15, 40, 84, 0.1);
    }

    .password-wrapper {
      position: relative;
      margin: 6px 0;
      width: 100%;
    }

    .register .password-wrapper {
      margin: 3.5px 0;
    }

    .password-wrapper input {
      padding-right: 48px !important;
      margin: 0 !important;
      width: 100%;
    }

    .password-toggle {
      position: absolute;
      right: 14px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      background: none !important;
      border: none !important;
      padding: 0 !important;
      margin: 0 !important;
      display: flex !important;
      align-items: center;
      justify-content: center;
      color: #888;
      font-size: 1.2em;
      width: auto !important;
      height: auto !important;
      z-index: 10;
      transition: color 0.2s ease;
    }

    .password-toggle:hover {
      color: #0F2854;
    }

    .password-toggle svg {
      width: 20px;
      height: 20px;
      stroke: currentColor;
      fill: none;
      stroke-width: 2.2;
    }

    /* Checkbox & text */
    .remember-container {
      display: flex;
      align-items: center;
      cursor: pointer;
      margin: 8px 0 10px 0;
    }

    .register .remember-container {
      margin: 5px 0 6px 0;
    }

    .remember-container input[type="checkbox"] {
      width: 1.3em;
      height: 1.3em;
      margin-right: 8px;
      cursor: pointer;
      accent-color: #0F2854;
    }

    span.remember-text {
      margin: 0;
      font-size: 1.2em;
      color: #555;
    }

    span.clearfix {
      clear: both;
      display: table;
    }

    /* Submit buttons on card (Desktop & Mobile) */
    .login button[type="submit"],
    .register button[type="submit"],
    .mobile-card button[type="submit"] {
      display: block;
      width: 100%;
      margin: 10px auto 6px;
      border-radius: 8px;
      border: none;
      background: linear-gradient(-45deg, #0F2854 30%, #3574b5 100%);
      color: #fff;
      font-size: 1.25em;
      font-weight: bold;
      padding: 12px 20px;
      letter-spacing: 1px;
      text-transform: uppercase;
      cursor: pointer;
      box-shadow: 0 4px 10px rgba(15, 40, 84, 0.2);
      transition: opacity 0.2s ease, transform 0.08s ease;
      font-family: inherit;
      box-sizing: border-box;
    }

    .register button[type="submit"] {
      padding: 9px 18px;
      margin: 6px auto 4px;
      font-size: 1.15em;
    }

    .login button[type="submit"]:hover,
    .register button[type="submit"]:hover,
    .mobile-card button[type="submit"]:hover {
      opacity: 0.92;
    }

    .login button[type="submit"]:active,
    .register button[type="submit"]:active,
    .mobile-card button[type="submit"]:active {
      transform: scale(0.98);
    }

    /* Divider */
    .divider-or {
      display: flex;
      align-items: center;
      text-align: center;
      margin: 8px 0 6px 0;
      width: 100%;
    }

    .register .divider-or {
      margin: 4px 0 3px 0;
    }

    .divider-or::before,
    .divider-or::after {
      content: '';
      flex: 1;
      border-bottom: 1px solid #e0e0e0;
    }

    .divider-or span {
      padding: 0 10px;
      color: #888;
      font-size: 1.1em;
      margin: 0;
      font-weight: 500;
    }

    /* Google Button */
    .btn-google {
      display: flex !important;
      align-items: center;
      justify-content: center;
      gap: 10px;
      width: 100%;
      background: #ffffff !important;
      color: #374151 !important;
      border: 1px solid #d1d5db !important;
      border-radius: 8px !important;
      padding: 9px 16px !important;
      font-size: 1.2em !important;
      font-weight: 600 !important;
      text-decoration: none;
      box-shadow: 0 1px 2px rgba(0,0,0,0.05);
      transition: background 0.2s ease, border-color 0.2s ease;
      margin: 6px 0 8px 0 !important;
      box-sizing: border-box;
      cursor: pointer;
      font-family: inherit;
    }

    .register .btn-google {
      padding: 7.5px 14px !important;
      margin: 3px 0 4px 0 !important;
    }

    .btn-google:hover {
      background: #f9fafb !important;
      border-color: #9ca3af !important;
    }

    .btn-google svg {
      margin: 0 !important;
      flex-shrink: 0;
    }

    .btn-google span {
      margin: 0 !important;
      font-size: 1em !important;
      color: inherit !important;
      font-weight: 600 !important;
    }

    .kembali {
      display: block;
      margin-top: 10px;
      font-size: 1.2em;
      color: #0F2854;
      text-decoration: none;
      font-weight: 500;
      transition: opacity 0.2s ease;
    }

    .kembali:hover {
      opacity: 0.75;
      text-decoration: underline;
    }

    /* 3D Animated Flip Pages */
    .page {
      right: 0;
      color: #fff;
      border-radius: 0 20px 20px 0;
      transform-origin: left center;
      transition: -webkit-animation 1s linear;
      transition: animation 1s linear;
      transition: animation 1s linear, -webkit-animation 1s linear;
    }

    .front {
      background: linear-gradient(-45deg, #0F2854 30%, #3574b5 100%) no-repeat 0 0/200%;
      z-index: 3;
    }

    .back {
      background: linear-gradient(135deg, #3574b5 0%, #0F2854 100%) no-repeat 0 0/200%;
      z-index: 2;
    }

    .page .content > svg {
      margin-bottom: 1em;
      stroke: #fff;
    }

    .page h1 {
      color: #fff;
      font-size: 3.2em;
      font-weight: 700;
      margin-bottom: 0.3em;
    }

    .page p {
      color: rgba(255, 255, 255, 0.9);
      font-size: 1.3em;
      line-height: 1.5;
      margin: 1.5em auto;
      max-width: 290px;
    }

    .page button {
      border: 2px solid #fff;
      border-radius: 40px;
      background: transparent;
      color: #fff;
      font-size: 1.2em;
      font-weight: bold;
      padding: 0.8em 2em;
      letter-spacing: 1px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      cursor: pointer;
      transition: background 0.2s ease, transform 0.08s ease;
      font-family: inherit;
    }

    .page button svg {
      stroke: #fff;
      vertical-align: middle;
    }

    .page button:hover {
      background: rgba(255, 255, 255, 0.15);
    }

    .page button:active {
      transform: scale(0.96);
    }

    .back .content {
      transform: rotateY(180deg);
    }

    .active .front {
      -webkit-animation: rot-front 0.6s ease-in-out normal forwards;
              animation: rot-front 0.6s ease-in-out normal forwards;
    }

    .active .back {
      -webkit-animation: rot-back 0.6s ease-in-out normal forwards;
              animation: rot-back 0.6s ease-in-out normal forwards;
    }

    .close .front {
      -webkit-animation: close-rot-front 0.6s ease-in-out normal forwards;
              animation: close-rot-front 0.6s ease-in-out normal forwards;
    }

    .close .back {
      -webkit-animation: close-rot-back 0.6s ease-in-out normal forwards;
              animation: close-rot-back 0.6s ease-in-out normal forwards;
    }

    @-webkit-keyframes rot-front {
      from {
        transform: translateZ(2px) rotateY(0deg);
      }
      to {
        transform: translateZ(1px) rotateY(-180deg);
      }
    }

    @keyframes rot-front {
      from {
        transform: translateZ(2px) rotateY(0deg);
      }
      to {
        transform: translateZ(1px) rotateY(-180deg);
      }
    }
    @-webkit-keyframes close-rot-front {
      from {
        transform: translateZ(1px) rotateY(-180deg);
      }
      to {
        transform: translateZ(2px) rotateY(0deg);
      }
    }
    @keyframes close-rot-front {
      from {
        transform: translateZ(1px) rotateY(-180deg);
      }
      to {
        transform: translateZ(2px) rotateY(0deg);
      }
    }
    @-webkit-keyframes rot-back {
      from {
        transform: translateZ(1px) rotateY(0deg);
      }
      to {
        transform: translateZ(2px) rotateY(-180deg);
      }
    }
    @keyframes rot-back {
      from {
        transform: translateZ(1px) rotateY(0deg);
      }
      to {
        transform: translateZ(2px) rotateY(-180deg);
      }
    }
    @-webkit-keyframes close-rot-back {
      from {
        transform: translateZ(2px) rotateY(-180deg);
      }
      to {
        transform: translateZ(1px) rotateY(0deg);
      }
    }
    @keyframes close-rot-back {
      from {
        transform: translateZ(2px) rotateY(-180deg);
      }
      to {
        transform: translateZ(1px) rotateY(0deg);
      }
    }
    .active .register .content {
      -webkit-animation: show 0.7s ease-in-out normal forwards;
              animation: show 0.7s ease-in-out normal forwards;
    }

    .close .register .content {
      -webkit-animation: hide 0.7s ease-in-out normal forwards;
              animation: hide 0.7s ease-in-out normal forwards;
    }

    .active .login .content {
      -webkit-animation: hide 0.7s ease-in-out normal forwards;
              animation: hide 0.7s ease-in-out normal forwards;
    }

    .close .login .content {
      -webkit-animation: show 0.7s ease-in-out normal forwards;
              animation: show 0.7s ease-in-out normal forwards;
    }

    @-webkit-keyframes show {
      from {
        opacity: 0;
        transform: scale(0.8);
      }
      to {
        opacity: 0.99;
        transform: scale(0.99);
      }
    }

    @keyframes show {
      from {
        opacity: 0;
        transform: scale(0.8);
      }
      to {
        opacity: 0.99;
        transform: scale(0.99);
      }
    }
    @-webkit-keyframes hide {
      from {
        opacity: 0.99;
        transform: scale(0.99);
      }
      to {
        opacity: 0.99;
        transform: scale(0.8);
      }
    }
    @keyframes hide {
      from {
        opacity: 0.99;
        transform: scale(0.99);
      }
      to {
        opacity: 0;
        transform: scale(0.8);
      }
    }

    .alert {
      background: #fee;
      border: 1px solid #fcc;
      color: #c00;
      padding: 10px;
      margin: 10px 0;
      border-radius: 4px;
      font-size: 1.2em;
    }

    .alert-success {
      background: #efe;
      border: 1px solid #cfc;
      color: #060;
    }

    .popup-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(15, 23, 42, 0.65);
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 99999;
      padding: 16px;
      opacity: 0;
      transition: opacity 0.25s ease;
    }

    .popup-overlay.active {
      opacity: 1;
    }

    .popup-box {
      background: #ffffff;
      padding: 32px 28px 26px;
      border-radius: 24px;
      width: 100%;
      max-width: 380px;
      text-align: center;
      box-shadow: 0 25px 60px -15px rgba(15, 23, 42, 0.3), 0 0 0 1px rgba(226, 232, 240, 0.9);
      transform: scale(0.9) translateY(10px);
      opacity: 0;
      transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .popup-overlay.active .popup-box {
      transform: scale(1) translateY(0);
      opacity: 1;
    }

    .popup-icon-wrapper {
      width: 68px;
      height: 68px;
      border-radius: 20px;
      margin: 0 auto 18px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 30px;
      transition: all 0.3s ease;
    }

    .popup-icon-wrapper.error {
      background: #FEF2F2;
      border: 1.5px solid #FECACA;
      color: #EF4444;
      box-shadow: 0 8px 20px -6px rgba(239, 68, 68, 0.25);
    }

    .popup-icon-wrapper.success {
      background: #ECFDF5;
      border: 1.5px solid #A7F3D0;
      color: #10B981;
      box-shadow: 0 8px 20px -6px rgba(16, 185, 129, 0.25);
    }

    .popup-icon-wrapper.info {
      background: #EFF6FF;
      border: 1.5px solid #BFDBFE;
      color: #3B82F6;
      box-shadow: 0 8px 20px -6px rgba(59, 130, 246, 0.25);
    }

    .popup-box h2 {
      font-size: 2.1rem;
      font-weight: 700;
      color: #0F172A;
      margin: 0 0 8px;
      letter-spacing: -0.02em;
    }

    .popup-box p {
      font-size: 1.35rem;
      color: #64748B;
      line-height: 1.55;
      margin: 0 0 24px;
      word-break: break-word;
    }

    .popup-box button {
      width: 100%;
      border-radius: 14px;
      padding: 13px 20px;
      background: linear-gradient(135deg, #0F2854 0%, #1C4D8D 100%);
      border: none;
      color: #ffffff;
      font-size: 1.35rem;
      font-weight: 600;
      letter-spacing: 0.3px;
      cursor: pointer;
      box-shadow: 0 6px 18px -4px rgba(15, 40, 84, 0.4);
      transition: all 0.2s ease;
      outline: none;
    }

    .popup-box button:hover {
      transform: translateY(-1px);
      box-shadow: 0 8px 24px -4px rgba(15, 40, 84, 0.5);
      background: linear-gradient(135deg, #163B75 0%, #2563EB 100%);
    }

    .popup-box button:active {
      transform: translateY(0);
    }

    /* Mobile responsive adjustments */
    @media (max-width: 768px) {
      body {
        padding: 15px;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        perspective: none;
        background: #e9ebee;
      }

      /* Hide the flip animation container on mobile */
      #container {
        display: none;
      }

      /* Mobile container matching desktop style */
      .mobile-container {
        width: 100%;
        max-width: 400px;
      }

      /* Mobile header section - matching desktop overlay style */
      .mobile-header {
        background: linear-gradient(-45deg, #0F2854 30%, #3574b5 100%);
        border-radius: 20px 20px 0 0;
        padding: 2.2em 2em;
        text-align: center;
        color: #fff;
      }

      .mobile-header svg {
        width: 64px;
        height: 64px;
        stroke: #fff;
        margin-bottom: 0.8em;
      }

      .mobile-header h1 {
        color: #fff;
        font-size: 2em;
        margin-bottom: 0.3em;
      }

      .mobile-header p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.1em;
        margin: 0;
      }

      /* Mobile card style */
      .mobile-card {
        background: #ffffff;
        border-radius: 0 0 20px 20px;
        padding: 2em;
        width: 100%;
        box-shadow: 0 14px 28px -10px rgba(0, 0, 0, 0.1);
      }

      .mobile-card .content {
        padding: 0;
      }

      .mobile-card h1 {
        color: #0F2854;
        font-size: 2em;
        margin-bottom: 0.3em;
      }

      .mobile-card button[type="submit"] {
        width: 100% !important;
        padding: 12px 20px !important;
        font-size: 1.25em !important;
        margin: 12px auto 8px !important;
        box-sizing: border-box !important;
      }

      .mobile-toggle {
        text-align: center;
        margin-top: 1em;
        font-size: 1.1em;
        color: #666;
        padding-top: 1em;
        border-top: 1px solid #e0e0e0;
      }

      .mobile-toggle a {
        color: #3574b5;
        font-weight: bold;
        text-decoration: none;
        cursor: pointer;
      }

      .mobile-toggle a:hover {
        color: #0F2854;
      }

      .version {
        display: none;
      }
    }

    @media (min-width: 769px) {
      .mobile-container {
        display: none !important;
      }
    }
  </style>

  <body>
    <x-page-loader />

    <!-- Mobile-only container -->
    <div class="mobile-container">
      <div id="mobile-login">
        <div class="mobile-header">
          <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-in"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
          <h1>Welcome Back!</h1>
          <p>To keep connected with us please login with your personal info</p>
        </div>
        <div class="mobile-card">
          <div class="content">
            <h1>Log In</h1>
            <form action="{{ route('auth.login') }}" method="POST">
              @csrf
              <input type="text" name="email_or_npm" placeholder="Email atau NPM" value="{{ old('email_or_npm') }}">
              <div class="password-wrapper">
                <input type="password" name="password" placeholder="Password" style="width: 100%; padding-right: 50px;">
                <button type="button" class="password-toggle" onclick="togglePassword(this)">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="eye-icon">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                  </svg>
                </button>
              </div>

              <label class="remember-container">
                <input type="checkbox" name="remember" id="remember">
                <span class="remember-text">Remember me</span>
              </label>

              <span class="clearfix"></span>
              <button type="submit" onclick="return validateLogin()">Log In</button>

              <div class="divider-or">
                <span>atau</span>
              </div>
              <a href="{{ route('auth.google') }}" class="btn-google">
                <svg viewBox="0 0 24 24" width="18" height="18">
                  <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                  <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                  <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                  <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                </svg>
                <span>Masuk dengan Google</span>
              </a>

              <a href="{{url('/')}}" class="kembali">Kembali ke Dashboard</a>
            </form>

            <div class="mobile-toggle">
              <p>Belum punya akun? <a onclick="showMobileRegister()">Daftar</a></p>
            </div>
          </div>
        </div>
      </div>

      <div id="mobile-register" style="display: none;">
        <div class="mobile-header">
          <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
          <h1>Hello, friend!</h1>
          <p>Enter your personal details and start journey with us</p>
        </div>
        <div class="mobile-card">
          <div class="content">
            <h1>Sign Up</h1>
            <form action="{{ route('auth.register') }}" method="POST" onsubmit="return validateRegister(this)">
              @csrf
              <input type="text" name="npm" placeholder="NPM" value="{{ old('npm') }}" required>
              <input type="text" name="name" placeholder="Name" value="{{ old('name') }}" required>
              <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
              <div class="password-wrapper">
                <input type="password" name="password" placeholder="Password" style="width: 100%; padding-right: 50px;" required>
                <button type="button" class="password-toggle" onclick="togglePassword(this)">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="eye-icon">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                  </svg>
                </button>
              </div>
              <div class="password-wrapper">
                <input type="password" name="password_confirmation" placeholder="Confirm Password" style="width: 100%; padding-right: 50px;" required>
                <button type="button" class="password-toggle" onclick="togglePassword(this)">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="eye-icon">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                  </svg>
                </button>
              </div>

              <label class="remember-container">
                <input type="checkbox" name="terms" id="terms" required>
                <span class="remember-text">I accept terms</span>
              </label>

              <span class="clearfix"></span>
              <button type="submit">Register</button>

              <div class="divider-or">
                <span>atau</span>
              </div>
              <a href="{{ route('auth.google') }}" class="btn-google">
                <svg viewBox="0 0 24 24" width="18" height="18">
                  <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                  <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                  <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                  <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                </svg>
                <span>Daftar dengan Google</span>
              </a>
            </form>

            <div class="mobile-toggle">
              <p>Sudah punya akun? <a onclick="showMobileLogin()">Log In</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Desktop container with flip animation -->
    <div id="container">
      <div class="login">
        <div class="content">
          <h1>Log In</h1>
          <form action="{{ route('auth.login') }}" method="POST">
            @csrf
            <input type="text" name="email_or_npm" placeholder="Email atau NPM" value="{{ old('email_or_npm') }}">
            <div class="password-wrapper">
              <input type="password" name="password" placeholder="Password" style="width: 100%; padding-right: 50px;">
              <button type="button" class="password-toggle" onclick="togglePassword(this)">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="eye-icon">
                  <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                  <circle cx="12" cy="12" r="3"></circle>
                </svg>
              </button>
            </div>

            <label class="remember-container">
              <input type="checkbox" name="remember" id="remember">
              <span class="remember-text">Remember me</span>
            </label>

            <span class="clearfix"></span>

            <button type="submit" onclick="return validateLogin()">Log In</button>

            <div class="divider-or">
              <span>atau</span>
            </div>
            <a href="{{ route('auth.google') }}" class="btn-google">
              <svg viewBox="0 0 24 24" width="18" height="18">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
              </svg>
              <span>Masuk dengan Google</span>
            </a>

            <a href="{{url('/')}}" class="kembali">Kembali ke Dashboard</a>
          </form>
        </div>
      </div>
      <div class="page front">
        <div class="content">
          <svg xmlns="http://www.w3.org/2000/svg" width="96" height="96" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-in"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
          <h1>Welcome Back!</h1>
          <p>To keep connected with us please login with your personal info</p>
          <button type="button" id="register">Register <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right-circle"><circle cx="12" cy="12" r="10"/><polyline points="12 16 16 12 12 8"/><line x1="8" y1="12" x2="16" y2="12"/></svg></button>
        </div>
      </div>
      <div class="page back">
        <div class="content">
          <svg xmlns="http://www.w3.org/2000/svg" width="96" height="96" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
          <h1>Hello, friend!</h1>
          <p>Enter your personal details and start journey with us</p>
          <button type="button" id="login"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left-circle"><circle cx="12" cy="12" r="10"/><polyline points="12 8 8 12 12 16"/><line x1="16" y1="12" x2="8" y2="12"/></svg> Log In</button>
        </div>
      </div>
      <div class="register">
        <div class="content">
          <h1>Sign Up</h1>
          <form action="{{ route('auth.register') }}" method="POST" onsubmit="return validateRegister(this)">
            @csrf
            <input type="text" name="npm" placeholder="NPM" value="{{ old('npm') }}" required>
            <input type="text" name="name" placeholder="Name" value="{{ old('name') }}" required>
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
            <div class="password-wrapper">
              <input type="password" name="password" placeholder="Password" style="width: 100%; padding-right: 50px;" required>
              <button type="button" class="password-toggle" onclick="togglePassword(this)">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="eye-icon">
                  <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                  <circle cx="12" cy="12" r="3"></circle>
                </svg>
              </button>
            </div>
            <div class="password-wrapper">
              <input type="password" name="password_confirmation" placeholder="Confirm Password" style="width: 100%; padding-right: 50px;" required>
              <button type="button" class="password-toggle" onclick="togglePassword(this)">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="eye-icon">
                  <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                  <circle cx="12" cy="12" r="3"></circle>
                </svg>
              </button>
            </div>

            <label class="remember-container">
              <input type="checkbox" name="terms" id="terms" required>
              <span class="remember-text">I accept terms</span>
            </label>

            <span class="clearfix"></span>
            <button type="submit">Register</button>

            <div class="divider-or">
              <span>atau</span>
            </div>
            <a href="{{ route('auth.google') }}" class="btn-google">
              <svg viewBox="0 0 24 24" width="18" height="18">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
              </svg>
              <span>Daftar dengan Google</span>
            </a>
          </form>
        </div>
      </div>
    </div>

    <div id="popup-alert" class="popup-overlay" onclick="handleOverlayClick(event)">
      <div class="popup-box" onclick="event.stopPropagation()">
        <div id="popup-icon-wrapper" class="popup-icon-wrapper error">
          <i id="popup-icon" class="fas fa-exclamation-circle"></i>
        </div>
        <h2 id="popup-title">Error!</h2>
        <p id="popup-message">Email/NPM atau password salah.</p>
        <button id="popup-confirm-btn" onclick="closePopup()">OK</button>
      </div>
    </div>

  </body>
  <script>
    const registerButton = document.getElementById('register');
    const loginButton = document.getElementById('login');
    const container = document.getElementById('container');

    registerButton.onclick = function(){
      container.className = 'active';
    }
    loginButton.onclick = function(){
      container.className = 'close';
    }

    function showMobileRegister() {
      document.getElementById('mobile-login').style.display = 'none';
      document.getElementById('mobile-register').style.display = 'block';
      setTimeout(() => {
        attachNpmValidator();
        attachEmailValidator();
      }, 100);
    }

    function showMobileLogin() {
      document.getElementById('mobile-register').style.display = 'none';
      document.getElementById('mobile-login').style.display = 'block';
    }

    function showPopup(title, message, type) {
      const overlay = document.getElementById('popup-alert');
      const titleEl = document.getElementById('popup-title');
      const messageEl = document.getElementById('popup-message');
      const iconWrapper = document.getElementById('popup-icon-wrapper');
      const iconEl = document.getElementById('popup-icon');
      const btnEl = document.getElementById('popup-confirm-btn');

      if (!type) {
        const lowerTitle = (title || '').toLowerCase();
        if (lowerTitle.includes('berhasil') || lowerTitle.includes('sukses')) {
          type = 'success';
        } else if (lowerTitle.includes('informasi') || lowerTitle.includes('info')) {
          type = 'info';
        } else {
          type = 'error';
        }
      }

      titleEl.innerText = title;
      messageEl.innerText = message;

      if (type === 'success') {
        iconWrapper.className = 'popup-icon-wrapper success';
        iconEl.className = 'fas fa-check-circle';
      } else if (type === 'info') {
        iconWrapper.className = 'popup-icon-wrapper info';
        iconEl.className = 'fas fa-info-circle';
      } else {
        iconWrapper.className = 'popup-icon-wrapper error';
        iconEl.className = 'fas fa-exclamation-circle';
      }

      overlay.style.display = 'flex';
      requestAnimationFrame(() => {
        overlay.classList.add('active');
        if (btnEl) btnEl.focus();
      });
    }

    function resetSubmitButtons() {
      document.querySelectorAll('button[type="submit"]').forEach(btn => {
        btn.disabled = false;
        btn.style.opacity = '1';
        btn.style.pointerEvents = 'auto';
      });
    }

    function closePopup() {
      const overlay = document.getElementById('popup-alert');
      if (!overlay) return;
      overlay.classList.remove('active');
      setTimeout(() => {
        overlay.style.display = 'none';
        resetSubmitButtons();
      }, 250);
    }

    function handleOverlayClick(e) {
      if (e.target && e.target.id === 'popup-alert') {
        closePopup();
      }
    }

    document.addEventListener('keydown', function(e) {
      const overlay = document.getElementById('popup-alert');
      if (overlay && overlay.classList.contains('active')) {
        if (e.key === 'Escape' || e.key === 'Enter') {
          e.preventDefault();
          closePopup();
        }
      }
    });

    document.addEventListener('DOMContentLoaded', function() {
      @if(session('success'))
        showPopup('Berhasil!', '{{ session('success') }}', 'success');
      @endif

      @if(session('info'))
        showPopup('Informasi', '{{ session('info') }}', 'info');
      @endif

      @if(session('error'))
        showPopup('Error!', '{{ session('error') }}', 'error');
      @endif
    });

    function validateLogin(formEl) {
      if (!formEl) {
        formEl = event ? event.target.closest('form') : document.querySelector('#container .login form');
      }
      // Try current form first
      let email = formEl?.querySelector('input[name="email_or_npm"]')?.value?.trim();
      let password = formEl?.querySelector('input[name="password"]')?.value;
      
      // Fallback
      if (!email || !password) {
        email = document.querySelector('#container .login input[name="email_or_npm"]')?.value?.trim() ||
                document.querySelector('#mobile-login input[name="email_or_npm"]')?.value?.trim();
        password = document.querySelector('#container .login input[name="password"]')?.value ||
                   document.querySelector('#mobile-login input[name="password"]')?.value;
      }

      if (!email || !password) {
        resetSubmitButtons();
        showPopup(
          'Form belum lengkap',
          'Email/NPM dan password wajib diisi dulu ya.',
          'error'
        );
        return false;
      }
      return true;
    }

    function validateRegister(formEl) {
      if (!formEl) {
        const isMobile = window.innerWidth <= 768 || document.getElementById('mobile-register')?.style.display === 'block';
        formEl = isMobile ? document.querySelector('#mobile-register form') : document.querySelector('#container .register form');
      }

      let npm = formEl?.querySelector('input[name="npm"]')?.value?.trim();
      let name = formEl?.querySelector('input[name="name"]')?.value?.trim();
      let email = formEl?.querySelector('input[name="email"]')?.value?.trim();
      let password = formEl?.querySelector('input[name="password"]')?.value;
      let passwordConfirm = formEl?.querySelector('input[name="password_confirmation"]')?.value;
      let terms = formEl?.querySelector('input[name="terms"]')?.checked;
      
      // Fallback if formEl fields were empty
      if (!npm || !name || !email || !password || !passwordConfirm) {
        npm = npm || document.querySelector('#container .register input[name="npm"]')?.value?.trim() || document.querySelector('#mobile-register input[name="npm"]')?.value?.trim();
        name = name || document.querySelector('#container .register input[name="name"]')?.value?.trim() || document.querySelector('#mobile-register input[name="name"]')?.value?.trim();
        email = email || document.querySelector('#container .register input[name="email"]')?.value?.trim() || document.querySelector('#mobile-register input[name="email"]')?.value?.trim();
        password = password || document.querySelector('#container .register input[name="password"]')?.value || document.querySelector('#mobile-register input[name="password"]')?.value;
        passwordConfirm = passwordConfirm || document.querySelector('#container .register input[name="password_confirmation"]')?.value || document.querySelector('#mobile-register input[name="password_confirmation"]')?.value;
        terms = terms !== undefined ? terms : (document.querySelector('#container .register input[name="terms"]')?.checked || document.querySelector('#mobile-register input[name="terms"]')?.checked);
      }

      if (!npm || !name || !email || !password || !passwordConfirm) {
        resetSubmitButtons();
        showPopup(
          'Form belum lengkap',
          'Semua field wajib diisi terlebih dahulu.',
          'error'
        );
        return false;
      }

      if (password.length < 6) {
        resetSubmitButtons();
        showPopup(
          'Password terlalu pendek',
          'Password harus minimal 6 karakter.',
          'error'
        );
        return false;
      }

      if (password !== passwordConfirm) {
        resetSubmitButtons();
        showPopup(
          'Password tidak sesuai',
          'Password dan konfirmasi password tidak cocok.',
          'error'
        );
        return false;
      }

      if (!terms) {
        resetSubmitButtons();
        showPopup(
          'Terms tidak diterima',
          'Anda harus menerima terms dan conditions untuk mendaftar.',
          'error'
        );
        return false;
      }

      return true;
    }

    function togglePassword(button) {
      const passwordWrapper = button.closest('.password-wrapper');
      const passwordInput = passwordWrapper.querySelector('input[type="password"], input[type="text"]');
      const eyeIcon = button.querySelector('.eye-icon');
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        // Change icon to eye-off
        eyeIcon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
      } else {
        passwordInput.type = 'password';
        // Change icon back to eye
        eyeIcon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
      }
    }

    // Real-time validation for NPM availability
    function attachNpmValidator() {
      const npmInputs = document.querySelectorAll('input[name="npm"]');
      npmInputs.forEach(input => {
        input.addEventListener('blur', function() {
          if (this.value.trim()) {
            checkNpmAvailability(this.value);
          }
        });
      });
    }

    function checkNpmAvailability(npm) {
      fetch('{{ route("api.check-npm") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ npm: npm })
      })
      .then(response => response.json())
      .then(data => {
        if (!data.available) {
          showPopup('NPM Sudah Terdaftar', data.message);
        }
      })
      .catch(error => console.error('Error:', error));
    }

    // Real-time validation for Email availability
    function attachEmailValidator() {
      const emailInputs = document.querySelectorAll('input[name="email"]');
      emailInputs.forEach(input => {
        input.addEventListener('blur', function() {
          if (this.value.trim()) {
            checkEmailAvailability(this.value);
          }
        });
      });
    }

    function checkEmailAvailability(email) {
      fetch('{{ route("api.check-email") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ email: email })
      })
      .then(response => response.json())
      .then(data => {
        if (!data.available) {
          showPopup('Email Sudah Terdaftar', data.message);
        }
      })
      .catch(error => console.error('Error:', error));
    }

    // Initialize validators on page load
    document.addEventListener('DOMContentLoaded', function() {
      attachNpmValidator();
      attachEmailValidator();

      // Cegah double submission HANYA jika form valid dan tidak dibatalkan validator
      document.querySelectorAll('form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
          if (e.defaultPrevented) {
            resetSubmitButtons();
            return;
          }
          const btn = form.querySelector('button[type="submit"]');
          if (btn) {
            setTimeout(function() {
              if (!e.defaultPrevented) {
                btn.disabled = true;
                btn.style.opacity = '0.7';
              }
            }, 50);
          }
        });
      });

      // Kembalikan tombol ke kondisi aktif setiap kali ada perubahan pada input formulir
      document.querySelectorAll('input').forEach(function(input) {
        input.addEventListener('input', resetSubmitButtons);
        input.addEventListener('change', resetSubmitButtons);
      });
    });

    // Otomatis refresh jika halaman dibuka kembali dari background/cache HP (BFCache)
    // Hal ini memastikan CSRF Token selalu baru dan tidak memicu 419 Page Expired
    window.addEventListener('pageshow', function(event) {
      if (event.persisted) {
        window.location.reload();
      }
    });
  </script>
</html>
