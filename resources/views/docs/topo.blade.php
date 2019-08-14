

<!-- Collect the nav links, forms, and other content for toggling -->
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" >
    <ul class="nav navbar-nav">
        <li><a href="javascript:;"></a></li>

        <li class=""><a href="{{ route('docs.churchs') }}">Organizações</a></li>

        <li>
            <a href="{{ route('docs.login') }}">Login </a>
        </li>
        <li>

            <button class="btn btn-default custom-dropdown" type="button" id="dropdownMenuEvents"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                Eventos
                <span class="caret"></span>
            </button>

            <ul class="dropdown-menu" aria-labelledby="dropdownMenuEvents">
                <li>
                    <a href="{{ route('docs.events') }}">Geral</a>
                </li>
                <li>
                    <a href="{{ route('docs.events.sessions') }}">Sessões</a>
                </li>
            </ul>
        </li>

<li>
    <a href="{{ route('docs.feeds') }}">Feeds</a>
</li>

<li>
    <a href="{{ route('docs.people') }}">Pessoas</a>
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
                <a href="{{ route('docs.speakers') }}">Palestrantes</a>
            </li>
            <li>
                <a href="{{ route('docs.providers') }}">Fornecedores</a>
            </li>

        </ul>
    </div>

</li>


</ul>

</div><!-- /.navbar-collapse -->
