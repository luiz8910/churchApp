<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
	<!-- BEGIN HEAD -->

	<head>
		@include('includes.head')
	</head>
	<!-- END HEAD -->

	<body class="page-container-bg-solid page-boxed">
		<div class="page-wrapper">
			<div class="page-wrapper-row">
				<div class="page-wrapper-top">
					<!-- BEGIN HEADER -->
						@include('includes.header-admin')
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
										<h1>Admin
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
															<span class="caption-subject font-green-haze bold"> Edições do Site</span>
														</div> <!-- FIM DIV .caption.font-green-haze -->
													</div> <!-- FIM DIV .portlet-title -->

													<div class="portlet-body form">
														<div class="portlet-body-config">
															<ul class="nav nav-tabs">
                                                                <li role="presentation" class="active">
                                                                    <a href="#tab-main" aria-controls="tab-main" role="tab" data-toggle="tab" class="hide-a">
                                                                        Principal
                                                                    </a>
                                                                </li>
																<li role="presentation">
																	<a href="#tab-about" aria-controls="tab-about" role="tab" data-toggle="tab" class="hide-a">
																		Sobre
																	</a>
																</li>

                                                                <li role="presentation">
                                                                    <a href="#tab-about-item" aria-controls="tab-about-item" role="tab" data-toggle="tab" class="hide-a">
                                                                        Sobre (Itens)
                                                                    </a>
                                                                </li>
															</ul>

															<div class="tab-content">
																<div class="table-scrollable table-scrollable-borderless tab-pane fade in active" role="tabpanel" id="tab-main">
																	<table class="table table-hover table-light">
																		<thead>
																			<tr class="uppercase">
																				<th> Título </th>
																				<th> Subtítulo </th>
                                                                                <th>Opções</th>
																			</tr>
																		</thead>

                                                                        <tr>
                                                                            <td>{{ $main->text_1 }}</td>
                                                                            <td>{{ $main->text_2 }}</td>
                                                                            <td>
                                                                                <a href="javascript:;" class="btn blue btn-circle btn-outline" id="btn-main">
                                                                                    <i class="fa fa-pencil"></i>
                                                                                    Editar
                                                                                </a>
                                                                            </td>
                                                                        </tr>

																	</table>
																</div>

																<div class="table-scrollable table-scrollable-borderless tab-pane fade in" role="tabpanel" id="tab-about">
                                                                    <table class="table table-hover table-light">
                                                                        <thead>
                                                                        <tr class="uppercase">
                                                                            <th> Título </th>
                                                                            <th> Subtítulo </th>
                                                                            <th></th>
                                                                        </tr>
                                                                        </thead>

                                                                        <tr>
                                                                            <td>{{ $about->text_1 }}</td>
                                                                            <td>{{ $about->text_2 }}</td>
                                                                            <td>
                                                                                <a href="javascript:;" class="btn blue btn-circle btn-outline" id="btn-about">
                                                                                    <i class="fa fa-pencil"></i>
                                                                                    Editar
                                                                                </a>
                                                                            </td>
                                                                        </tr>

                                                                    </table>

                                                                </div>

                                                                <div class="table-scrollable table-scrollable-borderless tab-pane fade in" role="tabpanel" id="tab-about-item">
                                                                    <table class="table table-hover table-light">
                                                                        <thead>
                                                                        <tr class="uppercase">
                                                                            <th> Título </th>
                                                                            <th> Subtítulo </th>
                                                                            <th> <a href="javascript:;" class="btn blue btn-circle btn-outline" id="btn-about-item">
                                                                                    <i class="fa fa-pencil"></i>
                                                                                    Editar
                                                                                </a> </th>
                                                                        </tr>
                                                                        </thead>

                                                                        @foreach($about_item as $item)
                                                                            <tr>
                                                                                <td>{{ $item->title }}</td>
                                                                                <td>{{ $item->text }}</td>
                                                                            </tr>
                                                                        @endforeach

                                                                    </table>

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

                                <div class="container"  >
                                    <div id="edit-main" style="display: none;" class="page-content-inner hide-container">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="portlet light ">
                                                    <div class="portlet-title">
                                                        <div class="caption font-purple">
                                                            <i class="icon-settings font-purple"></i>
                                                            <span class="caption-subject bold uppercase"> Principal </span>
                                                        </div>

                                                    </div>
                                                    <div class="portlet-body form">
                                                        <form role="form" id="form-main" method="post">
                                                            <div class="form-body">
                                                                <div class="form-group">
                                                                    <label>Título</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">
                                                                            <i class="fa fa-font font-purple"></i>
                                                                        </span>
                                                                        <input type="text" class="form-control" id="title-main" name="title-main" value="{{ $main->text_1 }}"
                                                                               placeholder="Digite o título" required>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label>Subtítulo</label>
                                                                    <textarea class="form-control" rows="3" id="subTitle-main" name="subTitle-main"
                                                                              required >{{ $main->text_2 }}</textarea>
                                                                </div>

                                                            </div>
                                                            <div class="form-actions">
                                                                <button type="submit" class="btn purple">
                                                                    <i class="fa fa-check"></i>
                                                                    Salvar
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div> <!-- FIM DIV .col-md-12 -->
                                        </div> <!-- FIM DIV .row -->
                                    </div> <!-- FIM DIV .page-content-inner -->
                                </div>

                                <div class="container" >
                                    <div id="edit-about" style="display: none;" class="page-content-inner hide-container">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="portlet light ">
                                                    <div class="portlet-title">
                                                        <div class="caption font-purple">
                                                            <i class="icon-settings font-purple"></i>
                                                            <span class="caption-subject bold uppercase"> Sobre </span>
                                                        </div>

                                                    </div>
                                                    <div class="portlet-body form">
                                                        <form role="form" id="form-about" method="post">
                                                            <div class="form-body">
                                                                <div class="form-group">
                                                                    <label>Título</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">
                                                                            <i class="fa fa-font font-purple"></i>
                                                                        </span>
                                                                        <input type="text" class="form-control" id="title-main" name="title-about" value="{{ $about->text_1 }}"
                                                                               placeholder="Digite o título" required>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label>Subtítulo</label>
                                                                    <textarea class="form-control" rows="3" id="subTitle-about" name="subTitle-main"
                                                                              required >{{ $about->text_2 }}</textarea>
                                                                </div>

                                                            </div>
                                                            <div class="form-actions">
                                                                <button type="submit" class="btn purple">
                                                                    <i class="fa fa-check"></i>
                                                                    Salvar
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div> <!-- FIM DIV .col-md-12 -->
                                        </div> <!-- FIM DIV .row -->
                                    </div> <!-- FIM DIV .page-content-inner -->
                                </div>

                                <div class="container" >
                                    <div id="edit-about-item" style="display: none;" class="page-content-inner hide-container">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="portlet light ">
                                                    <div class="portlet-title">
                                                        <div class="caption font-purple">
                                                            <i class="icon-settings font-purple"></i>
                                                            <span class="caption-subject bold uppercase"> Sobre (Itens) </span>
                                                        </div>

                                                    </div>
                                                    <div class="portlet-body form">
                                                        <form role="form" id="form-about-item" method="post">
                                                            <div class="form-body">
                                                                @foreach($about_item as $item)
                                                                    <div class="form-group">
                                                                        <label>Título</label>
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-font font-purple"></i>
                                                                            </span>
                                                                            <input type="text" class="form-control" name="title-about-item" value="{{ $item->title }}"
                                                                                   placeholder="Digite o título" required>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label>Subtítulo</label>
                                                                        <textarea class="form-control" rows="3" name="subTitle-main"
                                                                                  required >{{ $item->text }}</textarea>
                                                                    </div>

                                                                @endforeach

                                                            </div>
                                                            <div class="form-actions">
                                                                <button type="submit" class="btn purple">
                                                                    <i class="fa fa-check"></i>
                                                                    Salvar
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div> <!-- FIM DIV .col-md-12 -->
                                        </div> <!-- FIM DIV .row -->
                                    </div> <!-- FIM DIV .page-content-inner -->
                                </div>

                                <div class="container">
                                    <div id="edit-features" style="display: none;" class="page-content-inner hide-container">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="portlet light ">
                                                    <div class="portlet-title">
                                                        <div class="caption font-purple">
                                                            <i class="icon-settings font-purple"></i>
                                                            <span class="caption-subject bold uppercase"> Principal </span>
                                                        </div>

                                                    </div>
                                                    <div class="portlet-body form">
                                                        <form role="form" id="form-main" method="post">
                                                            <div class="form-body">
                                                                <div class="form-group">
                                                                    <label>Título</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">
                                                                            <i class="fa fa-font font-purple"></i>
                                                                        </span>
                                                                        <input type="text" class="form-control" id="title-main" name="title-main" value="{{ $main->text_1 }}"
                                                                               placeholder="Digite o título" required>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label>Subtítulo</label>
                                                                    <textarea class="form-control" rows="3" id="subTitle-main" name="subTitle-main"
                                                                              required >{{ $main->text_2 }}</textarea>
                                                                </div>

                                                            </div>
                                                            <div class="form-actions">
                                                                <button type="submit" class="btn purple">
                                                                    <i class="fa fa-check"></i>
                                                                    Salvar
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div> <!-- FIM DIV .col-md-12 -->
                                        </div> <!-- FIM DIV .row -->
                                    </div> <!-- FIM DIV .page-content-inner -->
                                </div>
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
        <script src="../js/site.js"></script>
		<!-- BEGIN PAGE LEVEL PLUGINS -->


	</body>

</html>
