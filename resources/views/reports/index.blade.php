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
        <script src="../assets/global/plugins/highcharts/highcharts.js"></script>
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
                                                                <ul class="dropdown-menu pull-right">
                                                                    <li>
                                                                        <a href="javascript:;"> Option 1</a>
                                                                    </li>
                                                                    <li class="divider"> </li>
                                                                    <li>
                                                                        <a href="javascript:;">Option 2</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:;">Option 3</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:;">Option 4</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body">
                                                        {{--<p> Basic exemple. Resize the window to see how the tabs are moved into the dropdown </p>--}}
                                                        <div class="tabbable tabbable-tabdrop">
                                                            <ul class="nav nav-tabs">
                                                                <li class="active">
                                                                    <a href="#tab1" data-toggle="tab">Último Evento</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#tab2" data-toggle="tab">Section 2</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#tab3" data-toggle="tab">Section 3</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#tab4" data-toggle="tab">Section 4</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#tab5" data-toggle="tab">Section 5</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#tab6" data-toggle="tab">Section 6</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#tab7" data-toggle="tab">Section 7</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#tab8" data-toggle="tab">Section 8</a>
                                                                </li>
                                                            </ul>
                                                            <div class="tab-content">
                                                                <div class="tab-pane active" id="tab1">
                                                                    <p> &nbsp; </p>
                                                                    <p> &nbsp; </p>

                                                                    <div id="container" defer></div>
                                                                </div>
                                                                <div class="tab-pane" id="tab2">
                                                                    <p> Howdy, I'm in Section 2. </p>
                                                                </div>
                                                                <div class="tab-pane" id="tab3">
                                                                    <p> Howdy, I'm in Section 3. </p>
                                                                </div>
                                                                <div class="tab-pane" id="tab4">
                                                                    <p> Howdy, I'm in Section 4. </p>
                                                                </div>
                                                                <div class="tab-pane" id="tab5">
                                                                    <p> Howdy, I'm in Section 5. </p>
                                                                </div>
                                                                <div class="tab-pane" id="tab6">
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
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <p> &nbsp; </p>
                                                        <p> &nbsp; </p>

                                                    </div>
                                                </div>
                                                <!-- END TAB PORTLET-->
                                                <!-- BEGIN TAB PORTLET-->
                                                <div class="portlet light ">
                                                    <div class="portlet-title tabbable-line">
                                                        <div class="caption">
                                                            <i class="icon-share font-dark"></i>
                                                            <span class="caption-subject font-dark bold uppercase">Eventos</span>
                                                        </div>
                                                        <ul class="nav nav-tabs">
                                                            <li>
                                                                <a href="#portlet_tab3" data-toggle="tab"> Tab 3 </a>
                                                            </li>
                                                            <li>
                                                                <a href="#portlet_tab2" data-toggle="tab"> Tab 2 </a>
                                                            </li>
                                                            <li class="active">
                                                                <a href="#portlet_tab1" data-toggle="tab"> Último Evento </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="portlet-body">
                                                        <div class="tab-content">
                                                            <div class="tab-pane active" id="portlet_tab1">
                                                                <div id="container-2"></div>
                                                            </div>
                                                            <div class="tab-pane" id="portlet_tab2">
                                                                <p> Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo
                                                                    duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod
                                                                    tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo. </p>
                                                                <p>
                                                                    <a class="btn red" href="ui_tabs_accordions_navs.html#portlet_tab2" target="_blank"> Activate this tab via URL </a>
                                                                </p>
                                                            </div>
                                                            <div class="tab-pane" id="portlet_tab3">
                                                                <p> Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit
                                                                    esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te
                                                                    feugait nulla facilisi. </p>
                                                                <p>
                                                                    <a class="btn blue" href="ui_tabs_accordions_navs.html#portlet_tab3" target="_blank"> Activate this tab via URL </a>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- END TAB PORTLET-->

                                                <div class="portlet box blue">
                                                    <div class="portlet-title">
                                                        <div class="caption">
                                                            <i class="fa fa-gift"></i>Eventos </div>
                                                        <div class="tools">
                                                            <a href="javascript:;" class="collapse"> </a>
                                                            <a href="#portlet-config" data-toggle="modal" class="config"> </a>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body">
                                                        <div class="tabbable-custom nav-justified">
                                                            <ul class="nav nav-tabs nav-justified">
                                                                <li class="active">
                                                                    <a href="#tab_1_1_1" data-toggle="tab"> Último Evento </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#tab_1_1_2" data-toggle="tab"> Section 2 </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#tab_1_1_3" data-toggle="tab"> Section 3 </a>
                                                                </li>
                                                            </ul>
                                                            <div class="tab-content">
                                                                <div class="tab-pane active" id="tab_1_1_1">
                                                                    <div id="container-3"></div>
                                                                </div>
                                                                <div class="tab-pane" id="tab_1_1_2">
                                                                    <p> Howdy, I'm in Section 2. </p>
                                                                    <p> Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate
                                                                        velit esse molestie consequat. Ut wisi enim ad minim veniam, quis nostrud exerci tation. </p>
                                                                    <p>
                                                                        <a class="btn green" href="ui_tabs_accordions_navs.html#tab_1_1_2" target="_blank"> Activate this tab via URL </a>
                                                                    </p>
                                                                </div>
                                                                <div class="tab-pane" id="tab_1_1_3">
                                                                    <p> Howdy, I'm in Section 3. </p>
                                                                    <p> Duis autem vel eum iriure dolor in hendrerit in vulputate. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.
                                                                        Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat </p>
                                                                    <p>
                                                                        <a class="btn yellow" href="ui_tabs_accordions_navs.html#tab_1_1_3" target="_blank"> Activate this tab via URL </a>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                                        {{--<div id="container"></div>--}}


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
        <script src="../js/chart.js"></script>
		<!-- END PAGE LEVEL SCRIPTS -->
	</body>

</html>
