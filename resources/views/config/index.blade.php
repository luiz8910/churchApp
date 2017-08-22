<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
@if(!isset($church_id) || $church_id == null)
    @include('includes.head')

    <!--<link href="../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css" />-->
        <link href="../assets/pages/css/search.min.css" rel="stylesheet" type="text/css"/>
        <link href="../css/navbar.css" rel="stylesheet" type="text/css"/>
        <link href="../css/page-config.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="../css/calendar.css">
        <!--<script src="../js/ajax.js"></script>-->

@else
    @include('includes.head-edit')
    <!--<link href="../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css" />-->
        <link href="../../assets/pages/css/search.min.css" rel="stylesheet" type="text/css"/>
        <link href="../../css/navbar.css" rel="stylesheet" type="text/css"/>
        <link href="../../css/page-config.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="../../css/calendar.css">
        <!--<script src="../js/ajax.js"></script>-->
    @endif

</head>
<!-- END HEAD -->

<body class="page-container-bg-solid">
	<div class="page-wrapper">
		<div class="page-wrapper-row">
			<div class="page-wrapper-top">
				<!-- BEGIN HEADER -->
			@if(!isset($church_id) || $church_id == null)
				@include('includes.header')
			@else
				@include('includes.header-edit')
			@endif
			<!-- END HEADER -->
			</div> <!-- FIM DIV.page-wrapper-top -->
		</div> <!-- FIM DIV.page-wrapper-row -->

		<div class="page-wrapper-row full-height">
			<div class="page-wrapper-middle">
				<div class="page-container">
					<div class="page-content-wrapper">
						<div class="page-head">
							<div class="container">
								<div class="page-title hidden-xs hidden-sm">
									<h1>Configurações
										<small>Permissões</small>
									</h1>
								</div>
							</div> <!-- FIM DIV .container -->
						</div> <!-- FIM DIV .page-head -->

						<div class="page-content">
							<div class="container">
								<div class="page-content-inner">
									<div class="row">
										<div class="col-md-12">
											<div class="portlet light ">
                                                <div class="portlet-title">
													<div class="caption font-green-haze">
														<i class="icon-settings font-red"></i>
														<span class="caption-subject font-red bold uppercase"> Pessoas</span>
													</div> <!-- FIM DIV .caption.font-green-haze -->
													<div class="actions">
                                                        <div class="btn-group btn-group-devided">
                                                            <div class="btn-group">
                                                                <a class="btn red btn-outline btn-circle" href="javascript:;" data-toggle="dropdown">
                                                                    <i class="fa fa-share"></i>
                                                                    <span class="hidden-xs"> Opções </span>
                                                                    <i class="fa fa-angle-down"></i>
                                                                </a>
                                                                <ul class="dropdown-menu pull-right" id="sample_3_tools">
                                                                    <li>
                                                                        <a href="javascript:;" data-toggle="modal" data-target="#newModel">
                                                                            <i class="fa fa-table" aria-hidden="true"></i>
                                                                            Classe
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:;" data-toggle="modal" data-target="#newRule-person">
                                                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                                                            Nova Regra
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:;">
                                                                            <i class="fa fa-undo" aria-hidden="true"></i>
                                                                            Voltar ao Padrão
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div> <!-- FIM DIV .actions -->
												</div> <!-- FIM DIV .portlet-title -->

                                                <div class="portlet-body form">
                                                    <div class="portlet-body-config">
                                                    	<div class="table-scrollable table-scrollable-borderless table-striped">
                                                            <table class="table table-hover table-light table-striped">
                                                                <thead>
                                                                    <tr class="uppercase">
                                                                        <th style="width: 90%;"> CAMPO </th>
                                                                        <th style="width: 10%;"> REQUERIDO </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td> Nome </td>
                                                                        <td>
                                                                        	<div class="md-checkbox" style="left: 30%; width: 10px;">
																				<input type="checkbox" id="checkbox1a" class="md-check">
																				<label for="checkbox1a">
																					<span class="inc"></span>
																					<span class="check"></span>
																					<span class="box"></span>
                                                                   				</label>
                                                                    		</div>
                                                                    	</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td> Nome </td>
                                                                        <td>
                                                                        	<div class="md-checkbox" style="left: 30%; width: 10px;">
																				<input type="checkbox" id="checkbox2a" class="md-check">
																				<label for="checkbox2a">
																					<span class="inc"></span>
																					<span class="check"></span>
																					<span class="box"></span>
                                                                   				</label>
                                                                    		</div>
                                                                    	</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td> Nome </td>
                                                                        <td>
                                                                        	<div class="md-checkbox" style="left: 30%; width: 10px;">
																				<input type="checkbox" id="checkbox3a" class="md-check">
																				<label for="checkbox3a">
																					<span class="inc"></span>
																					<span class="check"></span>
																					<span class="box"></span>
                                                                   				</label>
                                                                    		</div>
                                                                    	</td>
                                                                    </tr>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>  <!-- FIM DIV .form-body -->

													<div class="form-actions ">
														<button type="button" class="btn blue">Enviar</button>
														<button type="button" class="btn default">Cancel</button>
													</div>
                                                </div> <!-- FIM DIV .portlet-body.form  -->
                                            </div> <!-- FIM DIV .portlet.light -->
										</div> <!-- FIM DIV .col-md-12 -->
									</div> <!-- FIM DIV .row -->
								</div> <!-- FIM DIV .page-content-inner -->
							</div>  <!-- FIM DIV .container -->


							<div class="container">
								<div class="page-content-inner">
									<div class="row">
										<div class="col-md-12">
											<div class="portlet light ">
                                                <div class="portlet-title">
													<div class="caption font-green-haze">
														<i class="icon-settings font-red"></i>
														<span class="caption-subject font-red bold uppercase"> Pessoas</span>
													</div> <!-- FIM DIV .caption.font-green-haze -->
													<div class="actions">
                                                        <div class="btn-group btn-group-devided">
                                                            <div class="btn-group">
                                                                <a class="btn red btn-outline btn-circle" href="javascript:;" data-toggle="dropdown">
                                                                    <i class="fa fa-share"></i>
                                                                    <span class="hidden-xs"> Opções </span>
                                                                    <i class="fa fa-angle-down"></i>
                                                                </a>
                                                                <ul class="dropdown-menu pull-right" id="sample_3_tools">
                                                                    <li>
                                                                        <a href="javascript:;" data-toggle="modal" data-target="#newModel">
                                                                            <i class="fa fa-table" aria-hidden="true"></i>
                                                                            Classe
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:;" data-toggle="modal" data-target="#newRule-person">
                                                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                                                            Nova Regra
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:;">
                                                                            <i class="fa fa-undo" aria-hidden="true"></i>
                                                                            Voltar ao Padrão
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div> <!-- FIM DIV .actions -->
												</div> <!-- FIM DIV .portlet-title -->

                                                <div class="portlet-body form">
                                                    <div class="portlet-body-config">
                                                    	<div class="table-scrollable table-scrollable-borderless table-striped">
                                                            <table class="table table-hover table-light table-striped">
                                                                <thead>
                                                                    <tr class="uppercase">
                                                                        <th style="width: 90%;"> CAMPO </th>
                                                                        <th style="width: 10%;"> REQUERIDO </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td> Nome </td>
                                                                        <td>
                                                                        	<div class="md-checkbox" style="left: 30%; width: 10px;">
																				<input type="checkbox" id="checkbox1b" class="md-check">
																				<label for="checkbox1b">
																					<span class="inc"></span>
																					<span class="check"></span>
																					<span class="box"></span>
                                                                   				</label>
                                                                    		</div>
                                                                    	</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td> Nome </td>
                                                                        <td>
                                                                        	<div class="md-checkbox" style="left: 30%; width: 10px;">
																				<input type="checkbox" id="checkbox2b" class="md-check">
																				<label for="checkbox2b">
																					<span class="inc"></span>
																					<span class="check"></span>
																					<span class="box"></span>
                                                                   				</label>
                                                                    		</div>
                                                                    	</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td> Nome </td>
                                                                        <td>
                                                                        	<div class="md-checkbox" style="left: 30%; width: 10px;">
																				<input type="checkbox" id="checkbox3b" class="md-check">
																				<label for="checkbox3b">
																					<span class="inc"></span>
																					<span class="check"></span>
																					<span class="box"></span>
                                                                   				</label>
                                                                    		</div>
                                                                    	</td>
                                                                    </tr>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>  <!-- FIM DIV .form-body -->

													<div class="form-actions ">
														<button type="button" class="btn blue">Enviar</button>
														<button type="button" class="btn default">Cancel</button>
													</div>
                                                </div> <!-- FIM DIV .portlet-body.form  -->
                                            </div> <!-- FIM DIV .portlet.light -->
										</div> <!-- FIM DIV .col-md-12 -->
									</div> <!-- FIM DIV .row -->
								</div> <!-- FIM DIV .page-content-inner -->
							</div>  <!-- FIM DIV .container -->



							<div class="container">
								<div class="page-content-inner">
									<div class="row">
										<div class="col-md-12">
											<div class="portlet light ">
                                                <div class="portlet-title">
													<div class="caption font-green-haze">
														<i class="icon-settings font-red"></i>
														<span class="caption-subject font-red bold uppercase"> Eventos</span>
													</div> <!-- FIM DIV .caption.font-green-haze -->
													<div class="actions">
                                                        <div class="btn-group btn-group-devided">
                                                            <div class="btn-group">
                                                                <a class="btn red btn-outline btn-circle" href="javascript:;" data-toggle="dropdown">
                                                                    <i class="fa fa-share"></i>
                                                                    <span class="hidden-xs"> Opções </span>
                                                                    <i class="fa fa-angle-down"></i>
                                                                </a>
                                                                <ul class="dropdown-menu pull-right" id="sample_3_tools">
                                                                    <li>
                                                                        <a href="javascript:;" data-toggle="modal" data-target="#newModel">
                                                                            <i class="fa fa-table" aria-hidden="true"></i>
                                                                            Classe
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:;" data-toggle="modal" data-target="#newRule-person">
                                                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                                                            Nova Regra
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:;">
                                                                            <i class="fa fa-undo" aria-hidden="true"></i>
                                                                            Voltar ao Padrão
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div> <!-- FIM DIV .actions -->
												</div> <!-- FIM DIV .portlet-title -->

                                                <div class="portlet-body form">
                                                    <div class="portlet-body-config">
                                                    	<div class="table-scrollable table-scrollable-borderless table-striped">
                                                            <table class="table table-hover table-light table-striped">
                                                                <thead>
                                                                    <tr class="uppercase">
                                                                        <th style="width: 90%;"> CAMPO </th>
                                                                        <th style="width: 10%;"> REQUERIDO </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td> Nome </td>
                                                                        <td>
                                                                        	<div class="md-checkbox" style="left: 30%; width: 10px;">
																				<input type="checkbox" id="checkbox1c" class="md-check">
																				<label for="checkbox1c">
																					<span class="inc"></span>
																					<span class="check"></span>
																					<span class="box"></span>
                                                                   				</label>
                                                                    		</div>
                                                                    	</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td> Nome </td>
                                                                        <td>
                                                                        	<div class="md-checkbox" style="left: 30%; width: 10px;">
																				<input type="checkbox" id="checkbox2c" class="md-check">
																				<label for="checkbox2c">
																					<span class="inc"></span>
																					<span class="check"></span>
																					<span class="box"></span>
                                                                   				</label>
                                                                    		</div>
                                                                    	</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td> Nome </td>
                                                                        <td>
                                                                        	<div class="md-checkbox" style="left: 30%; width: 10px;">
																				<input type="checkbox" id="checkbox3c" class="md-check">
																				<label for="checkbox3c">
																					<span class="inc"></span>
																					<span class="check"></span>
																					<span class="box"></span>
                                                                   				</label>
                                                                    		</div>
                                                                    	</td>
                                                                    </tr>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>  <!-- FIM DIV .form-body -->

													<div class="form-actions ">
														<button type="button" class="btn blue">Enviar</button>
														<button type="button" class="btn default">Cancel</button>
													</div>
                                                </div> <!-- FIM DIV .portlet-body.form  -->
                                            </div> <!-- FIM DIV .portlet.light -->
										</div> <!-- FIM DIV .col-md-12 -->
									</div> <!-- FIM DIV .row -->
								</div> <!-- FIM DIV .page-content-inner -->
							</div>  <!-- FIM DIV .container -->




						</div>  <!-- FIM DIV .page-content -->
					</div> <!-- FIM DIV .page-content-wrapper -->
				</div> <!-- FIM DIV .page-container -->
			</div> <!-- FIM DIV .page-wrapper-middle -->
		</div> <!-- FIM DIV .page-wrapper-row.full-height -->
	@include('includes.footer')
	</div><!-- FIM DIV.page-wrapper -->

<!-- END QUICK NAV -->
@if(!isset($church_id) || $church_id == null)
    @include('includes.core-scripts')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <!--<script src="../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>-->
    <!--<script src="../assets/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script>-->
    <!--<script src="../assets/global/plugins/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>-->
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="../assets/pages/scripts/search.min.js" type="text/javascript"></script>
    <!--<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>-->
@else
    @include('includes.core-scripts-edit')
    <script src="../../assets/pages/scripts/search.min.js" type="text/javascript"></script>
@endif

</body>

</html>
