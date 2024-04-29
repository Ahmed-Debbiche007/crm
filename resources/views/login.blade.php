<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta19
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Syndic - Login</title>
    <!-- CSS files -->
    <link href="{{asset('dist/css/tabler.min.css?1684106062')}}" rel="stylesheet"/>
    <link href="{{asset('dist/css/tabler-flags.min.css?1684106062')}}" rel="stylesheet"/>
    <link href="{{asset('dist/css/tabler-payments.min.css?1684106062')}}" rel="stylesheet"/>
    <link href="{{asset('dist/css/tabler-vendors.min.css?1684106062')}}" rel="stylesheet"/>
    <link href="{{asset('dist/css/demo.min.css?1684106062')}}" rel="stylesheet"/>
    <link rel="icon" href="{{ asset('static/favicon.ico') }}" type="image/x-icon">
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
    @laravelPWA
  </head>
  <body  class=" d-flex flex-column">
    <script src="./dist/js/demo-theme.min.js?1684106062"></script>
    <div class="page page-center">
      <div class="container container-tight py-4">
        <div class="text-center mb-4">
          <div class="navbar-brand navbar-brand-autodark bg-white p-5 rounded">
          <img src="{{asset('static/logo.jpeg')}}" style="width: 200px" alt="">
          </div>
        </div>
        <div class="card card-md">
          <div class="card-body">
            <h2 class="h2 text-center mb-4">Se Connecter</h2>
            <form action="{{ route('login.perform') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" placeholder="Email" name="email">
              </div>
              <div class="mb-2">
                <label class="form-label">
                  Mot de passe
                </label>
                <div class="input-group input-group-flat">
                  <input type="password" id="pass" name="password" class="form-control"  placeholder="Mot de passe"  autocomplete="off">
                  <span class="input-group-text" id="show">
                    <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                    </a>
                  </span>
                </div>
              </div>
              
              <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100">Se connecter</button>
              </div>
            </form>
          </div>
          
        </div>
       
      </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="{{ asset('dist/js/jquery.min.js') }}"></script>
    <script src="{{asset('dist/js/tabler.min.js?1684106062')}}" defer></script>
    <script src="{{asset('dist/js/demo.min.js?1684106062')}}" defer></script>
    <script src="{{asset('dist/js/intDark.js')}}"></script>
    <script src="{{ asset('main.js') }}"></script>
  
  </body>
</html>
