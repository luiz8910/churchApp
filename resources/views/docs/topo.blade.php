

<!-- Collect the nav links, forms, and other content for toggling -->
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" >
    <ul class="nav navbar-nav">
        <li><a href="javascript:;"></a></li>

        <li class=""><a href="{{ route('docs.churchs') }}">Igrejas</a></li>

        <li>
            <a href="{{ route('docs.login') }}">Login </a>
        </li>
        <li>
            <a href="{{ route('docs.events') }}">Eventos</a>
        </li>

        <li>
            <a href={{ route('docs.groups') }}>Grupos</a>
</li>

<li>
    <a href="{{ route('docs.activity') }}">Atividades Recentes</a>
</li>

<li>
    <a href="{{ route('docs.people') }}">Pessoas e Visitantes</a>
</li>

<li>
    <a href="{{ route('docs.config') }}">Configurações</a>
</li>

<li>
    <a href="{{ route('docs.check-in') }}">Check-in</a>
</li>

<li>
    <div class="dropdown">
        <button class="btn btn-default custom-dropdown" type="button" id="dropdownMenu1"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            Recursos
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            <li>
                <a href="{{ route('docs.exhibitors') }}">Expositores</a>
            </li>
            <li>
                <a href="{{ route('docs.sponsors') }}">Patrocinadores</a>
            </li>
            <li>
                <a href="{{ route('docs.documents') }}">Documentos</a>
            </li>
            <li>
                <a href="{{ route('docs.polls') }}">Enquetes</a>
            </li>
        </ul>
    </div>

</li>


</ul>

</div><!-- /.navbar-collapse -->
