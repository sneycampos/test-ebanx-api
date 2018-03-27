<ul class="nav nav-pills">
    <li class="nav-item dropdown mr-3">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" >Movimentação</a>
        <div class="dropdown-menu m-0 p-0">
            <a class="dropdown-item" href="{{route('movements.create')}}">Cadastrar</a>
            <a class="dropdown-item" href="{{route('reports.index')}}">Relatórios</a>
        </div>
    </li>
    <li class="nav-item dropdown mr-3">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Cadastros</a>
        <div class="dropdown-menu m-0 p-0">
            <a class="dropdown-item" href="{{route('plans.index')}}">Convênios</a>
            <a class="dropdown-item" href="{{route('hospitals.index')}}">Hospitais</a>
            <a class="dropdown-item" href="{{route('roles.index')}}">Posições</a>
        </div>
    </li>
    <li class="nav-item dropdown ml-auto">
        <a href="#" class=" no-border nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            {{ Auth::user()->name }} <span class="caret"></span>
        </a>

        <div class="dropdown-menu m-0 p-0">
            <a class="dropdown-item" href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>

        </div>
    </li>
    <li>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </li>
</ul>