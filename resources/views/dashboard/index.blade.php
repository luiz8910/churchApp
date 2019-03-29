<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
	<!-- BEGIN HEAD -->

	<head>
		@include('includes.head')
		<link rel="stylesheet" href="../css/calendar.css">
	</head>
	<!-- END HEAD -->

	<body class="page-container-bg-solid page-boxed">
		<div class="page-wrapper">
			<div class="page-wrapper-row">
				<div class="page-wrapper-top">
					<!-- BEGIN HEADER -->
						@include('includes.header')
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
										<h1>Dashboard
											<small>Configurações Gerais</small>
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
															<i class="icon-bar-chart font-green-haze"></i>
															<span class="caption-subject font-green-haze bold"> Atividades Recentes</span>
														</div> <!-- FIM DIV .caption.font-green-haze -->
													</div> <!-- FIM DIV .portlet-title -->

													<div class="portlet-body form">
														<div class="portlet-body-config">
															<ul class="nav nav-tabs">
																<li role="presentation" class="active">
																	<a href="#tab-users" aria-controls="tab-users" role="tab" data-toggle="tab">
																		Usuários @if($qtde_users > 0) ({{ $qtde_users }}) @endif
																	</a>
																</li>
																<li role="presentation">
																	<a href="#tab-groups" aria-controls="tab-groups" role="tab" data-toggle="tab">
																		Grupos @if($qtde_groups > 0) ({{ $qtde_groups }}) @endif
																	</a>
																</li>
																<li role="presentation">
																	<a href="#tab-events" aria-controls="tab-events" role="tab" data-toggle="tab">
																		Eventos @if($qtde_events > 0) ({{ $qtde_events }}) @endif
																	</a>
																</li>
															</ul>

															<div class="tab-content">
																<div class="table-scrollable table-scrollable-borderless tab-pane fade in active" role="tabpanel" id="tab-users">
																	<table class="table table-hover table-light">
																		<thead>
																			<tr class="uppercase">
																				<th colspan="2"> Membro </th>
																				<th> Email </th>
																				<th> Telefone </th>
																				<th> Cargo </th>
																			</tr>
																		</thead>

																		@if($qtde_users > 0)
																			@foreach($people as $person)
																				<tr>
																					<td class="fit">
																						@if($person->user)
																							<img class="user-pic rounded" src="{{ $person->imgProfile }}" style="max-width: 30px;">
																						@else
																							<img class="user-pic rounded" src="../{{ $person->imgProfile }}" style="max-width: 30px;">
																						@endif
																					</td>
																					<td>
																						@if(Auth::user()->person->id == $person->id)
																							{{ $person->name }}
																						@else
																							@if($person->tag == "adult")
																								<a href="{{ route('person.edit', ['person' => $person->id]) }}"
																								   class="primary-link">{{ $person->name }}
																								</a>
																							@else
																								<a href="{{ route('teen.edit', ['person' => $person->id]) }}"
																								   class="primary-link">{{ $person->name }}
																								</a>
																							@endif
																						@endif
																					</td>
																					<td> {{ $person->user->email or null }} </td>
																					<td> {{ $person->tel }} </td>
																					<td>
																						<span class="bold theme-font">{{ $person->role_id }}</span>
																					</td>
																				</tr>
																			@endforeach
																		@endif
																	</table>

																	@if($qtde_users == 0)
																		<p class="empty_table">Não há novos Usuários</p>
																	@endif
																</div>

																<div class="table-scrollable table-scrollable-borderless tab-pane fade in" role="tabpanel" id="tab-groups">
																	<table class="table table-hover table-light">
																		<thead>
																			<tr class="uppercase">
																				<th colspan="2"> Nome </th>
																				<th> Criado Por </th>
																				<th> Criado Em </th>
																			</tr>
																		</thead>

																		@if($qtde_groups > 0)
																			@foreach($groups_recent as $item)
																				<tr>
																					<td class="fit">
																						<img class="user-pic rounded" src="../{{ $item->imgProfile }}"> </td>
																					<td>
																						<a href="{{ route('group.edit', ['group' => $item->id]) }}" class="primary-link">
																							{{ $item->name }}
																						</a>
																					</td>
																					<td class="">
																						<img class="user-pic rounded" src="../{{ $item->imgCreatorProfile }}">
																						{{ $item->owner_id }}
																					</td>

																					<td> {{ $item->sinceOf }} </td>
																				</tr>
																			@endforeach

																		@endif
																	</table>

																	@if($qtde_groups == 0)
																		<p class="empty_table">Não há novos grupos</p>
																	@endif
																</div>

																<div class="table-scrollable table-scrollable-borderless tab-pane fade in" role="tabpanel" id="tab-events">
																	<table class="table table-hover table-light">
																		<thead>
																			<tr class="uppercase">
																				<th> Evento </th>
																				<th> Frequência </th>
																				<th> Nome </th>
																				<th> Grupo </th>
																				<th> Data </th>
																			</tr>
																		</thead>

																		@if($qtde_events > 0)

																			@foreach($events_recent as $item)
																				<tr>
																					<td>
																						<a href="{{ route('event.edit', ['event' => $item->id]) }}"
																						   class="primary-link">
																							{{ $item->name }}
																						</a>
																					</td>
																					<td> {{ $item->frequency }} </td>
																					<td> {{ $item->createdBy_id }} </td>
																					<td>
																						<span class="bold theme-font">{{ $item->group_id }}</span>
																					</td>
																					<td>
																						{{ $item->nextEvent }}
																					</td>
																				</tr>
																			@endforeach
																		@endif
																	</table>

																	@if($qtde_events == 0)
																		<p class="empty_table">Não há novos Eventos</p>
																	@endif
																</div>
															</div> <!-- FIM DIV .tab-content -->
														</div>  <!-- FIM DIV .form-body -->

														<!-- <div class="form-actions ">
															<button type="button" class="btn blue">Enviar</button>
															<button type="button" class="btn default">Cancel</button>
														</div> -->
													</div> <!-- FIM DIV .portlet-body.form  -->
												</div> <!-- FIM DIV .portlet.light -->
											</div> <!-- FIM DIV .col-md-12 -->
										</div> <!-- FIM DIV .row -->
									</div> <!-- FIM DIV .page-content-inner -->
								</div>

								<!-- BOX 2 -->

								<div class="container">
									<div class="page-content-inner">
										<div class="row">
											<div class="col-md-12">
												<div class="portlet light ">
													<div class="portlet-title">
														<div class="caption font-green-haze">
															<i class="fa fa-users font-green-haze"></i>
															<span class="caption-subject font-green-haze bold"> Meus Grupos</span>
														</div> <!-- FIM DIV .caption.font-green-haze -->
														<div class="actions">
															<div class="btn-group btn-group-devided">
																	<a role="button" class="btn btn-info btn-circle" href="{{ route('group.create') }}" style="margin-top: 2px;">
																		<i class="fa fa-plus"></i>
																		<span class="hidden-xs hidden-sm">Novo Grupo</span>
																	</a>

																</div>
																<div class="btn-group">
																	<a class="btn red btn-outline btn-circle" href="javascript:;" data-toggle="dropdown">
																		<i class="fa fa-share"></i>
																		<span class="hidden-xs"> Opções </span>
																		<i class="fa fa-angle-down"></i>
																	</a>
																	<ul class="dropdown-menu pull-right" id="sample_3_tools">
																		<li>
																			<a href="javascript:;" data-action="0" class="tool-action">
																				<i class="icon-printer"></i> Imprimir</a>
																		</li>
																		<li>
																			<a href="javascript:;" data-action="1" class="tool-action">
																				<i class="icon-check"></i> Copiar</a>
																		</li>
																		<li>
																			<a href="javascript:;" data-action="2" class="tool-action">
																				<i class="icon-doc"></i> PDF</a>
																		</li>
																		<li>
																			<a href="javascript:;" data-action="3" class="tool-action">
																				<i class="icon-paper-clip"></i> Excel</a>
																		</li>
																		<li>
																			<a href="javascript:;" data-action="4" class="tool-action">
																				<i class="icon-cloud-upload"></i> CSV</a>
																		</li>
																	</ul>
																</div>
														</div> <!-- FIM DIV .actions -->
													</div> <!-- FIM DIV .portlet-title -->

													<div class="portlet-body form">
														<div class="portlet-body-config">
															<div class="table-scrollable table-scrollable-borderless">
																<table class="table table-hover table-light">
																	<thead>
																		<tr class="uppercase">
																			<th> Foto </th>
																			<th> Nome </th>
																			<th class="hidden-xs hidden-sm"> Inicio em </th>
																			<th> Participantes </th>
																			<th> Opções </th>
																		</tr>
																	</thead>
																	<input type="hidden" id="person_id" value="{{ Auth::getUser()->person_id }}">

																	<tbody>
																		@if($groups)
																			<?php $i = 0; ?>
																			@foreach($groups as $item)
																				<tr>
																					<td> <img src="{{ $item->imgProfile }}" style="width: 50px; height: 50px;"> </td>
																					<td> <a href="{{ route('group.edit', ['group' => $item->id]) }}"> {{ $item->name }}</a></td>
																					<td class="hidden-xs hidden-sm"> {{ $item->sinceOf }} </td>
																					<td class="text-center hidden-md hidden-lg">
																						<span class="badge badge-info">{{ $countMembers[$i] }}</span>
																					</td>
																					<td class="hidden-sm hidden-xs">
																						<span class="badge badge-info">
																							{{ $countMembers[$i] }}
																						</span>
																					</td>

																					@if(Auth::getUser()->person)


																						<?php $deleteForm = "delete-" . $item->id; ?>
																						<td>

																							<a href="" class="btn btn-danger btn-sm btn-circle pop-leave-group"
																							   title="Excluir membro do grupo"
																							   data-toggle="confirmation" data-placement="top" data-original-title="Deseja Excluir?"
																							   data-popout="true" onclick="event.preventDefault()"
																							   id="btn-{{ $deleteForm }}">
																								<i class="fa fa-trash"></i>
																							</a>


																						</td>

																					@endif

																				</tr>
																				<?php $i++; ?>
																			@endforeach

																		@endif
																	</tbody>
																</table>
																<br>
																<div class="pull-right">
																	@if($groups) {{ $groups->links() }} @endif
																</div>
															</div>
														</div>  <!-- FIM DIV .form-body -->
													</div> <!-- FIM DIV .portlet-body.form  -->
												</div> <!-- FIM DIV .portlet.light -->
											</div> <!-- FIM DIV .col-md-12 -->
										</div> <!-- FIM DIV .row -->
									</div> <!-- FIM DIV .page-content-inner -->
								</div> <!-- FIM DIV .container -->

								<!-- BOX 3 -->

								<div class="container">
									<div class="page-content-inner">
										<div class="row">
											<div class="col-md-12">
												<div class="portlet light ">
													<div class="portlet-title">
														<div class="caption font-green-haze">
															<i class="fa fa-calendar font-green-haze"></i>
															<span class="caption-subject font-green-haze bold"> Evento</span>
														</div> <!-- FIM DIV .caption.font-green-haze -->
														<div class="actions">
															<div class="btn-group btn-group-devided">
																<a role="button" class="btn btn-info btn-circle" href="{{ route('event.create') }}" style="margin-top: 2px;">
																	<i class="fa fa-plus"></i>
																	<span class="hidden-xs hidden-sm">Novo Evento</span>
																</a>

															</div>

															<div class="btn-group">
																<a class="btn red btn-outline btn-circle" href="javascript:;" data-toggle="dropdown">
																	<i class="fa fa-share"></i>
																	<span class="hidden-xs"> Opções </span>
																	<i class="fa fa-angle-down"></i>
																</a>
																<ul class="dropdown-menu pull-right" id="sample_3_tools">
                                                                    <li>
                                                                        <a href="javascript:;" class="tool-action" data-toggle="modal" data-target="#newSub">
                                                                            <i class="fa fa-check font-purple"></i>
                                                                            Nova Inscrição

                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:;" class="tool-action" data-toggle="modal" data-target="#modalCheck-in">
                                                                            <i class="fa fa-calendar-check-o font-purple"></i>
                                                                            Check-in de Inscritos
                                                                        </a>
                                                                    </li>

                                                                    <li class="divider"></li>

																	<li>
																		<a href="javascript:;" data-action="0" class="tool-action">
																			<i class="icon-printer font-purple"></i> Imprimir</a>
																	</li>
																	<li>
																		<a href="javascript:;" data-action="1" class="tool-action">
																			<i class="icon-check font-purple"></i> Copiar</a>
																	</li>
																	<li>
																		<a href="javascript:;" data-action="2" class="tool-action">
																			<i class="icon-doc font-purple"></i> PDF</a>
																	</li>
																	<li>
																		<a href="javascript:;" data-action="3" class="tool-action">
																			<i class="icon-paper-clip font-purple"></i> Excel</a>
																	</li>
																	<li>
																		<a href="javascript:;" data-action="4" class="tool-action">
																			<i class="icon-cloud-upload font-purple"></i> CSV</a>
																	</li>
																</ul>
															</div>
														</div> <!-- FIM DIV .actions -->
													</div> <!-- FIM DIV .portlet-title -->

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="newSub" role="dialog" aria-labelledby="myModalLabel">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    <h4 class="modal-title text-center" id="myModalLabel">Nova Inscrição</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <label for="select_event_id">Escolha o evento</label>
                                                                    <select name="select_event_id" id="select_event_id" class="form-control select2">
                                                                        <option value="">Selecione</option>
																		@if(isset($events_to_sub))
																			@foreach($events_to_sub as $item)
																				<option value="{{ $item->id }}">{{ $item->name }}</option>
																			@endforeach
																		@endif
                                                                    </select>

                                                                    <br>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="div-loading text-center" id="div-loading" style="display: none;">
                                                                                <i class="fa fa-refresh fa-spin fa-4x fa-fw"
                                                                                   id="icon-loading-people">
                                                                                </i>
                                                                                <p class="text-center" id="p-loading-people" style="display: block;">
                                                                                    Buscando Pessoas ...
                                                                                </p>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <br>



                                                                    <form action="#" class="" id="form-people" style="display: none;" onsubmit="event.preventDefault();">
																		<div class="form-group">
                                                                            <label for="sub_people">Pessoas</label>
                                                                            <select class="form-control select2-multiple" id="sub_people"
                                                                                    name="sub_people" multiple>
                                                                                <optgroup label="Membros" id="opt-group">
                                                                                    <!-- <option> serão gerados dinamicamente -->
                                                                                </optgroup>

                                                                                <optgroup label="Visitantes" id="opt-group-visitor">
                                                                                    <!-- <option> serão gerados dinamicamente -->
                                                                                </optgroup>

                                                                            </select>

																		</div>

																	</form>

																</div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                                                        <i class="fa fa-close"></i>
                                                                        Fechar
                                                                    </button>
                                                                    <button type="button" class="btn btn-success" id="submit-form-people" disabled>
                                                                        <i class="fa fa-check"></i>
                                                                        Salvar
                                                                    </button>
                                                                </div>
															</div>
														</div>
													</div>

													<div class="modal fade" id="modalCheck-in" role="dialog" aria-labelledby="myModalLabel">
														<div class="modal-dialog" role="document">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																	<h4 class="modal-title text-center" id="myModalLabel">Check-in</h4>
																</div>
																<div class="modal-body">

																	@if(!isset($events_to_check))
																		<?php $events_to_check = 0; ?>
																	@endif

																		@if(sizeof($events_to_check) == 0 || $events_to_check == 0)
																			<p class="text-center">Não há eventos disponíveis para check-in</p>

																		@else
																			<label for="select_event_id_check">Escolha o evento</label>
																			<select name="select_event_id_check" id="select_event_id_check" class="form-control select2">
																				<option value="">Selecione</option>
																				@foreach($events_to_check as $item)
																					<option value="{{ $item->id }}">{{ $item->name }}</option>
																				@endforeach
																			</select>
																		@endif



																	<br>
																	<div class="row">
																		<div class="col-md-12">
																			<div class="div-loading text-center" id="div-loading-check" style="display: none;">
																				<i class="fa fa-refresh fa-spin fa-4x fa-fw"
																				   id="icon-loading-people">
																				</i>
																				<p class="text-center" id="p-loading-people-check" style="display: block;">
																					Buscando Pessoas ...
																				</p>
																			</div>

																		</div>
																	</div>
																	<br>



																	<form action="#" class="" id="form-people-check" style="display: none;" onsubmit="event.preventDefault();">
																		<div class="form-group">
																			<label for="people_check">
                                                                                Pessoas
                                                                            </label>
																			<select class="form-control select2-multiple" id="people_check"
																					name="people_check" multiple>
																				<optgroup label="Membros" id="opt-group-check">
                                                                                    <!-- <option> serão gerados dinamicamente -->
																				</optgroup>

																				<optgroup label="Visitantes" id="opt-group-check-visitor">
                                                                                    <!-- <option> serão gerados dinamicamente -->
																				</optgroup>

																			</select>

																		</div>

                                                                        <span class="badge badge-primary badge-roundless" id="span-select-all" style="display: none;"> Todos Selecionados </span>

                                                                        <br><br>

                                                                        <!-- Check-in de todos os inscritos no evento selecionado -->
                                                                        <fieldset id="fieldset-check" style="display: none;">
                                                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                                                <input type="checkbox" name="check-all" class="checkboxes check-model" id="check-all"
                                                                                       value="" />
                                                                                <span></span>
                                                                            </label>
                                                                            Check-in para todos os inscritos
                                                                        </fieldset>

																	</form>

																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-default" data-dismiss="modal">
																		<i class="fa fa-close"></i>
																		Fechar
																	</button>
																	<button type="button" class="btn btn-success" id="submit-form-people-check" disabled>
																		<i class="fa fa-check"></i>
																		Salvar
																	</button>
																</div>
															</div>
														</div>
													</div>

													<div class="portlet-body form">
														<div class="portlet-body-config">
															<div class="table-scrollable table-scrollable-borderless">
																<table class="table table-hover table-light">
																	<thead>
																	<tr class="uppercase">
																		<th> Evento </th>
																		<th> Data </th>
																		<th> Grupo </th>
                                                                        <th> Ações </th>

																	</tr>
																	</thead>

																	<input type="hidden" id="person_id" value="{{ Auth::getUser()->person_id }}">

																	<tbody>
																	@if($events)
																		<?php $i = 0; ?>
																		@foreach($event_person as $item)
																			<tr>
																				<td> <a href="{{ route('event.edit', ['event' => $item->id]) }}"> {{ $item->name }}</a></td>
																				<td>
																					@if(isset($eventDate[$i]->eventDate))
																						{{ $eventDate[$i]->eventDate }}
																					@endif
																				</td>
																				<td>
																					@if(isset($item->group_name))
																						<a href="{{ route('group.edit', ['group' => $item->group_id]) }}">
																							{{ $item->group_name }}
																						</a>
																					@else
																						Sem Grupo
																					@endif
																				</td>
																				<td>

																					@if(array_key_exists($item->id, $event_list))
																						@if($event_list[$item->id])
																							@if($is_sub[$item->id])
																								<a href="javascript:;"
																								   class="btn btn-danger btn-circle change-size"
																								   style="margin-right: 10px;"
																								   id="checkIn" onclick='checkOut({{ Auth::getUser()->person->id }})'>
																									<i class="fa fa-close" id="i-checkIn"></i>
																									Check-Out
																								</a>
																							@else
																							<a type="button" class="btn btn-success btn-circle change-size"
																							   style="margin-right: 10px;"
																							   id="checkIn"
																							   onclick='checkInEvent({{ Auth::getUser()->person->id }}, "person")'>
																								<i class="fa fa-check" id="i-checkIn"></i>
																								Check-In
																							</a>
																							@endif
																						@else
																							<a type="button" class="btn btn-success btn-circle change-size"
																							   style="margin-right: 10px;"
																							   id="checkIn" disabled>
																								<i class="fa fa-check" id="i-checkIn"></i>
																								Check-In
																							</a>
																						@endif
																					@endif


                                                                                </td>

																			</tr>
																			<?php $i++; ?>
																		@endforeach

																	@endif
																	</tbody>
																</table>
																<br>
																<div class="pull-right">
																	{{ $events->links() }}
																</div>
															</div>	<!-- FIM DIV .table-scrollable -->
														</div>  <!-- FIM DIV .form-body -->

														<!-- <div class="form-actions ">
															<button type="button" class="btn blue">Enviar</button>
															<button type="button" class="btn default">Cancel</button>
														</div> -->
													</div> <!-- FIM DIV .portlet-body.form  -->
												</div> <!-- FIM DIV .portlet.light -->
											</div> <!-- FIM DIV .col-md-12 -->
										</div> <!-- FIM DIV .row -->
									</div> <!-- FIM DIV .page-content-inner -->
								</div> <!-- FIM DIV .container -->

								<!-- BOX 4 -->

								<div class="container">
									<div class="page-content-inner">
										<div class="row">
											<div class="col-md-12">

													@include('includes.calendar')

											</div> <!-- FIM DIV .col-md-12 -->
										</div> <!-- FIM DIV .row -->
									</div> <!-- FIM DIV .page-content-inner -->
								</div> <!-- FIM DIV .container -->

								<div class="container">
									<div class="page-content-inner">
										<div class="row">
											<div class="col-md-12">
												<div class="portlet light ">
													<div class="portlet-title">
														<div class="caption font-green-haze">
															<i class="icon-settings font-green-haze"></i>
															<span class="caption-subject font-green-haze bold ">
																@if(!$nextEvent[0])
																	Você não está inscrito em nenhum evento
																@else
																	Próximo Evento - dia {{ $nextEvent[1] }} - {{ $event->name }}
																@endif
															</span>
														</div> <!-- FIM DIV .caption.font-green-haze -->
														<div class="actions">

														</div> <!-- FIM DIV .actions -->
													</div> <!-- FIM DIV .portlet-title -->

													<div class="portlet-body form">
														<div id="map" style="height: 320px; width: 100%;"></div>
														<input type="hidden" value="{{ $location }}" id="location">
														<input type="hidden" value="{{ $street }}" id="streetMap">
													</div>  <!-- FIM DIV .form-body -->

														<!-- <div class="form-actions ">
															<button type="button" class="btn blue">Enviar</button>
															<button type="button" class="btn default">Cancel</button>
														</div> -->
												</div> <!-- FIM DIV .portlet-body.form  -->
											</div> <!-- FIM DIV .col-md-6 -->


										</div> <!-- FIM DIV .row -->

										<div class="row">
											<div class="col-md-12 col-sm-12">
												<!-- BEGIN PORTLET-->
												<div class="portlet light ">
													<div class="portlet-title tabbable-line">
														<div class="caption">
															<i class="icon-globe font-green-sharp"></i>
															<span class="caption-subject font-green-sharp bold">Feeds</span>
														</div>
														<ul class="nav nav-tabs">
															<li class="active">
																<a href="#tab_1_1" class="active" data-toggle="tab"> Geral </a>
															</li>
															<li>
																<a href="#tab_1_2" data-toggle="tab"> Outros </a>
															</li>
														</ul>
													</div>
													<div class="portlet-body">
														<!--BEGIN TABS-->
														<div class="tab-content">
															<div class="tab-pane active" id="tab_1_1">
																<div class="scroller" style="height: 339px;" data-always-visible="1" data-rail-visible="0">
																	<ul class="feeds">
																		@if($feeds)
																			@foreach($feeds as $feed)
																				<li>
																					<a href="@if(isset($feed->link)) {{ $feed->link }}
																					@else javascript:;
                                                                                    @endif
																							">
																						<div class="col1">
																							<div class="cont">
																								<div class="cont-col1">
																									<div class="label label-sm label-success">
																										<i class="fa fa-bell-o"></i>
																									</div>
																								</div>
																								<div class="cont-col2">
																									<div class="desc">
																										{{ $feed->text }}
																									</div>
																								</div>
																							</div>
																						</div>
																						<div class="col2">
																							<div class="date"> {{ $feed->data }}</div>
																						</div>
																					</a>
																				</li>
																			@endforeach
																		@endif
																		<li>
																			<a href="javascript:;">
																				<div class="col1">
																					<div class="cont">
																						<div class="cont-col1">
																							<div class="label label-sm label-success">
																								<i class="fa fa-bell-o"></i>
																							</div>
																						</div>
																						<div class="cont-col2">
																							<div class="desc"> Pedido de oração anônimo: "Ore por minha família nessa semana" </div>
																						</div>
																					</div>
																				</div>
																				<div class="col2">
																					<div class="date"> 20 min </div>
																				</div>
																			</a>
																		</li>
																		<li>
																			<div class="col1">
																				<div class="cont">
																					<div class="cont-col1">
																						<div class="label label-sm label-danger">
																							<i class="fa fa-bolt"></i>
																						</div>
																					</div>
																					<div class="cont-col2">
																						<div class="desc">
																							Teremos almoço comunitário nesse domingo. Não deixe de levar seu prato e aproveitar o tempo com os irmãos.
																						</div>
																					</div>
																				</div>
																			</div>
																			<div class="col2">
																				<div class="date"> 24 min </div>
																			</div>
																		</li>
																		<li>
																			<div class="col1">
																				<div class="cont">
																					<div class="cont-col1">
																						<div class="label label-sm label-info">
																							<i class="fa fa-bullhorn"></i>
																						</div>
																					</div>
																					<div class="cont-col2">
																						<div class="desc"> Pedido de oração por Alberto Fiochi : "Ore pelo Brasil!" </div>
																					</div>
																				</div>
																			</div>
																			<div class="col2">
																				<div class="date"> 30 min </div>
																			</div>
																		</li>
																		<li>
																			<div class="col1">
																				<div class="cont">
																					<div class="cont-col1">
																						<div class="label label-sm label-success">
																							<i class="fa fa-bullhorn"></i>
																						</div>
																					</div>
																					<div class="cont-col2">
																						<div class="desc">
																							<a href="page_user_profile_1.html">
																								Novo usuário registrado : "João da Silva"
																							</a>
																						</div>
																					</div>
																				</div>
																			</div>
																			<div class="col2">
																				<div class="date"> 40 min </div>
																			</div>
																		</li>
																		<li>
																			<div class="col1">
																				<div class="cont">
																					<div class="cont-col1">
																						<div class="label label-sm label-warning">
																							<i class="fa fa-plus"></i>
																						</div>
																					</div>
																					<div class="cont-col2">
																						<div class="desc"> Acampamento de Jovens em 04/2017 - Inscreva-se já! </div>
																					</div>
																				</div>
																			</div>
																			<div class="col2">
																				<div class="date"> 2 dias </div>
																			</div>
																		</li>
																	</ul>
																</div>
															</div>
															<div class="tab-pane" id="tab_1_2">
																<div class="scroller" style="height: 290px;" data-always-visible="1" data-rail-visible1="1">
																	<ul class="feeds">
																		<li>
																			<a href="javascript:;">
																				<div class="col1">
																					<div class="cont">
																						<div class="cont-col1">
																							<div class="label label-sm label-success">
																								<i class="fa fa-bell-o"></i>
																							</div>
																						</div>
																						<div class="cont-col2">
																							<div class="desc"> New user registered </div>
																						</div>
																					</div>
																				</div>
																				<div class="col2">
																					<div class="date"> Just now </div>
																				</div>
																			</a>
																		</li>
																		<li>
																			<a href="javascript:;">
																				<div class="col1">
																					<div class="cont">
																						<div class="cont-col1">
																							<div class="label label-sm label-success">
																								<i class="fa fa-bell-o"></i>
																							</div>
																						</div>
																						<div class="cont-col2">
																							<div class="desc"> New order received </div>
																						</div>
																					</div>
																				</div>
																				<div class="col2">
																					<div class="date"> 10 mins </div>
																				</div>
																			</a>
																		</li>
																		<li>
																			<div class="col1">
																				<div class="cont">
																					<div class="cont-col1">
																						<div class="label label-sm label-danger">
																							<i class="fa fa-bolt"></i>
																						</div>
																					</div>
																					<div class="cont-col2">
																						<div class="desc"> Order #24DOP4 has been rejected.
																							<span class="label label-sm label-danger "> Take action
																										<i class="fa fa-share"></i>
																									</span>
																						</div>
																					</div>
																				</div>
																			</div>
																			<div class="col2">
																				<div class="date"> 24 mins </div>
																			</div>
																		</li>
																		<li>
																			<a href="javascript:;">
																				<div class="col1">
																					<div class="cont">
																						<div class="cont-col1">
																							<div class="label label-sm label-success">
																								<i class="fa fa-bell-o"></i>
																							</div>
																						</div>
																						<div class="cont-col2">
																							<div class="desc"> New user registered </div>
																						</div>
																					</div>
																				</div>
																				<div class="col2">
																					<div class="date"> Just now </div>
																				</div>
																			</a>
																		</li>
																		<li>
																			<a href="javascript:;">
																				<div class="col1">
																					<div class="cont">
																						<div class="cont-col1">
																							<div class="label label-sm label-success">
																								<i class="fa fa-bell-o"></i>
																							</div>
																						</div>
																						<div class="cont-col2">
																							<div class="desc"> New user registered </div>
																						</div>
																					</div>
																				</div>
																				<div class="col2">
																					<div class="date"> Just now </div>
																				</div>
																			</a>
																		</li>
																		<li>
																			<a href="javascript:;">
																				<div class="col1">
																					<div class="cont">
																						<div class="cont-col1">
																							<div class="label label-sm label-success">
																								<i class="fa fa-bell-o"></i>
																							</div>
																						</div>
																						<div class="cont-col2">
																							<div class="desc"> New user registered </div>
																						</div>
																					</div>
																				</div>
																				<div class="col2">
																					<div class="date"> Just now </div>
																				</div>
																			</a>
																		</li>
																		<li>
																			<a href="javascript:;">
																				<div class="col1">
																					<div class="cont">
																						<div class="cont-col1">
																							<div class="label label-sm label-success">
																								<i class="fa fa-bell-o"></i>
																							</div>
																						</div>
																						<div class="cont-col2">
																							<div class="desc"> New user registered </div>
																						</div>
																					</div>
																				</div>
																				<div class="col2">
																					<div class="date"> Just now </div>
																				</div>
																			</a>
																		</li>
																		<li>
																			<a href="javascript:;">
																				<div class="col1">
																					<div class="cont">
																						<div class="cont-col1">
																							<div class="label label-sm label-success">
																								<i class="fa fa-bell-o"></i>
																							</div>
																						</div>
																						<div class="cont-col2">
																							<div class="desc"> New user registered </div>
																						</div>
																					</div>
																				</div>
																				<div class="col2">
																					<div class="date"> Just now </div>
																				</div>
																			</a>
																		</li>
																		<li>
																			<a href="javascript:;">
																				<div class="col1">
																					<div class="cont">
																						<div class="cont-col1">
																							<div class="label label-sm label-success">
																								<i class="fa fa-bell-o"></i>
																							</div>
																						</div>
																						<div class="cont-col2">
																							<div class="desc"> New user registered </div>
																						</div>
																					</div>
																				</div>
																				<div class="col2">
																					<div class="date"> Just now </div>
																				</div>
																			</a>
																		</li>
																		<li>
																			<a href="javascript:;">
																				<div class="col1">
																					<div class="cont">
																						<div class="cont-col1">
																							<div class="label label-sm label-success">
																								<i class="fa fa-bell-o"></i>
																							</div>
																						</div>
																						<div class="cont-col2">
																							<div class="desc"> New user registered </div>
																						</div>
																					</div>
																				</div>
																				<div class="col2">
																					<div class="date"> Just now </div>
																				</div>
																			</a>
																		</li>
																	</ul>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div> <!-- FIM DIV .page-content-inner -->
								</div> <!-- FIM DIV .container -->

								{{--<div class="container">
									<div class="page-content-inner">
										<div class="row">
											<div class="col-md-12 col-sm-12">
												<div class="portlet light ">
													<div class="portlet-title">
														<div class="caption font-green-haze">
															<i class="icon-bar-chart font-green-haze"></i>
															<span class="caption-subject bold ">Frequência</span>
															<span class="caption-helper">Culto</span>
														</div>
														<div class="actions">
															<a href="#" class="btn btn-circle green btn-outline btn-sm">
																<i class="fa fa-pencil"></i> Exportar </a>
															<a href="#" class="btn btn-circle green btn-outline btn-sm">
																<i class="fa fa-print"></i> Imprimir </a>
														</div>
													</div>
													<div class="portlet-body">
														<div id="chartdiv" style="width: 100%; height: 400px;"></div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!-- END PAGE CONTENT INNER -->
								</div>--}}
							</div>

						</div>
						<!-- END CONTENT -->
					</div>

				</div> <!-- FIM DIV .page-content-wrapper -->
			</div> <!-- FIM DIV .page-container -->
		</div> <!-- FIM DIV .page-wrapper-middle -->



		<!-- END CONTAINER -->
		@include('includes.footer')
		@include('includes.core-scripts')
		<!-- BEGIN PAGE LEVEL PLUGINS -->
		<script src="assets/global/plugins/moment.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/morris/raphael-min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>

		<script src="../js/events.js" type="text/javascript"></script>

		<script src="assets/global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/fullcalendar/lang/pt-br.js" type="text/javascript"></script>
		<script src="assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>

		<script src="assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
		<script src="assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>

		<!--<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>-->
		<script src="../js/agenda.js"></script>

		<script src="../js/maps.js"></script>

		<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjTs0nbQbEecUygnKpThLfzRKES8nKS0A&callback=initMap"></script>


		@include('includes.charts')

		<!-- Am Charts -->
		<script>
			var chartData = [ {
				"country": "11/12",
				"visits": 25
			}, {
				"country": "18/12",
				"visits": 81
			}, {
				"country": "25/12",
				"visits": 73
			}, {
				"country": "01/01",
				"visits": 40
			} ];

			AmCharts.makeChart( "chartdiv", {
				"type": "serial",
				"dataProvider": chartData,
				"categoryField": "country",
				"graphs": [ {
					"valueField": "visits",
					"type": "column",
					"fillAlphas": 0.8,
					"angle": 30,
					"depth3D": 15,
					"balloonText": "[[category]]: <b>[[value]]</b>"
				} ],
				"categoryAxis": {
					"autoGridCount": false,
					"gridCount": chartData.length,
					"gridPosition": "start",
					"title": "Membros x Dias"
				}


			} );
		</script>

		<!-- Google maps function
		<script>
			function initMap() {
				var infowindow = new google.maps.InfoWindow();

				var uluru = {lat: -23.4792232, lng: -47.4554208};
				var map = new google.maps.Map(document.getElementById('map'), {
					zoom: 16,
					center: uluru
				});
				var marker = new google.maps.Marker({
					position: uluru,
					map: map
				});

				google.maps.event.addListener(marker, 'click', (function(marker, i) {
					return function() {
						infowindow.setContent('Igreja Metodista Livre Sorocaba');
						infowindow.open(map, marker);
					}
				})(marker));
			}
		</script>


		<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjTs0nbQbEecUygnKpThLfzRKES8nKS0A&callback=initMap"></script>-->

		<!--<script src="assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
		<script src="assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
		<script src="assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
		<script src="assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
		<script src="assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
		<script src="assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
		<script src="assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>-->
		<script src="assets/apps/scripts/calendar.min.js" type="text/javascript"></script>
		<!-- END PAGE LEVEL PLUGINS -->
		<!-- BEGIN PAGE LEVEL SCRIPTS -->
		<script src="assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>
		<!-- END PAGE LEVEL SCRIPTS -->
		<script src="app.js" type="text/javascript"></script>


		<script>
			function newEvent()
			{
				window.location.href = "/events/create";
			}

			function closeButton()
			{
				$(this).css("display", "none");
			}

			function goToEvent(id)
			{
				window.location.href = "/events/"+id+"/edit";
			}

		</script>
	</body>

</html>
