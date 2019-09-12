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
								<div class="container" id="container-pagination">
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
                                                                            Notícias (Em breve)
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:;">
                                                                            <i class="fa fa-hand-paper-o font-purple"></i>
                                                                            Avisos (Em breve)
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:;">
                                                                            <i class="fa fa-comment-o font-purple"></i>
                                                                            Mensagens (Em breve)
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
                                                                            <input type="radio" name="sendTo" id="evento" value="2">Evento
                                                                        </label>
                                                                        <label class="radio-inline">
                                                                            <input type="radio" name="sendTo" id="grupo" value="3">Grupo
                                                                        </label>
                                                                        <label class="radio-inline">
                                                                            <input type="radio" name="sendTo" id="pessoa" value="4">Pessoa
                                                                        </label>
                                                                        <!--<label class="radio-inline">
                                                                            <input type="radio" name="sendTo" id="admin" value="5" disabled>Admin
                                                                        </label>-->

                                                                        <input type="submit" id="submit-form" hidden>

                                                                    </form>

																	<br><br>

                                                                    <div id="div-events" style="display: none;">
                                                                        <label for="event_id">Eventos</label>
                                                                        <span id="span-feed-event" class="font-red" style="display: none;">Selecione um evento abaixo</span>
                                                                        <select name="event_id" id="event_id" class="form-control">
                                                                            <option value="">Selecione</option>
                                                                            @foreach($events as $event)
                                                                                <option value="{{ $event->id }}">{{ $event->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

																	<div id="div-groups" style="display: none;">
																		<label for="group_id">Grupos</label>
																		<span id="span-feed-group" class="font-red" style="display: none;">Selecione um grupo abaixo</span>
																		<select name="group_id" id="group_id" class="form-control">
																			<option value="">Selecione</option>
																			@foreach($groups as $group)
																				<option value="{{ $group->id }}">{{ $group->name }}</option>
																			@endforeach
																		</select>
																	</div>

                                                                    <div id="div-people" style="display: none;">
                                                                        <label for="person_id">Enviar para:</label>
                                                                        <span id="span-feed-person" class="font-red" style="display: none;">Selecione uma pessoa abaixo</span>
                                                                        <select name="person_id" id="person_id" class="form-control">
                                                                            <option value="">Selecione</option>
                                                                            @foreach($people as $person)
                                                                                <option value="{{ $person->id }}">{{ $person->name }} {{ $person->lastName }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
																	
                                                                    <br><br>
                                                                    <label for="feed-text">Mensagem</label>
                                                                    <span id="span-feed-text" class="font-red" style="display: none;">Digite uma mensagem abaixo</span>
                                                                    <textarea class="form-control" rows="10" type="text" id="feed-text"></textarea>

                                                                    <br>
                                                                    <label for="feed-link">Link (Opcional) </label>
                                                                    <input type="text" id="feed-link" class="form-control">

                                                                    <!--<br>
                                                                    <label for="expires_in">Validade do Feed</label>
                                                                    <select name="expires_in" id="expires_in" class="form-control">
                                                                        <option value="">Selecione</option>
                                                                        <option value="1">1 Dia</option>
                                                                        <option value="2">1 Semana</option>
                                                                        <option value="3">1 Mês</option>
                                                                    </select>-->


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

															@if(!$sessions)
																<p>Não há feeds para o evento selecionado</p>

															@else
																<div class="table-scrollable table-scrollable-borderless table-striped">
																	<table class="table table-hover table-light table-striped">
																		<thead>
																		<tr class="uppercase">
																			<th>Título</th>
																			<th> Texto</th>
																			<th> Opções</th>
																			<th></th>
																		</tr>
																		</thead>
																		<tbody class="hide" id="tbody-search"></tbody>
																		<tbody>
																		@foreach($feeds as $item)
																			<tr id="tr_{{ $item->id }}">

																				<td>{{ $item->title }}</td>
																				<td>{{ $item->text }}</td>

																				<td>
																					{{--<a href="{{ route('event.session.check_in_list', ['id' => $item->id]) }}"
                                                                                       class="btn btn-info btn-sm btn-circle" title="Inscritos">
                                                                                        <i class="fa fa-users"></i>
                                                                                    </a>--}}

																					<button class="btn btn-danger btn-sm btn-circle btn-delete-session"
																							title="Excluir" id="btn-delete-session-{{ $item->id }}">
																						<i class="fa fa-trash"></i>
																					</button>
																				</td>
																			</tr>

																			<input type="hidden" id="short_start_time_{{ $item->id }}"
																				   value="{{ $item->short_start_time}}">
																			<input type="hidden" id="end_time_{{ $item->id }}" value="{{ $item->end_time}}">
																			<input type="hidden" id="max_capacity_{{ $item->id }}" value="{{ $item->max_capacity}}">
																			<input type="hidden" id="description_{{ $item->id }}" value="{{ $item->description}}">
																			<input type="hidden" id="category_{{ $item->id }}" value="{{ $item->tag}}">



																		@endforeach

																		</tbody>
																	</table>
																	<br>
																	<div class="pull-right" id="pagination">
																		{{ $sessions->links() }}
																	</div>

																</div>
														@endif
														<!-- FIM DIV .table-scrollable table-scrollable-borderless -->
														</div> <!-- FIM DIV .portlet-body-config -->

														<div class="pull-right">
                                                            {{ $feeds->links() }}
                                                        </div>
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
