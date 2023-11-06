<div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
    <div class="brand-logo">
        <a href="/">
            <img src="{{ asset('assets/images/logo.gif') }}" class="logo-icon" alt="logo icon">

        </a>
    </div>
    <ul class="sidebar-menu do-nicescrol">


        <li @if (Illuminate\Support\Str::startsWith(request()->path(), 'client')) active @endif>
            <a href="{{route('clients')}}">
                <i class="zmdi zmdi-male-female"></i> Clients <span></span>
            </a>
        </li>

        <li @if (Illuminate\Support\Str::startsWith(request()->path(), 'residence')) active @endif>
            <a href="{{route('residences')}}">
                <i class="zmdi zmdi-hospital-alt"></i> Résidences <span></span>
            </a>
        </li>

        <li @if (Illuminate\Support\Str::startsWith(request()->path(), 'etage')) active @endif>
            <a href="{{route('etages')}}">
                <i class="zmdi zmdi-layers"></i> Etages <span> </span>

            </a>
        </li>

        <li @if (Illuminate\Support\Str::startsWith(request()->path(), 'appar')) active @endif>
            <a href="{{route('apparts')}}">
                <i class="zmdi zmdi-home"></i> Appartements <span> </span>

            </a>
        </li>

        <li @if (Illuminate\Support\Str::startsWith(request()->path(), 'parking')) active @endif>
            <a href="{{route('parkings')}}">
                <i class="zmdi zmdi-parking"></i> Parkings <span></span>
            </a>
        </li>

        <li @if (Illuminate\Support\Str::startsWith(request()->path(), 'cellier')) active @endif>
            <a href="{{route('celliers')}}">
                <i class="zmdi zmdi-parking"></i> Celliers <span></span>
            </a>
        </li>

        <li @if (Illuminate\Support\Str::startsWith(request()->path(), 'echancier')) active @endif>
            <a href="{{route('echances')}}">
                <i class="zmdi zmdi-money"></i> Échanciers <span></span>
            </a>
        </li>


        <li @if (Illuminate\Support\Str::startsWith(request()->path(), 'charg')) active @endif>
            <a href="{{route('charges')}}">
                <i class="zmdi zmdi-money"></i> Charges <span></span>
            </a>
        </li>




    </ul>

</div>
