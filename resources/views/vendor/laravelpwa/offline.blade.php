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
    <title>CRM - Hors Ligne</title>
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
          <img src="{{asset('static/logo.gif')}}" style="width: 200px" alt="">
          </div>
        </div>
        <div class="card card-md">
          <div class="card-body">
            <h2 class="h2 text-center mb-4">Vous êtes hors ligne</h2>
            <button onclick="reload()" class="btn btn-primary w-100">Rafraichir</button>
          </div>
          
        </div>
       
      </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="{{asset('dist/js/tabler.min.js?1684106062')}}" defer></script>
    <script src="{{asset('dist/js/demo.min.js?1684106062')}}" defer></script>
    <script src="{{asset('dist/js/intDark.js')}}"></script>
    <script>
        function reload(){
            window.location.href = "/";
        }
    </script>
  
  </body>
</html>