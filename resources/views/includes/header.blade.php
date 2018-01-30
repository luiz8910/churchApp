<?php $visitor = 3; ?>
<input type="hidden" id="UserRole" value="@if(isset(Auth::user()->person)){{ Auth::user()->person->role_id }} @else {{ $visitor }} @endif ">
<!-- BEGIN HEADER -->
<div class="page-header">
    <!-- BEGIN HEADER TOP -->
    <div class="page-header-top" >
        <div class="container">
            <!-- BEGIN LOGO -->
            <div class="page-logo" >


                <div >
                    <a href="
                        @if(Auth::user()->church_id)
                            {{ route('index') }}
                        @endif">

                    <img src="../logo/Simbolo.png" alt="logo" class="logo-default hidden-md hidden-lg" style="width: 100%; margin-top: 2px; display: none;">

                    <img src="../teste/logo-menor-header.png" alt="logo" class="logo-default " style="width: 270px; margin-top: 7px;">

                    </a>
                </div>


                    <!--<img src="../logo/Horizontal.png" alt="logo" class="logo-default" style="width: 270px; margin-top: -15px;">-->
                    {{--<img src="../logo/Vertical.png" alt="logo" class="logo-default" style="width: 300px; margin-top: -20px;">--}}

            </div>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="menu-toggler"></a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <!-- BEGIN NOTIFICATION DROPDOWN -->
                    @include('includes.notifications')
                    <!-- END NOTIFICATION DROPDOWN -->
                    <!-- BEGIN TODO DROPDOWN -->
                    <li class="dropdown dropdown-extended dropdown-tasks dropdown-dark" id="header_task_bar">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                           data-close-others="true">
                            <i class="icon-calendar"></i>
                            <span class="badge badge-default">3</span>
                        </a>
                        <ul class="dropdown-menu extended tasks">
                            <li class="external">
                                <h3>Sem Notificações</h3>
                                <!--<a href="app_todo_2.html">view all</a>-->
                            </li>
                            <li>
                                <ul class="dropdown-menu-list scroller" style="height: 275px;"
                                    data-handle-color="#637283">
                                    <li>
                                        <a href="javascript:;">
                                                    <span class="task">
                                                        <span class="desc">New release v1.2 </span>
                                                        <span class="percent">30%</span>
                                                    </span>
                                                    <span class="progress">
                                                        <span style="width: 40%;"
                                                              class="progress-bar progress-bar-success"
                                                              aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">40% Complete</span>
                                                        </span>
                                                    </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                                    <span class="task">
                                                        <span class="desc">Application deployment</span>
                                                        <span class="percent">65%</span>
                                                    </span>
                                                    <span class="progress">
                                                        <span style="width: 65%;"
                                                              class="progress-bar progress-bar-danger"
                                                              aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">65% Complete</span>
                                                        </span>
                                                    </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                                    <span class="task">
                                                        <span class="desc">Mobile app release</span>
                                                        <span class="percent">98%</span>
                                                    </span>
                                                    <span class="progress">
                                                        <span style="width: 98%;"
                                                              class="progress-bar progress-bar-success"
                                                              aria-valuenow="98" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">98% Complete</span>
                                                        </span>
                                                    </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                                    <span class="task">
                                                        <span class="desc">Database migration</span>
                                                        <span class="percent">10%</span>
                                                    </span>
                                                    <span class="progress">
                                                        <span style="width: 10%;"
                                                              class="progress-bar progress-bar-warning"
                                                              aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">10% Complete</span>
                                                        </span>
                                                    </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                                    <span class="task">
                                                        <span class="desc">Web server upgrade</span>
                                                        <span class="percent">58%</span>
                                                    </span>
                                                    <span class="progress">
                                                        <span style="width: 58%;" class="progress-bar progress-bar-info"
                                                              aria-valuenow="58" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">58% Complete</span>
                                                        </span>
                                                    </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                                    <span class="task">
                                                        <span class="desc">Mobile development</span>
                                                        <span class="percent">85%</span>
                                                    </span>
                                                    <span class="progress">
                                                        <span style="width: 85%;"
                                                              class="progress-bar progress-bar-success"
                                                              aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">85% Complete</span>
                                                        </span>
                                                    </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                                    <span class="task">
                                                        <span class="desc">New UI release</span>
                                                        <span class="percent">38%</span>
                                                    </span>
                                                    <span class="progress progress-striped">
                                                        <span style="width: 38%;"
                                                              class="progress-bar progress-bar-important"
                                                              aria-valuenow="18" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">38% Complete</span>
                                                        </span>
                                                    </span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <!-- END TODO DROPDOWN -->
                    <li class="droddown dropdown-separator">
                        <span class="separator"></span>
                    </li>
                    <!-- BEGIN INBOX DROPDOWN -->
                    <li class="dropdown dropdown-extended dropdown-inbox dropdown-dark" id="header_inbox_bar">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                           data-close-others="true">
                            <span class="circle">3</span>
                            <span class="corner"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="external">
                                <h3>Você tem
                                    <strong>3 Novas</strong> Mensagens</h3>
                                <a href="app_inbox.html">ver todas</a>
                            </li>
                            <li>
                                <ul class="dropdown-menu-list scroller" style="height: 275px;"
                                    data-handle-color="#637283">
                                    <li>
                                        <a href="#">
                                                    <span class="photo">
                                                        <img src="../assets/layouts/layout3/img/avatar2.jpg"
                                                             class="img-circle" alt=""> </span>
                                                    <span class="subject">
                                                        <span class="from"> Ana Julia </span>
                                                        <span class="time">Agora </span>
                                                    </span>
                                            <span class="message"> Por favor atualize seus dados cadastrais </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                                    <span class="photo">
                                                        <img src="../assets/layouts/layout3/img/avatar3.jpg"
                                                             class="img-circle" alt=""> </span>
                                                    <span class="subject">
                                                        <span class="from"> Ricardo Fiorentino </span>
                                                        <span class="time">16 mins </span>
                                                    </span>
                                            <span class="message"> Lista de membros confirmados </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                                    <span class="photo">
                                                        <img src="../assets/layouts/layout3/img/avatar1.jpg"
                                                             class="img-circle" alt=""> </span>
                                                    <span class="subject">
                                                        <span class="from"> Ferdinando Milani </span>
                                                        <span class="time">2 hrs </span>
                                                    </span>
                                            <span class="message"> Evento da mocidade em... </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                                    <span class="photo">
                                                        <img src="../assets/layouts/layout3/img/avatar6.jpg"
                                                             class="img-circle" alt=""> </span>
                                                    <span class="subject">
                                                        <span class="from"> Gabrielle Benítez Aguilar </span>
                                                        <span class="time">2 dias </span>
                                                    </span>
                                            <span class="message"> Nova atualização </span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <!-- END INBOX DROPDOWN -->
                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <li class="dropdown dropdown-user dropdown-dark">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                           data-close-others="true">
                            <?php

                            $img = '';

                                if(isset(Auth::user()->person))
                                {
                                    $name = Auth::user()->person->name;

                                    if(Auth::user()->facebook_id || Auth::user()->google_id)
                                    {
                                        $img = Auth::user()->person->imgProfile;
                                    }
                                    else{
                                        $img = "../" . Auth::user()->person->imgProfile;
                                    }
                                }else{
                                    $name = Auth::user()->visitors->first()->name;

                                    if(Auth::user()->first()->facebook_id || Auth::user()->first()->google_id)
                                    {
                                        $img = Auth::user()->visitors->first()->imgProfile;
                                    }
                                    else{
                                        $img = "../" . Auth::user()->visitors->first()->imgProfile;
                                    }
                                }

                                 ?>

                            <img alt="" class="img-circle" src="{{ $img }}">
                            <span class="username username-hide-mobile">{{ $name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a href="{{ route('users.myAccount') }}">
                                    <i class="icon-user"></i> Minha conta </a>
                            </li>
                            <li>
                                <a href="{{ route('event.index') }}">
                                    <i class="icon-calendar"></i> Eventos </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="{{ url('/logout') }}"
                                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    <i class="icon-key"></i> Sair
                                </a>

                                <form id="logout-form" action="{{ url('/logout') }}" method="POST">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                    <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                    {{--<li class="dropdown dropdown-extended quick-sidebar-toggler">
                        <span class="sr-only">Toggle Quick Sidebar</span>
                        <i class="icon-logout"></i>
                    </li>--}}
                    <!-- END QUICK SIDEBAR TOGGLER -->
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
    </div>
    <!-- END HEADER TOP -->
    <!-- BEGIN HEADER MENU -->
    @include('includes.menu')
    <!-- END HEADER MENU -->
</div>
<!-- END HEADER -->
