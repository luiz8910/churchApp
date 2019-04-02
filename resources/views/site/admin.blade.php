<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
	<!-- BEGIN HEAD -->

	<head>
		@include('includes.head')
        <link href="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
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
                                    @if(Session::has("img.success"))
                                        <div class="alert alert-success alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <strong>Sucesso!</strong> {{ Session::get("img.success") }}
                                        </div>
                                    @endif

                                    @if(Session::has("img.error"))
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <strong>Erro!</strong> {{ Session::get("img.error") }}
                                        </div>
                                    @endif

                                        <div class="col-lg-3" style="display: none;">
                                            <form action="{{ url('/new-icons') }}" method="post" enctype="multipart/form-data">
                                                <input type="file" name="file[]" multiple>

                                                <button type="submit" class="btn btn-primary">Upload</button>
                                            </form>


                                        </div>
									<div class="page-content-inner">
										<div class="row">
											<div class="col-md-12">
												<div class="portlet light ">
													<div class="portlet-title">
														<div class="caption font-green-haze">
															<i class="icon-bar-chart font-green-haze"></i>
															<span class="caption-subject font-green-haze bold"> Edições do Site</span>

														</div> <!-- FIM DIV .caption.font-green-haze -->

                                                        <div class="actions">

                                                            <div class="btn-group btn-group-sm">
                                                                <div class="col-lg-6">
                                                                    <div class="btn-group-devided">
                                                                        <a role="button" class="btn purple btn-circle btn-sm" data-toggle="modal" data-target="#new-faq"
                                                                           href="javascript:;" style="margin-top: 2px;">
                                                                            <i class="fa fa-plus"></i>
                                                                            <span class="hidden-xs hidden-sm">Novo FAQ</span>
                                                                            <span class="hidden-md hidden-lg">FAQ</span>
                                                                        </a>
                                                                    </div>
                                                                </div>


                                                                <div class="col-lg-6">
                                                                    <div class="btn-group-devided">
                                                                        <a role="button" class="btn btn-info btn-circle btn-sm" data-toggle="modal" data-target="#new-icon"
                                                                           href="javascript:;" style="margin-top: 2px;">
                                                                            <i class="fa fa-plus"></i>
                                                                            <span class="hidden-xs hidden-sm">Novo Ícone</span>
                                                                            <span class="hidden-md hidden-lg">Ícone</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
													</div> <!-- FIM DIV .portlet-title -->

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="new-icon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    <h4 class="modal-title text-center" id="myModalLabel">Upload de ícones</h4>
                                                                </div>
                                                                <form action="{{ url('/new-icon') }}" method="POST" enctype="multipart/form-data">
                                                                    <div class="modal-body">

                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group text-center">
                                                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                                                            <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=ícone" alt="" /> </div>
                                                                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                                                                        <div>
                                                                                            <span class="btn default btn-file">
                                                                                                <span class="fileinput-new"> Escolher Imagem </span>
                                                                                                <span class="fileinput-exists"> Alterar </span>
                                                                                                <input type="file" name="img"> </span>
                                                                                            <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remover </a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                                        <button type="submit" class="btn btn-success">
                                                                            <i class="fa fa-check"></i>
                                                                            Upload
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="new-faq" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    <h4 class="modal-title text-center" id="myModalLabel">Novo Faq</h4>
                                                                </div>
                                                                <form id="form-new-faq" method="POST" >
                                                                    <div class="modal-body">

                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label for="question-faq">Pergunta</label>
                                                                                    <input type="text" class="form-control" id="question-faq" name="question-faq"
                                                                                           required placeholder="Digite a pergunta">
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label for="answer-faq">Resposta</label>
                                                                                    <input type="text" class="form-control" id="answer-faq" name="answer-faq"
                                                                                           required placeholder="Digite a resposta">
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                                        <button type="submit" class="btn btn-success">
                                                                            <i class="fa fa-check"></i>
                                                                            Salvar
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

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

                                                                <li role="presentation">
                                                                    <a href="#tab-faq" aria-controls="tab-faq" role="tab" data-toggle="tab" class="hide-a">
                                                                        FAQ
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
                                                                            <td>{{ $main->text_1 or null}}</td>
                                                                            <td>{{ $main->text_2 or null}}</td>
                                                                            <td>
                                                                                @if($main)
                                                                                    <a href="javascript:;" class="btn blue btn-circle btn-outline" id="btn-main">
                                                                                        <i class="fa fa-pencil"></i>
                                                                                        Editar
                                                                                    </a>
                                                                                @endif
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
                                                                            <td>{{ $about->text_1 or null }}</td>
                                                                            <td>{{ $about->text_2 or null }}</td>
                                                                            <td>
                                                                                @if($about)
                                                                                    <a href="javascript:;" class="btn blue btn-circle btn-outline" id="btn-about">
                                                                                        <i class="fa fa-pencil"></i>
                                                                                        Editar
                                                                                    </a>
                                                                                @endif
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
                                                                            <th>
                                                                                @if($about_item)
                                                                                    <a href="javascript:;" class="btn blue btn-circle btn-outline" id="btn-about-item">
                                                                                        <i class="fa fa-pencil"></i>
                                                                                        Editar
                                                                                    </a>
                                                                                @endif
                                                                            </th>
                                                                        </tr>
                                                                        </thead>

                                                                        @if($about_item)
                                                                            @foreach($about_item as $item)
                                                                                <tr>
                                                                                    <td>{{ $item->title }}</td>
                                                                                    <td>{{ $item->text }}</td>
                                                                                </tr>
                                                                            @endforeach
                                                                        @endif
                                                                    </table>

                                                                </div>

                                                                <div class="table-scrollable table-scrollable-borderless tab-pane fade in" role="tabpanel" id="tab-faq">
                                                                    <table class="table table-hover table-light">
                                                                        <thead>
                                                                        <tr class="uppercase">
                                                                            <th> Pergunta </th>
                                                                            <th> Resposta </th>
                                                                            <th>Opções</th>
                                                                        </tr>
                                                                        </thead>

                                                                        @if($faq)
                                                                            @foreach($faq as $f)
                                                                                <tr id="tr-faq-{{ $f->id }}">
                                                                                    <td>{{ $f->question }}</td>
                                                                                    <td>
                                                                                        @if(strlen($f->answer) > 50)
                                                                                            <?php $str = substr($f->answer, 0, 50) . " ..."; ?>
                                                                                            {{ $str }}
                                                                                        @else
                                                                                            {{ $f->answer }}
                                                                                        @endif
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="javascript:;" class="btn blue btn-circle btn-outline btn-faq" id="btn-faq-{{ $f->id }}">
                                                                                            <i class="fa fa-pencil"></i>
                                                                                            Editar
                                                                                        </a>
                                                                                        <a href="javascript:;" class="btn red btn-circle btn-outline delete-faq" id="delete-faq-{{ $f->id }}">
                                                                                            <i class="fa fa-trash"></i>
                                                                                            Excluir
                                                                                        </a>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        @endif
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

                                @include('includes.container-main')

                                @include('includes.container-about')

                                @include('includes.container-about-itens')

                                @include('includes.container-faq')


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
        <script src="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
		<!-- BEGIN PAGE LEVEL PLUGINS -->


	</body>

</html>
