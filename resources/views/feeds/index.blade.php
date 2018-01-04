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
										<h1>Feeds
											<small>Todos</small>
										</h1>
									</div>
								</div> <!-- FIM DIV .container -->
							</div> <!-- FIM DIV .page-head -->

							<div class="page-content">
								<div class="container">
									<div class="alert alert-danger alert-dismissible" id="delete-group-alert" role="alert" style="display: none;">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
										<strong>Atenção </strong><span id="message"></span>
									</div>

									<div class="page-content-inner">
										<div class="row">
											<div class="col-md-12">
												<div class="portlet light portlet-fit">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-rss font-green"></i>
															<span class="caption-subject font-green bold uppercase">Feeds</span>
															<div class="caption-desc font-grey-cascade">
                                                                Exibindo todos os Feeds por ordem cronológica
                                                            </div>
														</div>
														<div class="actions">

															<div class="btn-group btn-group-devided">
																<a role="button" class="btn btn-info btn-circle" href="javascript:;" style="margin-top: 2px;">
																	<i class="fa fa-rss"></i>
																	Novo Feed
																</a>

															</div>


														</div> <!-- FIM DIV .actions -->
													</div> <!-- FIM DIV .portlet-title -->

													<div class="portlet-body form">
														<div class="portlet-body-config">
															<div class="mt-element-list">
																<div class="mt-list-head list-default green-haze">
																	<div class="row">
																		<div class="col-xs-8">
																			<div class="list-head-title-container">
																				<h5 class="list-title sbold">Lista de Feeds</h5>
																				<div class="list-date">Clique no olho para desabilitar o feed</div>
																			</div>
																		</div>
																		<div class="col-xs-4">
																			<div class="list-head-summary-container">
																				<div class="list-pending">
																					<div class="badge badge-default list-count">3</div>
																					<div class="list-label">Hoje</div>
																				</div>
																				<div class="list-done">
																					<div class="list-count badge badge-default last">20</div>
																					<div class="list-label">Mês</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
																<div class="mt-list-container list-default">

																	<ul>
																		<li class="mt-list-item">
																			<div class="list-icon-container done">
																				<a href="javascript:;">
																					<i class="fa fa-eye"></i>
																				</a>
																			</div>
																			<div class="list-datetime"> 03 Jan </div>
																			<div class="list-item-content">
																				<h3 class="uppercase bold">
																					<a href="javascript:;">Concept Proof</a>
																				</h3>
																				<p>Lorem ipsum dolor sit amet</p>
																			</div>
																		</li>
																		<li class="mt-list-item">
																			<div class="list-icon-container">
																				<a href="javascript:;">
																					<i class="fa fa-eye-slash"></i>
																				</a>
																			</div>
																			<div class="list-datetime"> 03 Jan</div>
																			<div class="list-item-content">
																				<h3 class="uppercase bold">
																					<a href="javascript:;">Listings Feature</a>
																				</h3>
																				<p>Lorem ipsum dolor sit amet</p>
																			</div>
																		</li>
																	</ul>
																</div>
															</div>
														</div> <!-- FIM DIV .portlet-body-config -->
													</div> <!-- FIM DIV .portlet-body.form -->
												</div> <!-- FIM DIV .portlet.light -->
											</div> <!-- FIM DIV .col-md-12 -->
										</div> <!-- FIM DIV .row -->
									</div> <!-- FIM DIV.page-content-inner -->
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
