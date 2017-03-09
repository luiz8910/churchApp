
<div class="page-header-menu">
    <div class="container">
        <!-- BEGIN HEADER SEARCH BOX -->
        <form class="search-form" action="page_general_search.html" method="GET">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Pesquisar" name="query">
                <span class="input-group-btn">
                                <a href="javascript:;" class="btn submit">
                                    <i class="icon-magnifier"></i>
                                </a>
                            </span>
            </div>
        </form>
        <!-- END HEADER SEARCH BOX -->
        <!-- BEGIN MEGA MENU -->
        <!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
        <!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
        <div class="hor-menu  ">
            <ul class="nav navbar-nav">
                <li class="menu-dropdown classic-menu-dropdown ">
                    <a href="javascript:;"> Pessoas
                        <span class="arrow"></span>
                    </a>
                    <ul class="dropdown-menu pull-left">
                        <li class=" ">
                            <a href="{{ route('person.index') }}" class="nav-link  ">
                                <i class="icon-bar-chart"></i> Adultos
                                <span class="badge badge-success">
                                    {{ $countPerson[0][0] }}
                                </span> <!-- Qtde de Adultos cadastrados -->
                            </a>
                        </li>
                        <li class=" ">
                            <a href="{{ route('person.teen') }}" class="nav-link  ">
                                <i class="icon-bulb"></i> Jovens e Crianças
                                <span class="badge badge-success">{{ $countPerson[0][1] }}</span></a> <!-- Qtde de Crianças/Jovens cad.-->
                        </li>
                        <li class=" ">
                            <a href="{{ route('person.visitors') }}" class="nav-link  ">
                                <i class="icon-bulb"></i> Visitantes
                                <span class="badge badge-success">{{ $countPerson[0][2] }}</span></a> <!-- Qtde de Visitantes cad.-->
                        </li>
                        <li class=" ">
                            <a href="{{ route('person.inactive') }}" class="nav-link  ">
                                <i class="icon-bulb"></i> Inativos
                                <span class="badge badge-success">{{ $countPerson[0][3] }}</span></a> <!-- Qtde de Inativos cad.-->
                        </li>
                    </ul>
                </li>
                <li class="menu-dropdown classic-menu-dropdown ">
                    <a href="javascript:;"> Grupos
                    </a>
                    <ul class="dropdown-menu pull-left">
                        <li>
                            <a href="{{ route('group.index') }}" class="nav-link">
                                <i class="icon-user"></i> Todos
                                <span class="badge badge-success">{{ $countGroups[0][0] }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('group.index') }}" class="nav-link">
                                <i class="icon-user"></i> Ativos
                                <span class="badge badge-success">{{ $countGroups[0][1] }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('group.index') }}" class="nav-link">
                                <i class="icon-user"></i> Inativos
                                <span class="badge badge-success">{{ $countGroups[0][2] }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-dropdown mega-menu-dropdown  ">
                    <a href="{{ route('event.index') }}"> Agendas e Eventos
                    </a>
                </li>
                <li class="menu-dropdown classic-menu-dropdown ">
                    <a href="javascript:;"> Doações
                    </a>
                </li>
                <li class="menu-dropdown mega-menu-dropdown  mega-menu-full">
                    <a href="javascript:;"> Serviços
                    </a>
                </li>
                <li class="menu-dropdown classic-menu-dropdown ">
                    <a href="javascript:;"> Relatórios
                    </a>
                </li>
                <li class="menu-dropdown classic-menu-dropdown ">
                    <a href="javascript:;"> Configurações
                    </a>
                </li>
            </ul>
        </div>
        <!-- END MEGA MENU -->
    </div>
</div>