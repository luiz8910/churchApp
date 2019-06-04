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
        <script src="../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
		<link href="assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
		<link href="assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
        <script src="https://code.highcharts.com/highcharts.js"></script>
        {{--<script src="../assets/global/plugins/highcharts/highcharts.js"></script>--}}
        <script src="../assets/pages/scripts/highcharts-exporting.js"></script>
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
										<h1>Relatórios
											<small>Informações Gerais</small>
										</h1>
									</div>
								</div> <!-- FIM DIV .container -->
							</div> <!-- FIM DIV .page-head -->

                            <!-- Modal -->
                            <div class="modal fade" id="modalChooseEvent" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">

                                        <form action="{{ route('report.index') }}" method="POST">

                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title text-center" id="myModalLabel">Escolha o Evento</h4>
                                            </div>

                                            <div class="modal-body">

                                                    <label for="chooseEvent" class="form-control-label">Escolha o Evento</label>

                                                    <select name="event_id" id="chooseEvent" class="form-control select2" required>
                                                        <option value="" selected>Selecione</option>

                                                        @foreach($events as $event)

                                                            <option value="{{ $event->id }}">{{ $event->name }}</option>

                                                        @endforeach
                                                    </select>

                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                                    <i class="fa fa-close"></i>
                                                    Fechar
                                                </button>
                                                <button type="submit" class="btn btn-success" id="btnChooseEvent">
                                                    <i class="fa fa-check"></i>
                                                    Ir
                                                </button>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>

                            <div class="page-content">
                                <div class="container">
                                    <div class="page-content-inner">
                                        <div class="row">

                                            <div class="col-md-12 ">
                                                <!-- BEGIN TAB PORTLET-->
                                                <div class="portlet light ">
                                                    <div class="portlet-title">
                                                        <div class="caption">
                                                            <i class="fa fa-calendar font-green-sharp"></i>
                                                            <span class="caption-subject font-green-sharp bold uppercase">Eventos</span>
                                                        </div>
                                                        <div class="actions">
                                                            <div class="btn-group">
                                                                <a class="btn green-haze btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Opções
                                                                    <i class="fa fa-angle-down"></i>
                                                                </a>
                                                                <ul class="dropdown-menu pull-right" >
                                                                    <li>
                                                                        <a href="javascript:;" data-toggle="modal" data-target="#modalChooseEvent" >
                                                                            <i class="fa fa-calendar font-green-sharp"></i>
                                                                            Escolher Evento
                                                                        </a>
                                                                    </li>
                                                                    {{--<li class="divider"> </li>
                                                                    <li>
                                                                        <a href="javascript:;">Option 2</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:;">Option 3</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:;">Option 4</a>
                                                                    </li>--}}
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body">
                                                        {{--<p> Basic exemple. Resize the window to see how the tabs are moved into the dropdown </p>--}}
                                                        <div class="tabbable tabbable-tabdrop">
                                                            <ul class="nav nav-tabs">
                                                                <li class="active">
                                                                    <a href="#tab0" data-toggle="tab">Inscritos por Dia</a>
                                                                </li>
                                                                <li class="">
                                                                    <a href="#tab1" data-toggle="tab">Frequência</a>
                                                                </li>
                                                                {{--<li>
                                                                    <a href="#tab2" data-toggle="tab">Faixa Etária</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#tab3" data-toggle="tab">Frequência por membro</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#tab6" data-toggle="tab">Section 6</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#tab7" data-toggle="tab">Section 7</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#tab8" data-toggle="tab">Section 8</a>
                                                                </li>--}}
                                                            </ul>
                                                            <div class="tab-content">
                                                                <div class="tab-pane active" id="tab0">

                                                                    <br>
                                                                    @include('reports.sub_day')
                                                                </div>

                                                                <div class="tab-pane" id="tab1">
                                                                    <p> &nbsp; </p>
                                                                    <p> &nbsp; </p>

                                                                    @include('includes.noEvent')

                                                                    <div id="container" class="hidden-xs hidden-sm chart" style="min-width: 1100px !important; height: 500px !important;"></div>
                                                                    <div id="container-app" class="hidden-lg hidden-md chart"></div>
                                                                </div>
                                                                <div class="tab-pane" id="tab2">
                                                                    <p> &nbsp; </p>
                                                                    <p> &nbsp; </p>

                                                                    @include('includes.noEvent')

                                                                    <div id="container-age-range" class="hidden-xs hidden-sm chart" style="min-width: 1100px !important; height: 500px !important;"></div>
                                                                    <div id="container-age-range-app" class="hidden-lg hidden-md chart" ></div>
                                                                </div>

                                                                <div class="tab-pane" id="tab3">
                                                                    <p> &nbsp; </p>
                                                                    <p> &nbsp; </p>

                                                                    @include('includes.noEvent')


                                                                    <button class="btn btn-info pull-right" id="btn-member" style="display: none;">
                                                                        <i class="fa fa-user"></i>
                                                                            Escolher outro membro
                                                                    </button>

                                                                    <p>&nbsp;</p>

                                                                    <form action="#" id="form-member">
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="members">Escolha o Membro</label>
                                                                                    <select name="members" id="members" class="form-control select2" required>
                                                                                        <option value="">Selecione um membro</option>
                                                                                        @foreach($members as $member)
                                                                                            <option value="{{ $member->id }}">{{ $member->name }} {{ $member->lastName }}</option>
                                                                                        @endforeach
                                                                                    </select>

                                                                                </div>

                                                                            </div>

                                                                            <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                    <br>
                                                                                    <button type="submit" class="btn btn-success" id="btn-form-member"  style="margin-top: 5px;">
                                                                                        <i class="fa fa-check"></i> Ir
                                                                                    </button>

                                                                                    <button id="btn-fake" class="btn btn-success" style="display: none; margin-top: 5px;">
                                                                                        <i class="fa fa-refresh fa-spin fa-fw"></i>
                                                                                    </button>

                                                                                </div>

                                                                            </div>
                                                                        </div>


                                                                    </form>


                                                                    <div id="container-member-frequency" class="hidden-xs hidden-sm chart" style="min-width: 1100px !important; height: 500px !important; display: none;"></div>
                                                                    <div id="container-member-frequency-app" class="hidden-lg hidden-md chart" style="display: none;"></div>
                                                                </div>

                                                                {{--<div class="tab-pane" id="tab6">
                                                                    <p> Howdy, I'm in Section 6. </p>
                                                                </div>
                                                                <div class="tab-pane" id="tab7">
                                                                    <p> Howdy, I'm in Section 7. </p>
                                                                </div>
                                                                <div class="tab-pane" id="tab8">
                                                                    <p> Howdy, I'm in Section 8. </p>
                                                                </div>
                                                                <div class="tab-pane" id="tab9">
                                                                    <p> Howdy, I'm in Section 9. </p>
                                                                </div>--}}
                                                            </div>
                                                        </div>
                                                        <p> &nbsp; </p>
                                                        <p> &nbsp; </p>

                                                    </div>
                                                </div>
                                                <!-- END TAB PORTLET-->

                                            </div>


                                        </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
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
		<script src="../assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/highstock/js/highstock.js" type="text/javascript"></script>
        <script src="../assets/pages/scripts/charts-highstock.min.js" type="text/javascript"></script>
        <script src="../js/chart.js"></script>
		<!-- END PAGE LEVEL SCRIPTS -->
	</body>

</html>
