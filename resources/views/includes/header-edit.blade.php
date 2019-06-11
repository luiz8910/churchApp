<?php $visitor = 3; ?>
<input type="hidden" id="UserRole" value="@if(isset(Auth::user()->person)){{ Auth::user()->person->role_id }} @else {{ $visitor }} @endif">
<!-- BEGIN HEADER -->
<div class="page-header">
    <!-- BEGIN HEADER TOP -->
    <div class="page-header-top">
        <div class="container">
            <!-- BEGIN LOGO -->
            <div class="page-logo">
                <a href="@if(Auth::user()->church_id)
                            {{ route('index') }}
                        @else {{ route('home.visitor', ['church_id' => $church_id])}} @endif">
                    <img src="../../teste/logo-menor-header.png" alt="logo" class="logo-default" style="width: 270px; margin-top: 7px;">
                    {{--<img src="../../logo/Vertical.png" alt="logo" class="logo-default" style="width: 300px; margin-top: -20px;">--}}
                </a>
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

                    <!-- END TODO DROPDOWN -->
                    <li class="droddown dropdown-separator">
                        <span class="separator"></span>
                    </li>
                    <!-- BEGIN INBOX DROPDOWN -->

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
                                    $img = "../../" . Auth::user()->person->imgProfile;
                                }
                            }else{
                                $name = Auth::user()->visitors->first()->name;

                                if(Auth::user()->first()->facebook_id || Auth::user()->first()->google_id)
                                {
                                    $img = Auth::user()->visitors->first()->imgProfile;
                                }
                                else{
                                    $img = "../../" . Auth::user()->visitors->first()->imgProfile;
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
