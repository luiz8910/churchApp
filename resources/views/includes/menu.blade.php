
<div class="page-header-menu">
    <div class="container">
        <!-- BEGIN HEADER SEARCH BOX -->
        <form class="search-form" id="search-form" action="" method="GET" autocomplete="off">
            <div class="input-group">
                <input type="text" class="form-control" id="search-results" placeholder="Pesquise aqui" name="query">
                <span class="input-group-btn">
                    <a href="javascript:;" class="btn submit">
                        <i class="icon-magnifier"></i>
                    </a>
                </span>



            </div>

            <ul class="drop-pesquisar-ul search-form" id="results" style="display: none; position: absolute; z-index: 1000;">


            </ul>
            <!--<div class="top-menu">
                <ul class="nav navbar-nav ul-search">
                    <li class="dropdown dropdown-extended dropdown-notification dropdown-dark">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                           data-close-others="true">
                            <i class="fa fa-calendar font-white"></i>
                        </a>
                    </li>
                </ul>
            </div>-->

        </form>
        <!-- END HEADER SEARCH BOX -->
        <!-- BEGIN MEGA MENU -->
        <!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
        <!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
        <div class="hor-menu  ">
            <ul class="nav navbar-nav">



                <li class="menu-dropdown classic-menu-dropdown ">
                    <a href="{{ route('person.index') }}" class="nav-link  ">
                        <i class="fa fa-users"></i> Pessoas
                        <span class="badge badge-success">
                            @if(isset($countPerson)){{ $countPerson[0][0] }} @else 0 @endif
                        </span> <!-- Qtde de Adultos cadastrados -->
                    </a>

                </li>
                <li class="menu-dropdown mega-menu-dropdown  ">
                    <a href="{{ route('index') }}">
                        <i class="fa fa-calendar"></i>
                                Agendas e Eventos
                    </a>
                </li>
                <!--<li class="menu-dropdown classic-menu-dropdown ">
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
                </li>-->
                @if(!isset($leader) || !isset($admin)) <?php $leader = 1; $admin = 5;?> @endif
                @if(Auth::user()->person_id != null && (Auth::user()->person->role_id == $leader || Auth::user()->person->role_id == $admin))
                    <li class="menu-dropdown classic-menu-dropdown">
                        <a href="javascript:;">
                            <i class="fa fa-gears"></i>
                            Configurações
                        </a>
                        <ul class="dropdown-menu pull-left">
                            <li>
                                <a href="{{ route("config.index") }}">
                                    <i class="fa fa-wrench"></i>
                                    Permissões em Campos
                                    <span></span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:">
                                    <i class="fa fa-wrench font-red"></i>
                                    Permissões de Usuários (Em Breve)
                                    <span></span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('config.person.contacts.view') }}">
                                    <i class="fa fa-cloud-upload"></i>
                                    Importar/Exportar
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('feeds.index') }}">
                                    <i class="fa fa-rss"></i>
                                    Feeds
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('person.waitingApproval') }}">
                                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                                    Aguardando Aprovação
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if(Auth::user()->person_id != null && (Auth::user()->person->role_id == $leader
                || Auth::user()->person->role_id == $admin))
                    <li class="menu-dropdown mega-menu-dropdown">
                        <a href="{{ route("report.index") }}">
                            <i class="fa fa-bar-chart-o"></i>
                            Relatórios
                        </a>

                        <ul class="dropdown-menu pull-left">
                            <li>

                            </li>


                        </ul>
                    </li>
                @endif


                @if(Auth::user()->person_id != null && Auth::user()->person->role_id == $admin)

                    <li class="menu-dropdown mega-menu-dropdown">
                        <a href="javascript:;">
                            <i class="fa fa-file-text-o"></i>
                            Recursos
                        </a>

                        <ul class="dropdown-menu pull-left">
                            <li>
                                <a href="{{ route('exhibitors.index') }}">
                                    <i class="fa fa-eye"></i>
                                    Expositores
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('sponsors.index') }}">
                                    <i class="fa fa-money"></i>
                                    Patrocinadores
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('providers.index') }}">
                                    <i class="fa fa-institution"></i>
                                    Fornecedores
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('speakers.index') }}">
                                    <i class="fa fa-microphone"></i>
                                    Palestrantes
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('documents.index') }}">
                                    <i class="fa fa-files-o"></i>
                                    Documentos
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('polls.index') }}">
                                    <i class="fa fa-info-circle"></i>
                                    Enquetes
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-dropdown mega-menu-dropdown">
                        <a href="javascript:">
                            <i class="fa fa-credit-card"></i>
                            Pagamentos
                        </a>

                        <ul class="dropdown-menu pull-left">
                            <li >
                                <a href="{{ route('payment.index') }}" >
                                    <i class="fa fa-credit-card"></i>
                                    Pagamentos Efetuados
                                </a>
                            </li>

                            <li class="dropdown-submenu">
                                <a href="javascript:" class="nav-link nav-toggle">
                                    <i class="fa fa-lock"></i>
                                    Links

                                </a>
                                <ul class="dropdown-menu pull-left">
                                    <li>
                                        <a href="{{ route('new.url.payment') }}">
                                            <i class="fa fa-plus"></i>
                                            Novo link
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:">
                                            <i class="fa fa-lock"></i>
                                            Lista de Links
                                        </a>
                                    </li>

                                </ul>

                            </li>

                        </ul>


                    </li>

                @endif

            </ul>
        </div>
        <!-- END MEGA MENU -->
    </div>
</div>
