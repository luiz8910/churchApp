<!DOCTYPE html>

	<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
	<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
	<!--[if !IE]><!-->
	<html lang="en">
	<!--<![endif]-->
	<!-- BEGIN HEAD -->

	<head>
		@include('includes.head')
		<!-- BEGIN PAGE LEVEL PLUGINS -->
		<link href="assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
		<link href="assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
		<!-- END PAGE LEVEL PLUGINS -->
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
				</div> <!-- FIM DIV.page-wrapper-top -->
        	</div> <!-- FIM DIV.page-wrapper-row -->

        	<div class="page-wrapper-row full-height">
            	<div class="page-wrapper-middle">
					<div class="page-container">
						<div class="page-content-wrapper">
							<div class="page-head">
								<div class="container">
									<div class="page-title">
										<h1>Adultos
											<small>Membros e Etc...</small>
										</h1>
									</div>
								</div> <!-- FIM DIV .container -->
							</div> <!-- FIM DIV .page-head -->

							<div class="page-content">
								<div class="container">
									@if(Session::has('person.crud'))
										<div class="alert alert-success alert-dismissible" role="alert">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
											{{ Session::get('person.crud') }}
										</div>
									@endif

									<?php $route = "person";?>

									<div class="page-content-inner">
										<div class="row">
											<div class="col-md-12">
												<div class="portlet light">
													<div class="portlet-title">
														<div class="caption font-green-haze">
															<i class="fa fa-user font-green-haze"></i>
															<span class="caption-subject font-green-haze bold ">Adultos</span>
														</div>
														<div class="actions">
															<div class="btn-group btn-group-sm">
																	@if(Auth::getUser()->person->role_id == $leader)
																		<div class="col-lg-6">
																			<div class="input-group">
																				<input type="text" class="form-control" id="btn-search" placeholder="Digite 3 letras ou mais...">
																	<span class="input-group-btn">
																		<button class="btn btn-default" type="button">
																			<i class="fa fa-search font-green"></i>
																		</button>
																	</span>
																			</div><!-- /input-group -->
																		</div><!-- /.col-lg-8 -->
																	@endif

																	<div class="col-lg-3">
																		<div class="btn-group-devided">
																			<a role="button" class="btn btn-info btn-circle btn-sm" href="{{ route('person.create') }}" style="margin-top: 2px;">
																				<i class="fa fa-plus"></i>
																				<span class="hidden-xs hidden-sm">Novo Membro</span>
																			</a>

																		</div>
																	</div>

																	<div class="col-lg-3">
																		<a class="btn red btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown">
																			<i class="fa fa-share"></i>
																			<span class="hidden-xs"> Opções </span>
																			<i class="fa fa-angle-down"></i>
																		</a>
																		<ul class="dropdown-menu pull-right" id="sample_3_tools">
																			<li>
																				<a href="javascript:;" id="print" onclick="printDiv('printable-table')"
																				   data-action="0" class="tool-action">
																					<i class="icon-printer"></i> Imprimir
																				</a>
																			</li>
																			<!--<li>
                                                                                <a href="javascript:;" data-action="1" class="tool-action">
                                                                                    <i class="icon-check"></i> Copiar</a>
                                                                            </li>-->
																			<li>
																				<a href="javascript:;" data-action="2"
																				   onclick="printDiv('printable-table', 'pdf')" class="tool-action">
																					<i class="icon-doc"></i> PDF</a>
																			</li>
																			<li>
																				<a href="{{ route($route.'.excel', ['format' => 'xls']) }}"
																				   data-action="3" target="_blank"
																				   class="tool-action">
																					<i class="icon-paper-clip"></i> Excel</a>
																			</li>
																			<li>
																				<a href="{{ route($route.'.excel', ['format' => 'csv']) }}"
																				   data-action="4" target="_blank" class="tool-action">
																					<i class="icon-cloud-upload"></i> CSV</a>
																			</li>
																		</ul>
																	</div>

															</div> <!-- FIM DIV .btn-group -->
														</div> <!-- FIM DIV .actions -->
													</div> <!-- FIM DIV .portlet-title -->

													<div class="portlet-body form">
														<div class="portlet-body-config">
															<div class="col-md-12">
																<div class="div-loading" id="loading-results">
																	<i class="fa fa-refresh fa-spin fa-5x fa-fw"
																	   id="icon-loading-cep">
																	</i>
																	<p class="text-center" id="p-loading-cep">
																		Carregando ...
																	</p>
																</div>

																<p class="text-center" id="p-zero" style="display: none;">
																	Nenhum resultado
																</p>

															</div>
															<div class="table-scrollable table-scrollable-borderless table-striped">
																<table class="table table-hover table-light table-striped">
																	<thead>
																		<tr class="uppercase">
																			<th> Foto </th>
																			<th> Nome </th>
																			<th> CPF </th>
																			<th> Cargo </th>
																			<th> Data de Nasc. </th>
																			<th>  </th>
																		</tr>
																	</thead>
																	<tbody class="hide" id="tbody-search"></tbody>
																	<tbody>
																		@foreach($adults as $item)
																			<tr id="tr-{{ $item->id }}">
																				<td> <img src="{{ $item->imgProfile }}" style="width: 50px; height: 50px;"> </td>
																				<td>
																					@if(\Auth::user()->person_id != $item->id)
																						<a href="{{ route('person.edit', ['person' => $item->id]) }}">
																						{{ $item->name }} {{ $item->lastName }}</a>
																					@else
																						{{ $item->name }} {{ $item->lastName }}
																					@endif
																				</td>
																				<td> {{ $item->cpf }} </td>
																				<td> {{ $item->role }} </td>
																				<td> {{ $item->dateBirth }} </td>


																				<?php $deleteForm = "delete-".$item->id; ?>
																				<td>

																					<button class="btn btn-danger btn-sm btn-circle pop" title="Deseja Excluir o Membro"
																							data-toggle="confirmation" data-placement="top"
																							data-original-title="Deseja Excluir?" data-popout="true" onclick="event.preventDefault()"
																							id="btn-{{ $deleteForm }}">
																						<i class="fa fa-trash"></i>
																						Inativar
																					</button>

																				</td>
																			</tr>
																		@endforeach
																	</tbody>
																</table>
																<br>
																<div class="pull-right" id="pagination">
																	{{ $adults->links() }}
																</div>

																<div class="progress" id="progress-danger" style="display: none;">
																	<div class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar" aria-valuenow="100"
																		 aria-valuemin="0" aria-valuemax="100" style="width: 100%">
																		Excluindo...
																		<span class="sr-only">Excluindo...</span>
																	</div>
																</div>

																<input type="hidden" id="notific8-title">
																<input type="hidden" id="notific8-text">
																<input type="hidden" id="notific8-type" value="danger">

																<a href="javascript:;" class="btn btn-danger" id="notific8" style="display: none;">

																</a>
															</div> <!-- FIM DIV .table-scrollable table-scrollable-borderless -->
														</div> <!-- FIM DIV .portlet-body-config -->
													</div> <!-- FIM DIV .portlet-body form -->
												</div> <!-- FIM DIV .portlet light -->
											</div> <!-- FIM DIV .col-md-12 -->
										</div> <!-- FIM DIV .row -->
									</div> <!-- FIM DIV .page-content-inner -->
								</div> <!-- FIM DIV .container -->
							</div> <!-- FIM DIV .page-content -->
						</div> <!-- FIM DIV .page-content-wrapper -->
					</div> <!-- FIM DIV.page-container -->
				</div> <!-- FIM DIV .page-wrapper-middle -->
			</div> <!-- FIM DIV .page-wrapper-row full-height -->
		</div> <!-- FIM DIV .page-wrapper -->



		<!-- END CONTAINER -->
		@include('includes.footer')
		@include('includes.core-scripts')
		<!-- BEGIN PAGE LEVEL PLUGINS -->
		<script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
		<script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
		<script src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
		<!-- END PAGE LEVEL PLUGINS -->
		<!-- BEGIN PAGE LEVEL SCRIPTS -->
		<script src="assets/pages/scripts/table-datatables-buttons.min.js" type="text/javascript"></script>
		<!-- END PAGE LEVEL SCRIPTS -->
	</body>

</html>
