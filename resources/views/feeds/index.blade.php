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
																<a role="button" class="btn btn-outline purple btn-circle" href="javascript:;" style="margin-top: 2px;" data-toggle="dropdown">
																	<i class="fa fa-rss"></i>
																	Novo Feed
																	<i class="fa fa-angle-down"></i>
																</a>
                                                                <ul class="dropdown-menu pull-right" id="sample_3_tools">
                                                                    <li>
                                                                        <a href="javascript:;" data-toggle="modal" data-target="#newFeed">
                                                                            <i class="fa fa-rss font-purple" aria-hidden="true"></i>
                                                                            Feeds
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:;">
                                                                            <i class="fa fa-newspaper-o font-purple" aria-hidden="true"></i>
                                                                            Notícias
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="">
                                                                            <i class="fa fa-hand-paper-o font-purple"></i>
                                                                            Avisos
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="">
                                                                            <i class="fa fa-comment-o font-purple"></i>
                                                                            Mensagens
                                                                        </a>
                                                                    </li>
                                                                </ul>

															</div>


														</div> <!-- FIM DIV .actions -->
													</div> <!-- FIM DIV .portlet-title -->

                                                    <div class="modal fade" tabindex="-1" role="dialog" id="newFeed">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    <h4 class="modal-title">Novo Feed</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>Enviar para:
                                                                        <span id="span-error-feed" class="font-red" style="display: none;">
                                                                            Verifique os erros abaixo
                                                                        </span>
                                                                    </p>
                                                                    <form id="formSendTo">
                                                                        <label class="radio-inline">
                                                                            <input type="radio" name="sendTo" id="publico" value="1">Publico
                                                                        </label>
                                                                        <label class="radio-inline">
                                                                            <input type="radio" name="sendTo" id="evento" value="2" disabled>Evento
                                                                        </label>
                                                                        <label class="radio-inline">
                                                                            <input type="radio" name="sendTo" id="grupo" value="3" disabled>Grupo
                                                                        </label>
                                                                        <label class="radio-inline">
                                                                            <input type="radio" name="sendTo" id="pessoa" value="4" disabled>Pessoa
                                                                        </label>
                                                                        <label class="radio-inline">
                                                                            <input type="radio" name="sendTo" id="admin" value="5" disabled>Admin
                                                                        </label>

                                                                        <input type="submit" id="submit-form" hidden>

                                                                    </form>
                                                                    <br><br>
                                                                    <label for="feed-text">Mensagem</label>
                                                                    <span id="span-feed-text" class="font-red" style="display: none;">Digite uma mensagem abaixo</span>
                                                                    <textarea class="form-control" rows="10" type="text" id="feed-text"></textarea>

                                                                    <br>
                                                                    <label for="feed-link">Link (Opcional) </label>
                                                                    <input type="text" id="feed-link" class="form-control">

                                                                    <br>
                                                                    <label for="expires_in">Validade do Feed</label>
                                                                    <select name="expires_in" id="expires_in">
                                                                        <option value="">Selecione</option>
                                                                        <option value="1">1 Dia</option>
                                                                        <option value="2">1 Semana</option>
                                                                        <option value="3">1 Mês</option>
                                                                    </select>


                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                                                        <i class="fa fa-close"></i>
                                                                        Fechar
                                                                    </button>
                                                                    <button type="button" class="btn btn-success" onclick="newFeed()">
                                                                        <i class="fa fa-check"></i>
                                                                        Enviar
                                                                    </button>
                                                                </div>
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->

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
																		@foreach($feeds as $feed)
																			<li class="mt-list-item">
																				<div class="list-icon-container done">
																					<a href="javascript:;">
																						<i class="fa fa-eye"></i>
																					</a>
																				</div>
																				<div class="list-datetime"> {{ $feed->data }} </div>
																				<div class="list-item-content">
																					<h3 class="uppercase bold">
																						<a href="@if(isset($feed->link )) {{ $feed->link }}
                                                                                                @else javascript:; @endif
																						">{{ $feed->model }}</a>
																					</h3>
																					<p>{{ $feed->text }}</p>
																				</div>
																			</li>
																		@endforeach
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
