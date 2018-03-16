
<div class="page-header-menu">
    <div class="container">
        <!-- BEGIN HEADER SEARCH BOX -->
        <form class="search-form" action="" method="GET" autocomplete="off">
            <div class="input-group">
                <input type="text" class="form-control" id="search-results" placeholder="Pesquisar" name="query">
                <span class="input-group-btn">
                    <a href="javascript:;" class="btn submit">
                        <i class="icon-magnifier"></i>
                    </a>
                </span>



            </div>

            <ul class="drop-pesquisar-ul" id="results" style="display: none;">

                <!--<li class="">
                    <a href="#" class="drop-pesquisar-a">
                        <img src="../teste/avatar9.jpg" alt="" class="img-rounded drop-pesquisar-img">
                        Grupo de Jovens

                    </a>
                </li>-->

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

                    <li class="menu-dropdown mega-menu-dropdown  ">
                        <a href="javascript:;">
                            Início
                        </a>
                    </li>

                <li class="menu-dropdown classic-menu-dropdown ">
                    <a href="javascript:;"> Pessoas
                        <span class="arrow"></span>
                    </a>

                </li>
                <li class="menu-dropdown classic-menu-dropdown ">
                    <a href="javascript:;"> Grupos
                    </a>
                </li>
                <li class="menu-dropdown mega-menu-dropdown  ">
                    <a href="{{ route('event.index') }}"> Agendas e Eventos
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

                    <li class="menu-dropdown classic-menu-dropdown">
                        <a href="javascript:;">Configurações</a>

                    </li>


                    <li class="menu-dropdown mega-menu-dropdown">
                        <a href="javascript:;">
                            Relatórios
                        </a>

                    </li>

            </ul>
        </div>
        <!-- END MEGA MENU -->
    </div>
</div>