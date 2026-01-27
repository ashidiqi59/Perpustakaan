<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Perpustakaan</title>
  <link rel="stylesheet" href="https://public.codepenassets.com/css/normalize-5.0.0.min.css">
  <style>
    @import url("https://fonts.googleapis.com/css?family=Montserrat:400,700");

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

    h1 {
      font-weight: 700;
      font-size: 3.5em;
      text-align: center;
    }

    .version {
      position: absolute;
      bottom: 1em;
      right: 2em;
      border-radius: 40px;
      background: #ff4b2b;
      color: #fff;
      font-size: 1em;
      font-weight: bold;
      padding: 0.8em 2em;
      letter-spacing: 1px;
      transition: transform 80ms ease-in;
    }

    form input {
      background: #eee;
      border: none;
      padding: 12px 15px;
      margin: 8px 0;
      width: 100%;
      font-size: 1.4em;
    }

    span {
      color: #333;
      font-size: 1.4em;
      display: inline-block;
      margin: 15px auto;
      font-weight: 100;
    }

    .remember-container {
      float: left;
      display: flex;
      align-items: center;
      cursor: pointer;
    }

    .remember-container input[type="checkbox"] {
      width: 1.2em;
      height: 1.2em;
      margin-right: 8px;
      cursor: pointer;
    }

    span.remember-text {
      margin: 0;
      font-size: 1.2em;
    }

    span.forget {
      float: right;
    }

    span.clearfix {
      clear: both;
      display: table;
    }

    span.loginwith {
      display: block;
      width: 100%;
      margin-top: 1em;
      white-space: nowrap;
      overflow: hidden;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    span.loginwith::before {
      content: "";
      display: inline-block;
      width: 42%;
      height: 1px;
      background: #aaa;
      vertical-align: middle;
      margin-right: 5%;
    }

    span.loginwith::after {
      content: "";
      display: inline-block;
      width: 45%;
      height: 1px;
      background: #aaa;
      vertical-align: middle;
      margin-left: 5%;
    }

    span.copy {
      display: block;
      position: absolute;
      bottom: 0;
      font-size: 1em;
    }

    button {
      display: block;
      margin: 1em auto;
      border-radius: 40px;
      border: 1px solid black;
      background: linear-gradient(-45deg, #0F2854 30%, #4988C4 100%) no-repeat 0 0/200%;
      color: #fff;
      font-size: 1.2em;
      font-weight: bold;
      padding: 0.8em 2em;
      letter-spacing: 1px;
      text-transform: uppercase;
      transition: transform 80ms ease-in;
    }

    button svg {
      vertical-align: middle;
    }

    button:hover {
      cursor: pointer;
    }

    button:active {
      transform: scale(0.95);
    }

    button:focus {
      outline: none;
    }

    #container {
      width: 95%;
      max-width: 800px;
      height: 500px;
      position: relative;
      border-radius: 20px;
      box-shadow: 0 14px 28px -10px rgba(0, 0, 0, 0.1), 0 10px 10px -10px rgba(0, 0, 0, 0.02);
      transform-style: preserve-3d;
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
      padding: 2em 4em;
      text-align: center;
    }

    .content p {
      font-size: 1.4em;
    }

    .login {
      left: 0;
      background: #FAFAFA;
      border-radius: 20px 0 0 20px;
    }

    .login button {
      border-radius: 0px;
      width: 100%;
    }

    .login svg {
      margin: 1em;
      stroke: #999;
    }

    .register {
      right: 0;
      z-index: 1;
      border-radius: 0 20px 20px 0;
      background: #FAFAFA;
    }

    .register button {
      border-radius: 0px;
      width: 100%;
    }

    .register svg {
      margin: 1em;
      stroke: #999;
    }

    .page {
      right: 0;
      color: #fff;
      border-radius: 0 20px 20px 0;
      transform-origin: left center;
      transition: -webkit-animation 1s linear;
      transition: animation 1s linear;
      transition: animation 1s linear, -webkit-animation 1s linear;
    }

    .page button {
      border-color: #fff;
      background: transparent;
    }

    .page p {
      margin: 2em auto;
    }

    .front {
      background: linear-gradient(-45deg, #0F2854 30%, #4988C4 100%) no-repeat 0 0/200%;
      z-index: 3;
    }

    .back {
      background: linear-gradient(135deg, #4988C4 0%, #0F2854 100%) no-repeat 0 0/200%;
      z-index: 2;
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
        opacity: 0;
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

    .kembali {
      display: block;
      margin-top: 1em;
      font-size: 1.2em;
    }
    .popup-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(15, 40, 84, 0.6);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 9999;
    }

    .popup-box {
      background: #fff;
      padding: 2.5em;
      border-radius: 20px;
      width: 90%;
      max-width: 400px;
      text-align: center;
      box-shadow: 0 20px 40px rgba(0,0,0,0.2);
      animation: popupScale 0.3s ease;
    }

    .popup-box h2 {
      font-size: 2.2em;
      color: #0F2854;
      margin-bottom: 0.5em;
    }

    .popup-box p {
      font-size: 1.4em;
      color: #333;
      margin-bottom: 1.5em;
    }

    .popup-box button {
      border-radius: 30px;
      padding: 0.7em 2em;
      background: linear-gradient(-45deg, #0F2854, #4988C4);
      border: none;
      color: white;
      font-weight: bold;
    }

    @keyframes popupScale {
      from {
        transform: scale(0.8);
        opacity: 0;
      }
      to {
        transform: scale(1);
        opacity: 1;
      }
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
        background: linear-gradient(-45deg, #0F2854 0%, #1a3a6e 50%, #4988C4 100%);
      }

      h1 {
        font-size: 2.2em;
        color: #0F2854;
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
        background: linear-gradient(-45deg, #0F2854 30%, #4988C4 100%);
        border-radius: 24px 24px 0 0;
        padding: 2.5em 2em;
        text-align: center;
        color: #fff;
      }

      .mobile-header svg {
        width: 64px;
        height: 64px;
        stroke: #fff;
        margin-bottom: 1em;
      }

      .mobile-header h1 {
        color: #fff;
        font-size: 1.8em;
        margin-bottom: 0.3em;
      }

      .mobile-header p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.1em;
        margin: 0;
      }

      /* Mobile card style - matching desktop form panel style */
      .mobile-card {
        background: #FAFAFA;
        border-radius: 0 0 24px 24px;
        padding: 2em;
        width: 100%;
        box-shadow: 0 20px 60px -15px rgba(15, 40, 84, 0.35);
      }

      .mobile-card .content {
        padding: 0;
      }

      .mobile-card h1 {
        color: #0F2854;
        font-size: 1.8em;
        margin-bottom: 0.3em;
      }

      form input {
        font-size: 1.1em;
        padding: 12px 15px;
        border-radius: 10px;
        background: #fff;
        border: 2px solid #e0e0e0;
        transition: all 0.3s ease;
      }

      form input:focus {
        outline: none;
        border-color: #4988C4;
        box-shadow: 0 0 0 3px rgba(73, 136, 196, 0.2);
      }

      button {
        font-size: 1.2em;
        padding: 0.7em 2em;
        border-radius: 30px;
        width: 100%;
        margin-top: 0.5em;
        margin-bottom: 0.5em;
        background: linear-gradient(-45deg, #0F2854, #4988C4);
        border: none;
        box-shadow: 0 4px 15px rgba(15, 40, 84, 0.3);
      }

      button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(15, 40, 84, 0.4);
      }

      .remember-container {
        float: none;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        margin: 0;
        padding-left: 0;
      }

      span.clearfix {
        display: none;
      }

      .mobile-toggle {
        text-align: center;
        margin-top: 1em;
        font-size: 1em;
        color: #666;
        padding-top: 1em;
        border-top: 1px solid #e0e0e0;
      }

      .mobile-toggle a {
        color: #4988C4;
        font-weight: bold;
        text-decoration: none;
        cursor: pointer;
        transition: color 0.3s ease;
      }

      .mobile-toggle a:hover {
        color: #0F2854;
      }

      .version {
        display: none;
      }

      .kembali {
        display: block;
        text-align: center;
        margin-top: 1.2em;
        font-size: 1.3em;
        color: #0F2854;
        text-decoration: none;
        transition: color 0.3s ease;
      }

      .kembali:hover {
        color: #4988C4;
      }
    }

    /* Show mobile forms only on mobile */
    @media (min-width: 769px) {
      .mobile-container {
        display: none !important;
      }
    }
  </style>

  <body>

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
              <input type="password" name="password" placeholder="Password">

              <label class="remember-container">
                <input type="checkbox" name="remember" id="remember">
                <span class="remember-text">Remember me</span>
              </label>

              <span class="clearfix"></span>
              <button type="submit" onclick="return validateLogin()">Log In</button>

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
            <form action="{{ route('auth.register') }}" method="POST" onsubmit="return validateRegister()">
              @csrf
              <input type="text" name="npm" placeholder="NPM" value="{{ old('npm') }}" required>
              <input type="text" name="name" placeholder="Name" value="{{ old('name') }}" required>
              <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
              <input type="password" name="password" placeholder="Password" required>
              <input type="password" name="password_confirmation" placeholder="Confirm Password" required>

              <label class="remember-container">
                <input type="checkbox" name="terms" id="terms" required>
                <span class="remember-text">I accept terms</span>
              </label>

              <span class="clearfix"></span>
              <button type="submit">Register</button>
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
            <input type="password" name="password" placeholder="Password">

            <label class="remember-container">
              <input type="checkbox" name="remember" id="remember">
              <span class="remember-text">Remember me</span>
            </label>

            <span class="clearfix"></span>

            <button type="submit" onclick="return validateLogin()">Log In</button>

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
          <form action="{{ route('auth.register') }}" method="POST" onsubmit="return validateRegister()">
            @csrf
            <input type="text" name="npm" placeholder="NPM" value="{{ old('npm') }}" required>
            <input type="text" name="name" placeholder="Name" value="{{ old('name') }}" required>
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>

            <label class="remember-container">
              <input type="checkbox" name="terms" id="terms" required>
              <span class="remember-text">I accept terms</span>
            </label>

            <span class="clearfix"></span>
            <button type="submit">Register</button>
          </form>
        </div>
      </div>
    </div>

    <div id="popup-alert" class="popup-overlay">
      <div class="popup-box">
        <h2 id="popup-title">Oops!</h2>
        <p id="popup-message">Pesan error di sini</p>
        <button onclick="closePopup()">OK</button>
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
    }

    function showMobileLogin() {
      document.getElementById('mobile-register').style.display = 'none';
      document.getElementById('mobile-login').style.display = 'block';
    }

    function showPopup(title, message) {
      document.getElementById('popup-title').innerText = title;
      document.getElementById('popup-message').innerText = message;
      document.getElementById('popup-alert').style.display = 'flex';
    }

    function closePopup() {
      document.getElementById('popup-alert').style.display = 'none';
    }

    document.addEventListener('DOMContentLoaded', function() {
      @if(session('success'))
        showPopup('Berhasil!', '{{ session('success') }}');
      @endif

      @if(session('error'))
        showPopup('Error!', '{{ session('error') }}');
      @endif
    });

    function validateLogin() {
      const email = document.querySelector('input[name="email_or_npm"]').value;
      const password = document.querySelector('input[name="password"]').value;

      if (!email || !password) {
        showPopup(
          'Form belum lengkap',
          'Email/NPM dan password wajib diisi dulu ya.'
        );
        return false;
      }
      return true;
    }

    function validateRegister() {
      const npm = document.querySelector('.register input[name="npm"]').value;
      const name = document.querySelector('.register input[name="name"]').value;
      const email = document.querySelector('.register input[name="email"]').value;
      const password = document.querySelector('.register input[name="password"]').value;
      const passwordConfirm = document.querySelector('.register input[name="password_confirmation"]').value;
      const terms = document.querySelector('.register input[name="terms"]').checked;

      if (!npm || !name || !email || !password || !passwordConfirm) {
        showPopup(
          'Form belum lengkap',
          'Semua field wajib diisi terlebih dahulu.'
        );
        return false;
      }

      if (password.length < 6) {
        showPopup(
          'Password terlalu pendek',
          'Password harus minimal 6 karakter.'
        );
        return false;
      }

      if (password !== passwordConfirm) {
        showPopup(
          'Password tidak sesuai',
          'Password dan konfirmasi password tidak cocok.'
        );
        return false;
      }

      if (!terms) {
        showPopup(
          'Terms tidak diterima',
          'Anda harus menerima terms dan conditions untuk mendaftar.'
        );
        return false;
      }

      return true;
    }
  </script>
</html>
