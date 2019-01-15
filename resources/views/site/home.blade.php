@include('includes.header-site')
<div class="container-fluid fixed-top" id="navbar">
    <nav class="navbar container navbar-toggleable-md navbar-light bg-transparent">
        <button class="navbar-toggler navbar-toggler-right border-0" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Alternar Navegação">
            <i class="fas fa-bars color-white transparent"></i>
            <i class="fas fa-bars color-grape solid"></i>
        </button>
        <a class="navbar-brand transparent" href="#"><img src="/store/images/logo-branco.png" srcset="/store/images/logo-branco@2x.png 2x, /store/images/logo-branco@3x.png 3x" class="logo"></a>
        <a class="navbar-brand solid" href="#"><img src="/store/images/logo.png" srcset="/store/images/logo@2x.png 2x, /store/images/logo@3x.png 3x" class="logo"></a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <button class="navbar-toggler navbar-toggler-right border-0 z-index-important" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Alternar Navegação">
                <i class="fas fa-times fa-2x color-white"></i>
            </button>
            <div class="navbar-content d-block d-sm-flex w-100 justify-content-around align-items-sm-center">
                <ul class="navbar-nav d-flex w-100 justify-content-around align-items-sm-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#o-que-fazemos">Sobre</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#container-carousel-app">Características</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#como-funciona">Como funciona</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pricings">Planos</a>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    {{--<a class="btn btn-primary my-2 my-sm-0" href="app.php?page=login_trial">Login</a>--}}
                    <a class="btn btn-primary my-2 my-sm-0" href="{{ url('/login') }}">Login</a>
                </form>
            </div>
        </div>
    </nav>
</div>

<div class="container-fluid" id="header">
    <div class="container">
        <h1 class="my-0">{{ $main->text_1 }}</h1>

        <h3 class="py-5 mb-3">{{ $main->text_2 }}</h3>

        <a href="#pricings" smooth-scroll="true" class="btn btn-primary">Faça um teste grátis</a>
    </div>

    <a href="#o-que-fazemos" smooth-scroll="true"><img src="/store/images/ic-descer.png" srcset="/store/images/ic-descer@2x.png 2x, /store/images/ic-descer@3x.png 3x" class="ic_descer"></a>
</div>

<div class="container-fluid px-xs-0" id="o-que-fazemos">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 pt-10 xs-bg-white-lilac pb-5 pb-sm-0">
                <div class="row">
                    <div class="col">
                        <h6 class="text-uppercase">{{ $about->text_1 }}</h6>

                        <p class="inner-text py-3">{{ $about->text_2 }}</p>

                        <a href="#" class="follow-link">Saiba mais <i class="fas fa-caret-right"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 pt-10 pb-9 xs-bg-solitude">
                <div class="row">
                    <div class="col">
                        <div class="row">
                            <div class="col-sm-6 mb-5">
                                <img src="/store/images/ic-atendimento.png" srcset="/store/images/ic-atendimento@2x.png 2x, /store/images/ic-atendimento@3x.png 3x" class="ic_atendimento mb-4">
                                <h4>{{ $about_item[0]->title }}</h4> <!-- Comunicar -->
                                <p class="item-inner-text">{{ $about_item[0]->text }}</p>
                            </div>
                            <div class="col-sm-6 mb-5 mb-sm-0">
                                <img src="/store/images/ic-descomplicar.png" srcset="/store/images/ic-descomplicar@2x.png 2x, /store/images/ic-descomplicar@3x.png 3x" class="ic_descomplicar mb-4">
                                <h4>{{ $about_item[1]->title }}</h4>
                                {{--<h4>Descomplicar</h4>--}}
                                <p class="item-inner-text">{{ $about_item[1]->text }}</p>
                            </div>
                            <div class="col-sm-6 mb-5 mb-sm-0">
                                <img src="/store/images/ic-engajar.png" srcset="/store/images/ic-engajar@2x.png 2x, /store/images/ic-engajar@3x.png 3x" class="ic_engajar mb-4">
                                <h4>{{ $about_item[2]->title }}</h4>
                                {{--<h4>Engajar</h4>--}}
                                <p class="item-inner-text">{{ $about_item[2]->text }}</p>
                            </div>
                            <div class="col-sm-6 mb-5 mb-sm-0">
                                <img src="/store/images/ic-comunicar.png" srcset="/store/images/ic-comunicar@2x.png 2x, /store/images/ic-comunicar@3x.png 3x" class="ic_comunicar mb-4">
                                <h4>{{ $about_item[3]->title }}</h4>
                                {{--<h4>Conectar</h4>--}}
                                <p class="item-inner-text">{{ $about_item[3]->text }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--<div class="container-fluid px-xs-0 overflow-hidden">
    <div class="container py-10">
        <div class="row">
            <div class="col-12">
                <div id="carousel-customers">
                    <div class="carousel-inner">
                        <img src="/store/images/ic-quote.png" srcset="/store/images/ic-quote@2x.png 2x, /store/images/ic-quote@3x.png 3x" class="ic-quote mb-5">
                        <div id="slick-carousel-customers">
                            <div class="item">
                                <p class="slide-inner-text">Utilizo o Beconnect há 6 meses e só tenho elogios. O atendimentos é fantástico, e agora eu tenho controle de todos os meus
                                    visitantes.</p>
                                <div class="carousel-caption">
                                    <div class="row">
                                        <div class="col-3 col-sm-1 ml-sm-auto">
                                            <img src="/store/images/avatar.jpg" class="img-fluid rounded-circle ml-auto" alt=""/>
                                        </div>
                                        <div class="col-9 col-sm-4">
                                            <h3>Roberto DeNino</h3>
                                            <p>Presidente executivo da Universal</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <p class="slide-inner-text">Utilizo o Beconnect há 6 meses e só tenho elogios. O atendimentos é fantástico, e agora eu tenho controle de todos os meus
                                    visitantes.</p>
                                <div class="carousel-caption">
                                    <div class="row">
                                        <div class="col-3 col-sm-1 ml-sm-auto">
                                            <img src="/store/images/avatar.jpg" class="img-fluid rounded-circle ml-auto" alt=""/>
                                        </div>
                                        <div class="col-9 col-sm-4">
                                            <h3>Roberto DeNino</h3>
                                            <p>Presidente executivo da Universal</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <p class="slide-inner-text">Utilizo o Beconnect há 6 meses e só tenho elogios. O atendimentos é fantástico, e agora eu tenho controle de todos os meus
                                    visitantes.</p>
                                <div class="carousel-caption">
                                    <div class="row">
                                        <div class="col-3 col-sm-1 ml-sm-auto">
                                            <img src="/store/images/avatar.jpg" class="img-fluid rounded-circle ml-auto" alt=""/>
                                        </div>
                                        <div class="col-9 col-sm-4">
                                            <h3>Roberto DeNino</h3>
                                            <p>Presidente executivo da Universal</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>-->

    <div class="container-fluid py-10" id="container-carousel-app">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 hidden-xs-down">
                    <div id="carousel-app">
                        <div class="device-mobile device-iphone shadow interactive-screen"><!-- Select mobile device -->
                            <div class="carousel-inner img-screen-wrapper">
                                <div id="slick-carousel-app">
                                    <div class="item">
                                        <img src="/store/images/carousel-app-1.png">
                                    </div>
                                    <div class="item">
                                        <img src="/store/images/carousel-app-1.png">
                                    </div>
                                    <div class="item">
                                        <img src="/store/images/carousel-app-1.png">
                                    </div>
                                    <div class="item">
                                        <img src="/store/images/carousel-app-1.png">
                                    </div>
                                    <div class="item">
                                        <img src="/store/images/carousel-app-1.png">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6"> <!--  d-flex align-items-center -->
                    <div id="carousel-app-description">
                        <div class="carousel-inner">
                            <div id="slick-carousel-app-description">
                                @foreach($features as $feature)
                                    <div class="item">
                                        <div class="row">
                                            <div class="col">
                                                <div class="row">
                                                    <div class="col-12">
                                                        {{--<h3 class="slide-title">Login com <span class="font-weight-bold">redes sociais</span></h3>--}}
                                                        <h3 class="slide-title">{{ $feature->title }}</h3>
                                                    </div>
                                                    <div class="col-12">
                                                        <p class="inner-text">{{ $feature->text }}</p>
                                                    </div>
                                                    <div class="col-12">
                                                        <ul class="list-unstyled pt-4 slide-list">
                                                            @foreach($feature_item as $item)
                                                                <li>
                                                                    @if($item->feature_id == $feature->id)
                                                                        @if($item->icon_name)
                                                                            <img src="{{ $item->icon_name->path }}" srcset="{{ $item->icon_name->path }}@2x.png 2x, {{ $item->icon_name->path }}@3x.png 3x" class="ic-face">
                                                                        @else
                                                                            <img src="/store/images/ic-twitter.png" srcset="/store/images/ic-twitter@2x.png 2x, /store/images/ic-twitter@3x.png 3x"
                                                                                  class="ic-twitter">
                                                                        @endif

                                                                            {{ $item->text }}
                                                                    @endif
                                                                    {{----}}

                                                                </li>
                                                            @endforeach

                                                                {{--<img src="/store/images/ic-twitter.png" srcset="/store/images/ic-twitter@2x.png 2x, /store/images/ic-twitter@3x.png 3x"
                                                                     class="ic-twitter">--}}

                                                                {{--<img src="/store/images/ic-google.png" srcset="/store/images/ic-google@2x.png 2x, /store/images/ic-google@3x.png 3x" class="ic_google">--}}

                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                {{--<div class="item">
                                    <div class="row">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h3 class="slide-title"><span class="font-weight-bold">Checkin</span> automático de eventos</h3>
                                                </div>
                                                <div class="col-12">
                                                    <p class="inner-text">Com o checkin automático Beconnect nós facilitamos a forma como seus membros fazem checkin em seu sistema. </p>
                                                </div>
                                                <div class="col-12">
                                                    <ul class="list-unstyled pt-4 slide-list">
                                                        <li>
                                                            <img src="/store/images/ic-checkin.png" srcset="/store/images/ic-checkin@2x.png 2x, /store/images/ic-checkin@3x.png 3x"
                                                                 class="ic-checkin">
                                                            Checkin automático
                                                        </li>
                                                        <li>
                                                            <img src="/store/images/ic-eye.png" srcset="/store/images/ic-eye@2x.png 2x, /store/images/ic-eye@3x.png 3x" class="ic-eye">
                                                            Reconhecimentos facial
                                                        </li>
                                                        <li>
                                                            <img src="/store/images/ic-alerta.png" srcset="/store/images/ic-alerta@2x.png 2x, /store/images/ic-alerta@3x.png 3x" class="ic_alerta">
                                                            Alertas de eventos
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h3 class="slide-title"><span class="font-weight-bold">Dashboards</span> de métricas de eventos</h3>
                                                </div>
                                                <div class="col-12">
                                                    <p class="inner-text">Tenha controle e números precisos de suas finanças, checkins dos seus mebros, eventos, e mural de informações sobre seus
                                                        membros.</p>
                                                </div>
                                                <div class="col-12">
                                                    <ul class="list-unstyled pt-4 slide-list">
                                                        <li>
                                                            <img src="/store/images/ic-money.png" srcset="/store/images/ic-money@2x.png 2x, /store/images/ic-money@3x.png 3x" class="ic-money">
                                                            Fluxo de caixa
                                                        </li>
                                                        <li>
                                                            <img src="/store/images/ic-person.png" srcset="/store/images/ic-person@2x.png 2x, /store/images/ic-person@3x.png 3x" class="ic-person">
                                                            Novos membros
                                                        </li>
                                                        <li>
                                                            <img src="/store/images/ic-grafic.png" srcset="/store/images/ic-grafic@2x.png 2x, /store/images/ic-grafic@3x.png 3x" class="ic_grafic">
                                                            Gráficos de métricas
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h3 class="slide-title"><span class="font-weight-bold">Agendas</span> online de eventos e grupos</h3>
                                                </div>
                                                <div class="col-12">
                                                    <p class="inner-text">Tenha controle e números precisos de suas finanças, checkins dos seus mebros, eventos, e mural de informações sobre seus
                                                        membros.</p>
                                                </div>
                                                <div class="col-12">
                                                    <ul class="list-unstyled pt-4 slide-list">
                                                        <li>
                                                            <img src="/store/images/ic-evento.png" srcset="/store/images/ic-evento@2x.png 2x, /store/images/ic-evento@3x.png 3x" class="ic-evento">
                                                            Eventos
                                                        </li>
                                                        <li>
                                                            <img src="/store/images/ic-message.png" srcset="/store/images/ic-message@2x.png 2x, /store/images/ic-message@3x.png 3x"
                                                                 class="ic-message">
                                                            Mensagens de grupos
                                                        </li>
                                                        <li>
                                                            <img src="/store/images/ic-group.png" srcset="/store/images/ic-group@2x.png 2x, /store/images/ic-group@3x.png 3x" class="ic_group">
                                                            Grupos
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h3 class="slide-title"><span class="font-weight-bold">Pagamentos</span> de eventos</h3>
                                                </div>
                                                <div class="col-12">
                                                    <p class="inner-text">Tenha controle e números precisos de suas finanças, checkins dos seus mebros, eventos, e mural de informações sobre seus
                                                        membros.</p>
                                                </div>
                                                <div class="col-12">
                                                    <ul class="list-unstyled pt-4 slide-list">
                                                        <li>
                                                            <img src="/store/images/ic-lock.png" srcset="/store/images/ic-lock@2x.png 2x, /store/images/ic-lock@3x.png 3x" class="ic-lock">
                                                            Sistema seguro
                                                        </li>
                                                        <li>
                                                            <img src="/store/images/ic-cart.png" srcset="/store/images/ic-cart@2x.png 2x, /store/images/ic-cart@3x.png 3x" class="ic-cart">
                                                            Pagamento simplificado
                                                        </li>
                                                        <li>
                                                            <img src="/store/images/ic-clock.png" srcset="/store/images/ic-clock@2x.png 2x, /store/images/ic-clock@3x.png 3x" class="ic_clock">
                                                            Pagamento feito em minutos
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--<div class="container-fluid pt-sm-5 pt-5" id="pricings">
    <div class="container pt-sm-5">
        <div class="row pt-sm-5">
            <div class="col-sm-8 pt-sm-5">
                <h6 class="color-white">NOSSOS PLANOS</h6>
                <p class="pricing-subtitle">Escolha o melhor plano para você, os primeiros 30 dias são <span class="font-weight-bold">grátis</span>.</p>
                <p class="pricing-description">Veja o plano que mais se adequa a sua necessidade, e faça o teste gratuito sem compromisso.</p>
            </div>
        </div>
    </div>
</div>-->

<div class="container" id="pricing-second">
    <div class="row">
        <!--<div class="col-sm-5 mx-auto mb-5" style="margin-top: 50px;">
            <div class="btn-group pricing-options" data-toggle="buttons">
                <?php $i = 0; ?>
                @foreach($plans_types as $plan_type)
                    <label id="btn-type-{{ $plan_type->id }}" class="btn btn-secondary btn-type @if($i == 0 ) active @endif">
                        @if($plan_type->save_money > 0)
                            <span>Economize {{ $plan_type->save_money }}% <i class="fas fa-caret-down"></i></span>
                        @endif
                        <input type="radio" name="options" class="type-class" id="option-{{ $plan_type->id }}" autocomplete="off" @if($i == 0 ) checked @endif>
                            {{ $plan_type->selected_text }}
                    </label>
                    <?php $i++; ?>
                @endforeach

                {{--<label class="btn btn-secondary">
                    <span>Economize 20% <i class="fas fa-caret-down"></i></span>
                    <input type="radio" name="options" id="option2" autocomplete="off"> Pago anualmente
                </label>--}}
            </div>
        </div>-->
    </div>

    <div class="row ">
        <!--@foreach($plans as $plan)

                <div class="col-xs-12 col-lg-3 match-height mb-5 mb-sm-0 type-card type-id-{{ $plan->type_id }} mx-auto">
                    <div class="card-price text-xs-center">
                        @if($plan->most_popular == 1)
                            <span class="card-alert">MAIS POPULAR</span>
                        @endif
                        <div class="card-block match-height-head">
                            <h4 class="card-title">{{ $plan->name }}</h4>
                            <p class="card-subtitle">{{ $plan->description }}</p>
                        </div>
                        <div class="col-12 px-0">
                            <hr/>
                        </div>
                        <div class="card-block match-height-body">
                            <ul class="list-group">

                                @foreach($plan_features as $feature)
                                    @if($feature->plan_id == $plan->id)
                                        @foreach($plans_item as $item)
                                            @if($feature->plan_item_id == $item->id)
                                                <li class="list-group-item py-2"><i class="fas fa-check mr-2"></i> {{ $item->text }}</li>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach

                            </ul>

                        </div>
                        <div class="card-header">
                            @foreach($plans_types as $type)
                                @if($plan->type_id == $type->id)
                                    <br>
                                    <h3 class="display-2"><span class="currency">R$</span>{{ $plan->price }}<span class="period">{{ $type->adjective }}</span></h3>
                                @endif
                            @endforeach
                        </div>
                        <div class="card-block">
                            <a href="{{ route('site.trial', ['id' => $plan->id]) }}" class="btn btn-gradient mt-2 btn-block">TESTE GRÁTIS</a>
                        </div>
                    </div>
                </div>
        @endforeach-->


        {{--<<div class="col-xs-12 col-lg-3 match-height mb-5 mb-sm-0">
            <div class="card-price text-xs-center">
                <div class="card-block">
                    <h4 class="card-title">Ouro</h4>
                    <p class="card-subtitle">Plano para pequenas igrejas com poucos visitantes.</p>
                </div>
                <div class="col-12 px-0">
                    <hr/>
                </div>
                <div class="card-block">
                    <ul class="list-group">
                        <li class="list-group-item py-2"><i class="fas fa-check mr-2"></i> Usuários ilimitados</li>
                        <li class="list-group-item py-2"><i class="fas fa-check mr-2"></i> Admins ilimitados</li>
                        <li class="list-group-item py-2"><i class="fas fa-check mr-2"></i> Atendimento 24 por 7</li>
                    </ul>
                </div>
                <div class="card-header">
                    <h3 class="display-2"><span class="currency">R$</span>99<span class="period">MENSAIS</span></h3>
                </div>
                <div class="card-block">
                    <a href="#" class="btn btn-gradient mt-2 btn-block">TESTE GRÁTIS</a>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-lg-3 match-height">
            <div class="card-price text-xs-center">
                <div class="card-block">
                    <h4 class="card-title">Diamante</h4>
                    <p class="card-subtitle">Plano para pequenas igrejas com poucos visitantes.</p>
                </div>
                <div class="col-12 px-0">
                    <hr/>
                </div>
                <div class="card-block">
                    <ul class="list-group">
                        <li class="list-group-item py-2"><i class="fas fa-check mr-2"></i> Usuários ilimitados</li>
                        <li class="list-group-item py-2"><i class="fas fa-check mr-2"></i> Admins ilimitados</li>
                        <li class="list-group-item py-2"><i class="fas fa-check mr-2"></i> Atendimento 24 por 7</li>
                    </ul>
                </div>
                <div class="card-header">
                    <h3 class="display-2"><span class="currency">R$</span>99<span class="period">MENSAIS</span></h3>
                </div>
                <div class="card-block">
                    <a href="#" class="btn btn-gradient mt-2 btn-block">TESTE GRÁTIS</a>
                </div>
            </div>
        </div>--}}
    </div>

    <div class="row mt-5 pt-5">
        <div class="col-sm-6 pr-5">
            <h6>PERGUNTAS FREQUENTES</h6>
            <p class="inner-text">Tem alguma dúvida? <a href="#">Entre em contato</a> com a gente, teremos o prazer de tirar todas suas dúvidas.</p>
        </div>
        <div class="col-sm-6">
            <div id="accordion" role="tablist">
                @foreach($faq as $f)
                    <div class="card list">
                        <div class="card-header" role="tab" id="heading-{{ $f->id }}">
                            <h6 class="mb-0">
                                <a class="collapsed" data-toggle="collapse" href="#collapse-{{ $f->id }}" aria-expanded="false" aria-controls="collapse-{{ $f->id }}">
                                    <span class="fw-600">{{ $f->question }}</span> <i class="fas fa-sort-down float-right"></i>
                                </a>
                            </h6>
                        </div>

                        <div id="collapse-{{ $f->id }}" class="collapse" role="tabpanel" aria-labelledby="heading-{{ $f->id }}" data-parent="#accordion">
                            <div class="card-body inner-text py-3 fs-20">
                                {{ $f->answer }}
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</div>

<div class="container-fluid parent-container px-0 overflow-hidden">
    <!--    <div class="col-sm-10 ml-auto child-container">-->
    <div class="col-12 px-0 child-container">
        <img src="/store/images/contact_bg.png" class="h-100 hidden-sm-down" alt=""/>
        <img src="/store/images/contact_bg_mobile.png" class="h-100 hidden-sm-up" alt=""/>
    </div>

    <div class="container-fluid px-0">
        <div class="col-sm-7 ml-auto pl-sm-5 m py-10 transparent-grape">
            <div class="row pt-5 pt-sm-0">
                <div class="col-sm-6">
                    <h5>ENTRE EM CONTATO</h5>
                    <p class="inner-text">Tem alguma dúvida? Alguma sugestão. reclamação? Se sinta à vontade para nos mandar uma mensagem.</p>

                    <form action="" id="form-site" method="POST">
                        <div class="form-group">
                            <label class="has-float-label" aria-label="Nome">
                                <input class="form-control" type="text" placeholder="Nome" name="name" required/>
                                <span>Nome</span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="has-float-label" aria-label="Email">
                                <input class="form-control" type="email" placeholder="Email" name="email" required/>
                                <span>Email</span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="has-float-label" aria-label="Telefone">
                                <input class="form-control tel" type="text" placeholder="Telefone" name="tel" required/>
                                <span>Telefone</span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="has-float-label" aria-label="Mensagem">
                                <input class="form-control" type="text" placeholder="Mensagem" name="msg" required/>
                                <span>Mensagem</span>
                            </label>
                        </div>

                        <button class="btn btn-outline-primary float-right btn-submit mt-5" type="submit">enviar mensagem</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="container my-sm-5 py-5">
    <div class="row">
        <div class="col-sm-3 mb-5">
            <a href="#"><img src="/store/images/logo-2.png" srcset="/store/images/logo-2@2x.png 2x, /store/images/logo-2@3x.png 3x" class="logo_2"></a>
        </div>
        <div class="col-sm-3 mb-5">
            <span class="footer-title">Contato</span>
            <ul class="footer-list list-unstyled">
                <li>contato@beconnect.com.br</li>
                <li>11.98765.8765</li>
            </ul>
        </div>
        <div class="col-sm-3 pl-sm-5 mb-5">
            <span class="footer-title">Redes sociais</span>
            <div class="row">
                <div class="col-2">
                    <a href="#">
                        <i class="fab fa-facebook icon"></i>
                    </a>
                </div>
                <div class="col-2">
                    <a href="#">
                        <i class="fab fa-twitter icon"></i>
                    </a>
                </div>
                <div class="col-2">
                    <a href="#">
                        <i class="fab fa-linkedin icon"></i>
                    </a>
                </div>
                <div class="col-2">
                    <a href="#">
                        <i class="fab fa-instagram icon"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-sm-3 text-sm-center mb-5">
            {{--<a href="#" class="btn btn-secondary">Login</a>--}}
            <a href="{{ url('/login') }}" class="btn btn-secondary">Login</a>
        </div>
    </div>

    <div class="col-12 px-0">
        <hr class="line"/>
    </div>

    <small>R. Hungria, 1240 - Pinheiros, São Paulo - SP, 07797-040</small>
</div>

<script src="../js/site.js" type="text/javascript"></script>
<script src="../js/maskbrphone.js"></script>
<script src="../assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js" type="text/javascript"></script>
<script src="../assets/pages/scripts/ui-sweetalert.min.js" type="text/javascript"></script>

<script type="text/javascript">
    $(function () {
        $('#pricings').height($(window).width() > 320 ? '+=35%' : '+=50%');

        $(window).on('scroll', function () {
            if (this.scrollY <= 10) {
                $('#navbar').removeClass('scroll');
            } else {
                $('#navbar').addClass('scroll');
            }
        });

        $("#slick-carousel-customers").slick({
            autoplay: true,
            dots: true,
            centerMode: true,
            centerPadding: '0px',
            slidesToShow: 1,
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        centerMode: false
                    }
                }
            ]
        });

        if (!isMobile()) {
            $("#slick-carousel-app").slick({
                dots: true,
                arrows: false,
                autoplay: true
            });

            $("#slick-carousel-app-description").slick(
                    {
                        accessibility: false,
                        arrows: false,
                        draggable: false
                    }
            );

            $('#slick-carousel-app').on('afterChange', function (event, slick, currentSlide) {
                $('#slick-carousel-app-description').slick('slickGoTo', currentSlide, true);
            });
        }

        $('a[data-toggle=collapse]').on('click', function () {
            $(this).find('svg').toggleClass('fa-sort-up fa-sort-down')
        });
    });
</script>

@include('includes.footer-site')