<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
	<!-- BEGIN HEAD -->
	<head>
	@if(!isset($church_id) || $church_id == null)
		@include('includes.head')
			<link href="../assets/pages/css/search.min.css" rel="stylesheet" type="text/css"/>
			<link href="../css/navbar.css" rel="stylesheet" type="text/css"/>
			<link href="../css/page-config.css" rel="stylesheet" type="text/css"/>
			<link rel="stylesheet" href="../css/calendar.css">

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

	<body class="page-container-bg-solid page-boxed">
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
				</div>
			</div>

			<div class="page-wrapper-row full-height">
				<div class="page-wrapper-middle">
					<div class="page-container">
						<div class="page-content-wrapper">
							<div class="page-head">
								<div class="container">
									<div class="page-title">
										<h1> Configurações
											<small>Permissões</small>
										</h1>
									</div> <!-- FIM DIV .page-title -->
								</div> <!-- FIM DIV .container -->
							</div> <!-- FIM DIV .page-head -->

							<div class="page-content">
								<div class="container">
									<div class="alert alert-danger alert-dismissible" id="delete-group-alert" role="alert"
										 style="display: none;">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
													aria-hidden="true">&times;</span></button>
										<strong>Atenção </strong><span id="message"></span>
									</div>

									@if(Session::has('error.field'))
									<div class="alert alert-danger alert-dismissible" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span></button>
										<strong>Atenção </strong> {{ Session::get('error.field') }}
									</div>
								@endif
								<!-- END PAGE BREADCRUMBS -->

									<!-- Modal -->
									<div class="modal fade" id="newModel" tabindex="-1" role="dialog"
										 aria-labelledby="myModalLabel">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span></button>
													<h4 class="modal-title" id="myModalLabel">Nova Classe</h4>
												</div>

												{!! Form::open(['route' => 'config.newModel', 'method' => 'POST']) !!}
												<div class="modal-body">

													<div class="row">
														<div class="col-md-4">
															<label> Model:</label>
															<input type="text" name="model" class="form-control" required>

														</div>

														<div class="col-md-4">
															<label> Text: </label>
															<input type="text" name="text" class="form-control" required>
														</div>

													</div>


												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Fechar
													</button>
													<button class="btn btn-primary" type="submit">Salvar</button>
												</div>
												{!! Form::close() !!}
											</div>
										</div>
									</div>
									<?php $i = 0; ?>
									@foreach($models as $model)

									<div class="page-content-inner">
										<div class="row">
											<div class="col-md-12">
												<div class="portlet light">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-key font-green-haze"></i>
															<span class="caption-subject font-green-haze bold ">{{ $model->text }}</span>
														</div> <!-- FIM DIV .caption -->
														<div class="actions">
															<div class="btn-group">
																<a class="btn red btn-outline btn-circle"
																   href="javascript:;" data-toggle="dropdown">
																	<i class="fa fa-share"></i>
																	<span class="hidden-xs"> Opções </span>
																	<i class="fa fa-angle-down"></i>
																</a>
																<ul class="dropdown-menu pull-right"
																	id="sample_3_tools">
																	<li>
																		<a href="javascript:;" data-toggle="modal"
																		   data-target="#newModel">
																			<i class="fa fa-table"
																			   aria-hidden="true"></i>
																			Classe
																		</a>
																	</li>

																	<li>
																		<a href="javascript:;" data-toggle="modal"
																		   data-target="{{ '#newRule-' . $model->model }}">
																			<i class="fa fa-plus"
																			   aria-hidden="true"></i>
																			Nova Regra
																		</a>
																	</li>

																	<li>
																		<a href="javascript:;">
																			<i class="fa fa-undo"
																			   aria-hidden="true"></i>
																			Voltar ao Padrão
																		</a>
																	</li>
																</ul>
															</div>

														</div> <!-- FIM DIV .actions -->
													</div> <!-- FIM DIV .portlet-title -->

													<!-- Modal -->
													<div class="modal fade" id="{{ 'newRule-' . $model->model }}"
														 tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
														<div class="modal-dialog" role="document">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal"
																			aria-label="Close"><span
																				aria-hidden="true">&times;</span></button>
																	<h4 class="modal-title" id="myModalLabel">Nova Regra
																		- {{ $model->text }}</h4>
																</div>

																{!! Form::open(['route' => ['config.newRule', 'model' => $model->model], 'method' => 'POST']) !!}
																<div class="modal-body">
																	<div class="row">
																		<div class="col-md-4">
																			<label> Valor:</label>
																			<input type="text" name="value"
																				   class="form-control" required>
																		</div>
																		<div class="col-md-4">
																			<label> Nome do Campo: </label>
																			<input type="text" name="field"
																				   class="form-control" required>
																		</div>
																		<div class="col-md-4" style="margin-top: 30px;">
																			<fieldset>
																				<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
																					<input type="checkbox" name="required"
																						   class="checkboxes check-model"
																						   id=""
																						   value="1"/>
																					<span></span>
																				</label>
																				<label class="lbl-txt">Obrigatório</label>
																			</fieldset>
																		</div>
																	</div>
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-default"
																			data-dismiss="modal">Fechar
																	</button>
																	<button class="btn btn-primary" type="submit">Salvar
																	</button>
																</div>
																{!! Form::close() !!}
															</div>
														</div>
													</div>

													<div class="portlet-body form">
														{!! Form::open(['route' =>
															['config.required.fields', 'model' => $model->model], 'method' => 'POST',
															 'class' => 'form-horizontal form-bordered']) !!}
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

																		@if(count($class[$i]) > 0)
																			@foreach($class[$i] as $item)
																				<tr>
																					<td> {{ $item->field }} </td>

																					<td>
																						<div class="md-checkbox" style="left: 30%; width: 10px;">
																							<input type="checkbox" id="checkbox-{{ $model->model."-".$item->value }}"
																								   class="md-check" name="{{ $item->value }}"
																								   @if($item->required != null) checked @endif>

																							<label for="checkbox-{{ $model->model."-".$item->value }}">
																								<span class="inc"></span>
																								<span class="check"></span>
																								<span class="box"></span>
																							</label>
																						</div>
																					</td>
																				</tr>
																			@endforeach
																		@endif

																		<?php $i++; ?>
																	</tbody>
																</table>
															</div> <!-- FIM DIV .table-scrollable table-scrollable-borderless table-striped -->
														</div> <!-- FIM DIV .portlet-body-config -->

														<div class="form-actions ">
															<button class="btn btn-circle btn-success" type="submit">
																<i class="fa fa-check font-white"></i>
																Enviar
															</button>
														</div>

														{!! Form::close() !!}
													</div> <!-- FIM DIV .portlet-body form -->
												</div> <!-- FIM DIV .portlet light -->
											</div> <!-- FIM DIV col-md-12 -->
										</div> <!-- FIM DIV .row -->
									</div> <!-- FIM DIV .page-content-inner -->
									@endforeach
								</div>
							</div>
						</div>
					</div>
				</div>
			</div> <!-- FIM DIV .page-wrapper-row full-height -->
			@include('includes.footer')
		</div> <!-- FIM DIV .page-wrapper -->

		<!-- END QUICK NAV -->
		@if(!isset($church_id) || $church_id == null)
		@include('includes.core-scripts')
		<!-- BEGIN PAGE LEVEL SCRIPTS -->
		<script src="../assets/pages/scripts/search.min.js" type="text/javascript"></script>
		<!--<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>-->
		@else
		@include('includes.core-scripts-edit')
		<script src="../../assets/pages/scripts/search.min.js" type="text/javascript"></script>
		@endif

	</body>
</html>
