<!DOCTYPE html>
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.6
Version: 4.5.3
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
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
<!-- BEGIN HEADER -->
@include('includes.header')
<!-- END HEADER -->
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <!-- BEGIN PAGE HEAD-->
        <div class="page-head">
            <div class="container">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1>Adultos
                        <small>membros e etc...</small>
                    </h1>
                </div>
                <!-- END PAGE TITLE -->
                <!-- BEGIN PAGE TOOLBAR -->
                <div class="page-toolbar">
                    <!-- BEGIN THEME PANEL -->
                    <div class="btn-group btn-theme-panel">
                        <a href="javascript:;" class="btn dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-settings"></i>
                        </a>
                        <div class="dropdown-menu theme-panel pull-right dropdown-custom hold-on-click">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <h3>THEME COLORS</h3>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <ul class="theme-colors">
                                                <li class="theme-color theme-color-default" data-theme="default">
                                                    <span class="theme-color-view"></span>
                                                    <span class="theme-color-name">Default</span>
                                                </li>
                                                <li class="theme-color theme-color-blue-hoki" data-theme="blue-hoki">
                                                    <span class="theme-color-view"></span>
                                                    <span class="theme-color-name">Blue Hoki</span>
                                                </li>
                                                <li class="theme-color theme-color-blue-steel" data-theme="blue-steel">
                                                    <span class="theme-color-view"></span>
                                                    <span class="theme-color-name">Blue Steel</span>
                                                </li>
                                                <li class="theme-color theme-color-yellow-orange" data-theme="yellow-orange">
                                                    <span class="theme-color-view"></span>
                                                    <span class="theme-color-name">Orange</span>
                                                </li>
                                                <li class="theme-color theme-color-yellow-crusta" data-theme="yellow-crusta">
                                                    <span class="theme-color-view"></span>
                                                    <span class="theme-color-name">Yellow Crusta</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <ul class="theme-colors">
                                                <li class="theme-color theme-color-green-haze" data-theme="green-haze">
                                                    <span class="theme-color-view"></span>
                                                    <span class="theme-color-name">Green Haze</span>
                                                </li>
                                                <li class="theme-color theme-color-red-sunglo" data-theme="red-sunglo">
                                                    <span class="theme-color-view"></span>
                                                    <span class="theme-color-name">Red Sunglo</span>
                                                </li>
                                                <li class="theme-color theme-color-red-intense" data-theme="red-intense">
                                                    <span class="theme-color-view"></span>
                                                    <span class="theme-color-name">Red Intense</span>
                                                </li>
                                                <li class="theme-color theme-color-purple-plum" data-theme="purple-plum">
                                                    <span class="theme-color-view"></span>
                                                    <span class="theme-color-name">Purple Plum</span>
                                                </li>
                                                <li class="theme-color theme-color-purple-studio" data-theme="purple-studio">
                                                    <span class="theme-color-view"></span>
                                                    <span class="theme-color-name">Purple Studio</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 seperator">
                                    <h3>LAYOUT</h3>
                                    <ul class="theme-settings">
                                        <li> Theme Style
                                            <select class="theme-setting theme-setting-style form-control input-sm input-small input-inline tooltips" data-original-title="Change theme style" data-container="body" data-placement="left">
                                                <option value="boxed" selected="selected">Square corners</option>
                                                <option value="rounded">Rounded corners</option>
                                            </select>
                                        </li>
                                        <li> Layout
                                            <select class="theme-setting theme-setting-layout form-control input-sm input-small input-inline tooltips" data-original-title="Change layout type" data-container="body" data-placement="left">
                                                <option value="boxed" selected="selected">Boxed</option>
                                                <option value="fluid">Fluid</option>
                                            </select>
                                        </li>
                                        <li> Top Menu Style
                                            <select class="theme-setting theme-setting-top-menu-style form-control input-sm input-small input-inline tooltips" data-original-title="Change top menu dropdowns style" data-container="body"
                                                    data-placement="left">
                                                <option value="dark" selected="selected">Dark</option>
                                                <option value="light">Light</option>
                                            </select>
                                        </li>
                                        <li> Top Menu Mode
                                            <select class="theme-setting theme-setting-top-menu-mode form-control input-sm input-small input-inline tooltips" data-original-title="Enable fixed(sticky) top menu" data-container="body" data-placement="left">
                                                <option value="fixed">Fixed</option>
                                                <option value="not-fixed" selected="selected">Not Fixed</option>
                                            </select>
                                        </li>
                                        <li> Mega Menu Style
                                            <select class="theme-setting theme-setting-mega-menu-style form-control input-sm input-small input-inline tooltips" data-original-title="Change mega menu dropdowns style" data-container="body"
                                                    data-placement="left">
                                                <option value="dark" selected="selected">Dark</option>
                                                <option value="light">Light</option>
                                            </select>
                                        </li>
                                        <li> Mega Menu Mode
                                            <select class="theme-setting theme-setting-mega-menu-mode form-control input-sm input-small input-inline tooltips" data-original-title="Enable fixed(sticky) mega menu" data-container="body"
                                                    data-placement="left">
                                                <option value="fixed" selected="selected">Fixed</option>
                                                <option value="not-fixed">Not Fixed</option>
                                            </select>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END THEME PANEL -->
                </div>
                <!-- END PAGE TOOLBAR -->
            </div>
        </div>
        <!-- END PAGE HEAD-->
        <!-- BEGIN PAGE CONTENT BODY -->
        <div class="page-content">
            <div class="container">
                <!-- BEGIN PAGE BREADCRUMBS -->
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <a href="{{ route('index) }}">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">Pessoas</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Adultos</span>
                    </li>
                </ul>
                <!-- END PAGE BREADCRUMBS -->
                <!-- BEGIN PAGE CONTENT INNER -->
                <div class="page-content-inner">
                    <div class="row">
                        <div class="col-md-6 ">
                            <!-- BEGIN SAMPLE FORM PORTLET-->
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption font-red-sunglo">
                                        <i class="icon-settings font-red-sunglo"></i>
                                        <span class="caption-subject bold uppercase"> Default Form</span>
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group">
                                            <a class="btn btn-sm green dropdown-toggle" href="javascript:;" data-toggle="dropdown"> Actions
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-pencil"></i> Edit </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-trash-o"></i> Delete </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-ban"></i> Ban </a>
                                                </li>
                                                <li class="divider"> </li>
                                                <li>
                                                    <a href="javascript:;"> Make admin </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <form role="form">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label>Email Address</label>
                                                <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-envelope"></i>
                                                            </span>
                                                    <input type="text" class="form-control" placeholder="Email Address"> </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Circle Input</label>
                                                <div class="input-group">
                                                            <span class="input-group-addon input-circle-left">
                                                                <i class="fa fa-envelope"></i>
                                                            </span>
                                                    <input type="text" class="form-control input-circle-right" placeholder="Email Address"> </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-user font-red"></i>
                                                            </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Left Icon</label>
                                                <div class="input-icon">
                                                    <i class="fa fa-bell-o font-green"></i>
                                                    <input type="text" class="form-control" placeholder="Left icon"> </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Left Icon(.input-sm)</label>
                                                <div class="input-icon input-icon-sm">
                                                    <i class="fa fa-bell-o"></i>
                                                    <input type="text" class="form-control input-sm" placeholder="Left icon"> </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Left Icon(.input-lg)</label>
                                                <div class="input-icon input-icon-lg">
                                                    <i class="fa fa-bell-o"></i>
                                                    <input type="text" class="form-control input-lg" placeholder="Left icon"> </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Right Icon</label>
                                                <div class="input-icon right">
                                                    <i class="fa fa-microphone fa-spin font-blue"></i>
                                                    <input type="text" class="form-control" placeholder="Right icon"> </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Right Icon(.input-sm)</label>
                                                <div class="input-icon input-icon-sm right">
                                                    <i class="fa fa-bell-o"></i>
                                                    <input type="text" class="form-control input-sm" placeholder="Left icon"> </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Right Icon(.input-lg)</label>
                                                <div class="input-icon input-icon-lg right">
                                                    <i class="fa fa-bell-o font-green"></i>
                                                    <input type="text" class="form-control input-lg" placeholder="Left icon"> </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Circle Input</label>
                                                <div class="input-icon right">
                                                    <i class="fa fa-microphone"></i>
                                                    <input type="text" class="form-control input-circle" placeholder="Right icon"> </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Input with Icon</label>
                                                <div class="input-group input-icon right">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-envelope font-purple"></i>
                                                            </span>
                                                    <i class="fa fa-exclamation tooltips" data-original-title="Invalid email." data-container="body"></i>
                                                    <input id="email" class="input-error form-control" type="text" value=""> </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Input With Spinner</label>
                                                <input class="form-control spinner" type="text" placeholder="Process something" /> </div>
                                            <div class="form-group">
                                                <label>Static Control</label>
                                                <p class="form-control-static"> email@example.com </p>
                                            </div>
                                            <div class="form-group">
                                                <label>Disabled</label>
                                                <input type="text" class="form-control" placeholder="Disabled" disabled> </div>
                                            <div class="form-group">
                                                <label>Readonly</label>
                                                <input type="text" class="form-control" placeholder="Readonly" readonly> </div>
                                            <div class="form-group">
                                                <label>Dropdown</label>
                                                <select class="form-control">
                                                    <option>Option 1</option>
                                                    <option>Option 2</option>
                                                    <option>Option 3</option>
                                                    <option>Option 4</option>
                                                    <option>Option 5</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Multiple Select</label>
                                                <select multiple class="form-control">
                                                    <option>Option 1</option>
                                                    <option>Option 2</option>
                                                    <option>Option 3</option>
                                                    <option>Option 4</option>
                                                    <option>Option 5</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Textarea</label>
                                                <textarea class="form-control" rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputFile1">File input</label>
                                                <input type="file" id="exampleInputFile1">
                                                <p class="help-block"> some help text here. </p>
                                            </div>
                                            <div class="form-group">
                                                <label>Checkboxes</label>
                                                <div class="checkbox-list">
                                                    <label>
                                                        <input type="checkbox"> Checkbox 1 </label>
                                                    <label>
                                                        <input type="checkbox"> Checkbox 2 </label>
                                                    <label>
                                                        <input type="checkbox" disabled> Disabled </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Inline Checkboxes</label>
                                                <div class="checkbox-list">
                                                    <label class="checkbox-inline">
                                                        <input type="checkbox" id="inlineCheckbox1" value="option1"> Checkbox 1 </label>
                                                    <label class="checkbox-inline">
                                                        <input type="checkbox" id="inlineCheckbox2" value="option2"> Checkbox 2 </label>
                                                    <label class="checkbox-inline">
                                                        <input type="checkbox" id="inlineCheckbox3" value="option3" disabled> Disabled </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Radio</label>
                                                <div class="radio-list">
                                                    <label>
                                                        <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked> Option 1</label>
                                                    <label>
                                                        <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2"> Option 2 </label>
                                                    <label>
                                                        <input type="radio" name="optionsRadios" id="optionsRadios3" value="option3" disabled> Disabled </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Inline Radio</label>
                                                <div class="radio-list">
                                                    <label class="radio-inline">
                                                        <input type="radio" name="optionsRadios" id="optionsRadios4" value="option1" checked> Option 1 </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="optionsRadios" id="optionsRadios5" value="option2"> Option 2 </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="optionsRadios" id="optionsRadios6" value="option3" disabled> Disabled </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <button type="submit" class="btn blue">Submit</button>
                                            <button type="button" class="btn default">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- END SAMPLE FORM PORTLET-->
                            <!-- BEGIN SAMPLE FORM PORTLET-->
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-social-dribbble font-blue-sharp"></i>
                                        <span class="caption-subject font-blue-sharp bold uppercase">Input Height Sizing</span>
                                    </div>
                                    <div class="actions">
                                        <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                            <i class="icon-cloud-upload"></i>
                                        </a>
                                        <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                            <i class="icon-wrench"></i>
                                        </a>
                                        <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                            <i class="icon-trash"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <form role="form">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label>Large Input</label>
                                                <input type="text" class="form-control input-lg" placeholder="input-lg"> </div>
                                            <div class="form-group">
                                                <label>Large Input Group</label>
                                                <div class="input-group input-group-lg">
                                                    <span class="input-group-addon" id="sizing-addon1">@</span>
                                                    <input type="text" class="form-control" placeholder="Username" aria-describedby="sizing-addon1"> </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Large Input Default Group</label>
                                                <div class="input-group input-group-lg">
                                                    <input type="text" class="form-control" placeholder="Search for...">
                                                            <span class="input-group-btn">
                                                                <button class="btn green" type="button">Go!</button>
                                                            </span>
                                                </div>
                                                <!-- /input-group -->
                                            </div>
                                            <div class="form-group">
                                                <label>Default Input</label>
                                                <input type="text" class="form-control" placeholder=""> </div>
                                            <div class="form-group">
                                                <label>Default Input Group</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="Username" aria-describedby="sizing-addon1">
                                                    <span class="input-group-addon" id="sizing-addon1">@</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Default Input Button Group</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="Search for...">
                                                            <span class="input-group-btn">
                                                                <button class="btn red" type="button">Go!</button>
                                                            </span>
                                                </div>
                                                <!-- /input-group -->
                                            </div>
                                            <div class="form-group">
                                                <label>Small Input</label>
                                                <input type="text" class="form-control input-sm" placeholder="input-sm"> </div>
                                            <div class="form-group">
                                                <label>Small Input Group</label>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-addon" id="sizing-addon1">@</span>
                                                    <input type="text" class="form-control" placeholder="Username" aria-describedby="sizing-addon1"> </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Small Input Default Group</label>
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control" placeholder="Search for...">
                                                            <span class="input-group-btn">
                                                                <button class="btn green" type="button">Go!</button>
                                                            </span>
                                                </div>
                                                <!-- /input-group -->
                                            </div>
                                            <div class="form-group">
                                                <label>Large Select</label>
                                                <select class="form-control input-lg">
                                                    <option>Option 1</option>
                                                    <option>Option 2</option>
                                                    <option>Option 3</option>
                                                    <option>Option 4</option>
                                                    <option>Option 5</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Default Select</label>
                                                <select class="form-control">
                                                    <option>Option 1</option>
                                                    <option>Option 2</option>
                                                    <option>Option 3</option>
                                                    <option>Option 4</option>
                                                    <option>Option 5</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Small Select</label>
                                                <select class="form-control input-sm">
                                                    <option>Option 1</option>
                                                    <option>Option 2</option>
                                                    <option>Option 3</option>
                                                    <option>Option 4</option>
                                                    <option>Option 5</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-actions right">
                                            <button type="button" class="btn default">Cancel</button>
                                            <button type="submit" class="btn green">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- END SAMPLE FORM PORTLET-->
                            <!-- BEGIN SAMPLE FORM PORTLET-->
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-bubble font-green-sharp"></i>
                                        <span class="caption-subject font-green-sharp bold uppercase">Input Width Sizing</span>
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group">
                                            <a class="btn green-haze btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
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
                                <div class="portlet-body form">
                                    <form role="form">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label>Fluid Input</label>
                                                <input type="text" class="form-control" placeholder="fluid">
                                                <div class="input-icon right margin-top-10">
                                                    <i class="fa fa-check"></i>
                                                    <input type="text" class="form-control" placeholder="fluid"> </div>
                                                <div class="input-icon margin-top-10">
                                                    <i class="fa fa-user"></i>
                                                    <input type="text" class="form-control" placeholder="fluid"> </div>
                                                <div class="input-group margin-top-10">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-envelope"></i>
                                                            </span>
                                                    <input type="email" class="form-control" placeholder=".input-xlarge"> </div>
                                                <div class="input-group margin-top-10">
                                                    <input type="email" class="form-control" placeholder=".input-xlarge">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-envelope"></i>
                                                            </span>
                                                </div>
                                                <hr> </div>
                                            <div class="form-group">
                                                <label>Extra Large Input</label>
                                                <input type="text" class="form-control input-xlarge" placeholder=".input-xlarge">
                                                <div class="input-icon right input-xlarge margin-top-10">
                                                    <i class="fa fa-check"></i>
                                                    <input type="text" class="form-control" placeholder=".input-xlarge"> </div>
                                                <div class="input-icon input-xlarge margin-top-10">
                                                    <i class="fa fa-user"></i>
                                                    <input type="text" class="form-control" placeholder=".input-xlarge"> </div>
                                                <div class="input-group input-xlarge margin-top-10">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-envelope"></i>
                                                            </span>
                                                    <input type="email" class="form-control" placeholder=".input-xlarge"> </div>
                                                <div class="input-group input-xlarge margin-top-10">
                                                    <input type="email" class="form-control" placeholder=".input-xlarge">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-envelope"></i>
                                                            </span>
                                                </div>
                                                <hr> </div>
                                            <div class="form-group">
                                                <label>Large Input</label>
                                                <input type="text" class="form-control input-large" placeholder=".input-large">
                                                <div class="input-icon right input-large margin-top-10">
                                                    <i class="fa fa-check"></i>
                                                    <input type="text" class="form-control" placeholder=".input-large"> </div>
                                                <div class="input-icon input-large margin-top-10">
                                                    <i class="fa fa-user"></i>
                                                    <input type="text" class="form-control" placeholder=".input-large"> </div>
                                                <div class="input-group input-large margin-top-10">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-envelope"></i>
                                                            </span>
                                                    <input type="email" class="form-control" placeholder=".input-large"> </div>
                                                <div class="input-group input-large margin-top-10">
                                                    <input type="email" class="form-control" placeholder=".input-large">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-envelope"></i>
                                                            </span>
                                                </div>
                                                <hr> </div>
                                            <div class="form-group">
                                                <label>Medium Input</label>
                                                <input type="text" class="form-control input-medium" placeholder=".input-medium">
                                                <div class="input-icon right input-medium margin-top-10">
                                                    <i class="fa fa-check"></i>
                                                    <input type="text" class="form-control" placeholder=".input-medium"> </div>
                                                <div class="input-icon input-medium margin-top-10">
                                                    <i class="fa fa-user"></i>
                                                    <input type="text" class="form-control" placeholder=".input-medium"> </div>
                                                <div class="input-group input-medium margin-top-10">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-envelope"></i>
                                                            </span>
                                                    <input type="email" class="form-control" placeholder=".input-medium"> </div>
                                                <div class="input-group input-medium margin-top-10">
                                                    <input type="email" class="form-control" placeholder=".input-medium">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-envelope"></i>
                                                            </span>
                                                </div>
                                                <hr> </div>
                                            <div class="form-group">
                                                <label>Small Input</label>
                                                <input type="text" class="form-control input-small" placeholder=".input-small">
                                                <div class="input-icon right input-small margin-top-10">
                                                    <i class="fa fa-check"></i>
                                                    <input type="text" class="form-control" placeholder=".input-small"> </div>
                                                <div class="input-icon input-small margin-top-10">
                                                    <i class="fa fa-user"></i>
                                                    <input type="text" class="form-control" placeholder=".input-small"> </div>
                                                <div class="input-group input-small margin-top-10">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-envelope"></i>
                                                            </span>
                                                    <input type="email" class="form-control" placeholder=".input-small"> </div>
                                                <div class="input-group input-small margin-top-10">
                                                    <input type="email" class="form-control" placeholder=".input-small">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-envelope"></i>
                                                            </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Extra Small Input</label>
                                                <input type="text" class="form-control input-xsmall" placeholder=".input-xsmall"> </div>
                                            <div class="form-group">
                                                <label>Extra Large Select</label>
                                                <select class="form-control input-xlarge">
                                                    <option>Option 1</option>
                                                    <option>Option 2</option>
                                                    <option>Option 3</option>
                                                    <option>Option 4</option>
                                                    <option>Option 5</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Large Select</label>
                                                <select class="form-control input-large">
                                                    <option>Option 1</option>
                                                    <option>Option 2</option>
                                                    <option>Option 3</option>
                                                    <option>Option 4</option>
                                                    <option>Option 5</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Medium Select</label>
                                                <select class="form-control input-medium">
                                                    <option>Option 1</option>
                                                    <option>Option 2</option>
                                                    <option>Option 3</option>
                                                    <option>Option 4</option>
                                                    <option>Option 5</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Small Select</label>
                                                <select class="form-control input-small">
                                                    <option>Option 1</option>
                                                    <option>Option 2</option>
                                                    <option>Option 3</option>
                                                    <option>Option 4</option>
                                                    <option>Option 5</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Extra Small Select</label>
                                                <select class="form-control input-xsmall">
                                                    <option>Option 1</option>
                                                    <option>Option 2</option>
                                                    <option>Option 3</option>
                                                    <option>Option 4</option>
                                                    <option>Option 5</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-actions right">
                                            <button type="button" class="btn default">Cancel</button>
                                            <button type="submit" class="btn green">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- END SAMPLE FORM PORTLET-->
                        </div>
                        <div class="col-md-6 ">
                            <!-- BEGIN SAMPLE FORM PORTLET-->
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-settings font-dark"></i>
                                        <span class="caption-subject font-dark sbold uppercase">Horizontal Form</span>
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                                            <label class="btn btn-transparent dark btn-outline btn-circle btn-sm active">
                                                <input type="radio" name="options" class="toggle" id="option1">Actions</label>
                                            <label class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                                                <input type="radio" name="options" class="toggle" id="option2">Settings</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <form class="form-horizontal" role="form">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Block Help</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" placeholder="Enter text">
                                                    <span class="help-block"> A block of help text. </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Inline Help</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control input-inline input-medium" placeholder="Enter text">
                                                    <span class="help-inline"> Inline help. </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Input Group</label>
                                                <div class="col-md-9">
                                                    <div class="input-inline input-medium">
                                                        <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-user"></i>
                                                                    </span>
                                                            <input type="email" class="form-control" placeholder="Email Address"> </div>
                                                    </div>
                                                    <span class="help-inline"> Inline help. </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Email Address</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-envelope"></i>
                                                                </span>
                                                        <input type="email" class="form-control" placeholder="Email Address"> </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Password</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" placeholder="Password">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-user"></i>
                                                                </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Left Icon</label>
                                                <div class="col-md-9">
                                                    <div class="input-icon">
                                                        <i class="fa fa-bell-o"></i>
                                                        <input type="text" class="form-control" placeholder="Left icon"> </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Right Icon</label>
                                                <div class="col-md-9">
                                                    <div class="input-icon right">
                                                        <i class="fa fa-microphone"></i>
                                                        <input type="text" class="form-control" placeholder="Right icon"> </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Icon Input in Group Input</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <div class="input-icon">
                                                            <i class="fa fa-lock fa-fw"></i>
                                                            <input id="newpassword" class="form-control" type="text" name="password" placeholder="password" /> </div>
                                                                <span class="input-group-btn">
                                                                    <button id="genpassword" class="btn btn-success" type="button">
                                                                        <i class="fa fa-arrow-left fa-fw" /></i> Random</button>
                                                                </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Input With Spinner</label>
                                                <div class="col-md-9">
                                                    <input type="password" class="form-control spinner" placeholder="Password"> </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Static Control</label>
                                                <div class="col-md-9">
                                                    <p class="form-control-static"> email@example.com </p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Disabled</label>
                                                <div class="col-md-9">
                                                    <input type="password" class="form-control" placeholder="Disabled" disabled> </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Readonly</label>
                                                <div class="col-md-9">
                                                    <input type="password" class="form-control" placeholder="Readonly" readonly> </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Dropdown</label>
                                                <div class="col-md-9">
                                                    <select class="form-control">
                                                        <option>Option 1</option>
                                                        <option>Option 2</option>
                                                        <option>Option 3</option>
                                                        <option>Option 4</option>
                                                        <option>Option 5</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Multiple Select</label>
                                                <div class="col-md-9">
                                                    <select multiple class="form-control">
                                                        <option>Option 1</option>
                                                        <option>Option 2</option>
                                                        <option>Option 3</option>
                                                        <option>Option 4</option>
                                                        <option>Option 5</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Textarea</label>
                                                <div class="col-md-9">
                                                    <textarea class="form-control" rows="3"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputFile" class="col-md-3 control-label">File input</label>
                                                <div class="col-md-9">
                                                    <input type="file" id="exampleInputFile">
                                                    <p class="help-block"> some help text here. </p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Checkboxes</label>
                                                <div class="col-md-9">
                                                    <div class="checkbox-list">
                                                        <label>
                                                            <input type="checkbox"> Checkbox 1 </label>
                                                        <label>
                                                            <input type="checkbox"> Checkbox 1 </label>
                                                        <label>
                                                            <input type="checkbox" disabled> Disabled </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Inline Checkboxes</label>
                                                <div class="col-md-9">
                                                    <div class="checkbox-list">
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" id="inlineCheckbox21" value="option1"> Checkbox 1 </label>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" id="inlineCheckbox22" value="option2"> Checkbox 2 </label>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" id="inlineCheckbox23" value="option3" disabled> Disabled </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Radio</label>
                                                <div class="col-md-9">
                                                    <div class="radio-list">
                                                        <label>
                                                            <input type="radio" name="optionsRadios" id="optionsRadios22" value="option1" checked> Option 1 </label>
                                                        <label>
                                                            <input type="radio" name="optionsRadios" id="optionsRadios23" value="option2" checked> Option 2 </label>
                                                        <label>
                                                            <input type="radio" name="optionsRadios" id="optionsRadios24" value="option2" disabled> Disabled </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Inline Radio</label>
                                                <div class="col-md-9">
                                                    <div class="radio-list">
                                                        <label class="radio-inline">
                                                            <input type="radio" name="optionsRadios" id="optionsRadios25" value="option1" checked> Option 1 </label>
                                                        <label class="radio-inline">
                                                            <input type="radio" name="optionsRadios" id="optionsRadios26" value="option2" checked> Option 2 </label>
                                                        <label class="radio-inline">
                                                            <input type="radio" name="optionsRadios" id="optionsRadios27" value="option3" disabled> Disabled </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button type="submit" class="btn green">Submit</button>
                                                    <button type="button" class="btn default">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- END SAMPLE FORM PORTLET-->
                            <!-- BEGIN SAMPLE FORM PORTLET-->
                            <div class="portlet box purple ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-gift"></i> Horizontal Form Height Sizing </div>
                                    <div class="tools">
                                        <a href="" class="collapse"> </a>
                                        <a href="#portlet-config" data-toggle="modal" class="config"> </a>
                                        <a href="" class="reload"> </a>
                                        <a href="" class="remove"> </a>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <form class="form-horizontal" role="form">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Large Input</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control input-lg" placeholder="Large Input"> </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Default Input</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" placeholder="Default Input"> </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Small Input</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control input-sm" placeholder="Default Input"> </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Large Select</label>
                                                <div class="col-md-9">
                                                    <select class="form-control input-lg">
                                                        <option>Option 1</option>
                                                        <option>Option 2</option>
                                                        <option>Option 3</option>
                                                        <option>Option 4</option>
                                                        <option>Option 5</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Default Select</label>
                                                <div class="col-md-9">
                                                    <select class="form-control">
                                                        <option>Option 1</option>
                                                        <option>Option 2</option>
                                                        <option>Option 3</option>
                                                        <option>Option 4</option>
                                                        <option>Option 5</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Small Select</label>
                                                <div class="col-md-9">
                                                    <select class="form-control input-sm">
                                                        <option>Option 1</option>
                                                        <option>Option 2</option>
                                                        <option>Option 3</option>
                                                        <option>Option 4</option>
                                                        <option>Option 5</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions right1">
                                            <button type="button" class="btn default">Cancel</button>
                                            <button type="submit" class="btn green">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- END SAMPLE FORM PORTLET-->
                            <!-- BEGIN SAMPLE FORM PORTLET-->
                            <div class="portlet box purple ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-gift"></i> Fluid Input Groups </div>
                                    <div class="tools">
                                        <a href="" class="collapse"> </a>
                                        <a href="#portlet-config" data-toggle="modal" class="config"> </a>
                                        <a href="" class="reload"> </a>
                                        <a href="" class="remove"> </a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <h4 class="block">Checkboxe Addons</h4>
                                    <form role="form">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <input type="checkbox"> </span>
                                                    <input type="text" class="form-control"> </div>
                                                <!-- /input-group -->
                                            </div>
                                            <!-- /.col-md-6 -->
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <input type="text" class="form-control">
                                                            <span class="input-group-addon">
                                                                <input type="checkbox"> </span>
                                                </div>
                                                <!-- /input-group -->
                                            </div>
                                            <!-- /.col-md-6 -->
                                        </div>
                                        <!-- /.row -->
                                    </form>
                                    <h4 class="block">Button Addons</h4>
                                    <form role="form">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                            <span class="input-group-btn">
                                                                <button class="btn red" type="button">Go!</button>
                                                            </span>
                                                    <input type="text" class="form-control"> </div>
                                                <!-- /input-group -->
                                            </div>
                                            <!-- /.col-md-6 -->
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <input type="text" class="form-control">
                                                            <span class="input-group-btn">
                                                                <button class="btn blue" type="button">Go!</button>
                                                            </span>
                                                </div>
                                                <!-- /input-group -->
                                            </div>
                                            <!-- /.col-md-6 -->
                                        </div>
                                        <!-- /.row -->
                                    </form>
                                    <h4 class="block">Button Addons On Both Sides</h4>
                                    <form role="form">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                            <span class="input-group-btn">
                                                                <button class="btn red" type="button">Go!</button>
                                                            </span>
                                                    <input type="text" class="form-control">
                                                            <span class="input-group-btn">
                                                                <button class="btn blue" type="button">Go!</button>
                                                            </span>
                                                </div>
                                                <!-- /input-group -->
                                            </div>
                                            <!-- /.col-md-6 -->
                                        </div>
                                    </form>
                                    <h4 class="block">Buttons With Dropdowns</h4>
                                    <form role="form">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn green dropdown-toggle" data-toggle="dropdown">Action
                                                            <i class="fa fa-angle-down"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a href="javascript:;"> Action </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:;"> Another action </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:;"> Something else here </a>
                                                            </li>
                                                            <li class="divider"> </li>
                                                            <li>
                                                                <a href="javascript:;"> Separated link </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- /btn-group -->
                                                    <input type="text" class="form-control"> </div>
                                                <!-- /input-group -->
                                            </div>
                                            <!-- /.col-md-6 -->
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <input type="text" class="form-control">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn yellow dropdown-toggle" data-toggle="dropdown">Action
                                                            <i class="fa fa-angle-down"></i>
                                                        </button>
                                                        <ul class="dropdown-menu pull-right">
                                                            <li>
                                                                <a href="javascript:;"> Action </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:;"> Another action </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:;"> Something else here </a>
                                                            </li>
                                                            <li class="divider"> </li>
                                                            <li>
                                                                <a href="javascript:;"> Separated link </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- /btn-group -->
                                                </div>
                                                <!-- /input-group -->
                                            </div>
                                            <!-- /.col-md-6 -->
                                        </div>
                                        <!-- /.row -->
                                    </form>
                                    <h4 class="block">Buttons With Dropdowns On Both Sides</h4>
                                    <form role="form">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn green dropdown-toggle" data-toggle="dropdown">Action
                                                            <i class="fa fa-angle-down"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a href="javascript:;"> Action </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:;"> Another action </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:;"> Something else here </a>
                                                            </li>
                                                            <li class="divider"> </li>
                                                            <li>
                                                                <a href="javascript:;"> Separated link </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- /btn-group -->
                                                    <input type="text" class="form-control">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn yellow dropdown-toggle" data-toggle="dropdown">Action
                                                            <i class="fa fa-angle-down"></i>
                                                        </button>
                                                        <ul class="dropdown-menu pull-right">
                                                            <li>
                                                                <a href="javascript:;"> Action </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:;"> Another action </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:;"> Something else here </a>
                                                            </li>
                                                            <li class="divider"> </li>
                                                            <li>
                                                                <a href="javascript:;"> Separated link </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- /btn-group -->
                                                </div>
                                                <!-- /input-group -->
                                            </div>
                                            <!-- /.col-md-6 -->
                                        </div>
                                        <!-- /.row -->
                                    </form>
                                    <h4 class="block">Segmented Buttons</h4>
                                    <form role="form">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn default" tabindex="-1">Action</button>
                                                        <button type="button" class="btn default dropdown-toggle" data-toggle="dropdown" tabindex="-1">
                                                            <i class="fa fa-angle-down"></i>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li>
                                                                <a href="javascript:;"> Action </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:;"> Another action </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:;"> Something else here </a>
                                                            </li>
                                                            <li class="divider"> </li>
                                                            <li>
                                                                <a href="javascript:;"> Separated link </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <input type="text" class="form-control"> </div>
                                                <!-- /.input-group -->
                                            </div>
                                            <!-- /.col-md-6 -->
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <input type="text" class="form-control">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn green" tabindex="-1">Action</button>
                                                        <button type="button" class="btn green dropdown-toggle" data-toggle="dropdown" tabindex="-1">
                                                            <i class="fa fa-angle-down"></i>
                                                        </button>
                                                        <ul class="dropdown-menu pull-right" role="menu">
                                                            <li>
                                                                <a href="javascript:;"> Action </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:;"> Another action </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:;"> Something else here </a>
                                                            </li>
                                                            <li class="divider"> </li>
                                                            <li>
                                                                <a href="javascript:;"> Separated link </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <!-- /.input-group -->
                                            </div>
                                            <!-- /.col-md-6 -->
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- END SAMPLE FORM PORTLET-->
                            <!-- BEGIN SAMPLE FORM PORTLET-->
                            <div class="portlet box purple ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-gift"></i> Fixed Input Groups </div>
                                    <div class="tools">
                                        <a href="" class="collapse"> </a>
                                        <a href="#portlet-config" data-toggle="modal" class="config"> </a>
                                        <a href="" class="reload"> </a>
                                        <a href="" class="remove"> </a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <h4 class="block">Checkboxe Addons</h4>
                                    <form role="form">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="input-group input-medium">
                                                            <span class="input-group-addon">
                                                                <input type="checkbox"> </span>
                                                    <input type="text" class="form-control" placeholder=".input-medium"> </div>
                                                <!-- /input-group -->
                                            </div>
                                            <!-- /.col-md-6 -->
                                            <div class="col-md-6">
                                                <div class="input-group input-medium">
                                                    <input type="text" class="form-control" placeholder=".input-medium">
                                                            <span class="input-group-addon">
                                                                <input type="checkbox"> </span>
                                                </div>
                                                <!-- /input-group -->
                                            </div>
                                            <!-- /.col-md-6 -->
                                        </div>
                                        <!-- /.row -->
                                    </form>
                                    <h4 class="block">Button Addons</h4>
                                    <form role="form">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="input-group input-medium">
                                                            <span class="input-group-btn">
                                                                <button class="btn red" type="button">Go!</button>
                                                            </span>
                                                    <input type="text" class="form-control" placeholder=".input-medium"> </div>
                                                <!-- /input-group -->
                                            </div>
                                            <!-- /.col-md-6 -->
                                            <div class="col-md-6">
                                                <div class="input-group input-medium">
                                                    <input type="text" class="form-control" placeholder=".input-medium">
                                                            <span class="input-group-btn">
                                                                <button class="btn blue" type="button">Go!</button>
                                                            </span>
                                                </div>
                                                <!-- /input-group -->
                                            </div>
                                            <!-- /.col-md-6 -->
                                        </div>
                                        <!-- /.row -->
                                    </form>
                                    <h4 class="block">Button Addons On Both Sides</h4>
                                    <form role="form">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="input-group input-large">
                                                            <span class="input-group-btn">
                                                                <button class="btn red" type="button">Go!</button>
                                                            </span>
                                                    <input type="text" class="form-control" placeholder=".input-large">
                                                            <span class="input-group-btn">
                                                                <button class="btn blue" type="button">Go!</button>
                                                            </span>
                                                </div>
                                                <!-- /input-group -->
                                            </div>
                                            <!-- /.col-md-6 -->
                                        </div>
                                    </form>
                                    <h4 class="block">Buttons With Dropdowns</h4>
                                    <form role="form">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="input-group input-medium">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn green dropdown-toggle" data-toggle="dropdown">Action
                                                            <i class="fa fa-angle-down"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a href="javascript:;"> Action </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:;"> Another action </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:;"> Something else here </a>
                                                            </li>
                                                            <li class="divider"> </li>
                                                            <li>
                                                                <a href="javascript:;"> Separated link </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- /btn-group -->
                                                    <input type="text" class="form-control" placeholder=".input-medium"> </div>
                                                <!-- /input-group -->
                                            </div>
                                            <!-- /.col-md-6 -->
                                            <div class="col-md-6">
                                                <div class="input-group input-medium">
                                                    <input type="text" class="form-control" placeholder=".input-medium">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn yellow dropdown-toggle" data-toggle="dropdown">Action
                                                            <i class="fa fa-angle-down"></i>
                                                        </button>
                                                        <ul class="dropdown-menu pull-right">
                                                            <li>
                                                                <a href="javascript:;"> Action </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:;"> Another action </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:;"> Something else here </a>
                                                            </li>
                                                            <li class="divider"> </li>
                                                            <li>
                                                                <a href="javascript:;"> Separated link </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- /btn-group -->
                                                </div>
                                                <!-- /input-group -->
                                            </div>
                                            <!-- /.col-md-6 -->
                                        </div>
                                        <!-- /.row -->
                                    </form>
                                    <h4 class="block">Buttons With Dropdowns On Both Sides</h4>
                                    <form role="form">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="input-group input-xlarge">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn green dropdown-toggle" data-toggle="dropdown">Action
                                                            <i class="fa fa-angle-down"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a href="javascript:;"> Action </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:;"> Another action </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:;"> Something else here </a>
                                                            </li>
                                                            <li class="divider"> </li>
                                                            <li>
                                                                <a href="javascript:;"> Separated link </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- /btn-group -->
                                                    <input type="text" class="form-control" placeholder=".input-xlarge">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn yellow dropdown-toggle" data-toggle="dropdown">Action
                                                            <i class="fa fa-angle-down"></i>
                                                        </button>
                                                        <ul class="dropdown-menu pull-right">
                                                            <li>
                                                                <a href="javascript:;"> Action </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:;"> Another action </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:;"> Something else here </a>
                                                            </li>
                                                            <li class="divider"> </li>
                                                            <li>
                                                                <a href="javascript:;"> Separated link </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- /btn-group -->
                                                </div>
                                                <!-- /input-group -->
                                            </div>
                                            <!-- /.col-md-6 -->
                                        </div>
                                        <!-- /.row -->
                                    </form>
                                    <h4 class="block">Segmented Buttons</h4>
                                    <form role="form">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="input-group input-large">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn default" tabindex="-1">Action</button>
                                                        <button type="button" class="btn default dropdown-toggle" data-toggle="dropdown" tabindex="-1">
                                                            <i class="fa fa-angle-down"></i>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li>
                                                                <a href="javascript:;"> Action </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:;"> Another action </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:;"> Something else here </a>
                                                            </li>
                                                            <li class="divider"> </li>
                                                            <li>
                                                                <a href="javascript:;"> Separated link </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <input type="text" class="form-control" placeholder=".input-large"> </div>
                                                <!-- /.input-group -->
                                            </div>
                                            <!-- /.col-md-6 -->
                                        </div>
                                    </form>
                                    <form role="form" class="margin-top-10">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="input-group input-large">
                                                    <input type="text" class="form-control" placeholder=".input-large">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn green" tabindex="-1">Action</button>
                                                        <button type="button" class="btn green dropdown-toggle" data-toggle="dropdown" tabindex="-1">
                                                            <i class="fa fa-angle-down"></i>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li>
                                                                <a href="javascript:;"> Action </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:;"> Another action </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:;"> Something else here </a>
                                                            </li>
                                                            <li class="divider"> </li>
                                                            <li>
                                                                <a href="javascript:;"> Separated link </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <!-- /.input-group -->
                                            </div>
                                            <!-- /.col-md-6 -->
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- END SAMPLE FORM PORTLET-->
                            <div class="portlet box blue ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-gift"></i> Validation States </div>
                                    <div class="tools">
                                        <a href="" class="collapse"> </a>
                                        <a href="#portlet-config" data-toggle="modal" class="config"> </a>
                                        <a href="" class="reload"> </a>
                                        <a href="" class="remove"> </a>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <form role="form">
                                        <div class="form-body">
                                            <div class="form-group has-success">
                                                <label class="control-label">Input with success</label>
                                                <input type="text" class="form-control" id="inputSuccess"> </div>
                                            <div class="form-group has-warning">
                                                <label class="control-label">Input with warning</label>
                                                <input type="text" class="form-control" id="inputWarning"> </div>
                                            <div class="form-group has-error">
                                                <label class="control-label">Input with error</label>
                                                <input type="text" class="form-control" id="inputError"> </div>
                                        </div>
                                        <div class="form-actions">
                                            <button type="button" class="btn default">Cancel</button>
                                            <button type="submit" class="btn red">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="portlet box yellow ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-gift"></i> Validation States With Icons </div>
                                    <div class="tools">
                                        <a href="" class="collapse"> </a>
                                        <a href="#portlet-config" data-toggle="modal" class="config"> </a>
                                        <a href="" class="reload"> </a>
                                        <a href="" class="remove"> </a>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <form role="form">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label class="control-label">Default input</label>
                                                <div class="input-icon right">
                                                    <i class="fa fa-info-circle tooltips" data-original-title="Email address" data-container="body"></i>
                                                    <input type="text" class="form-control"> </div>
                                            </div>
                                            <div class="form-group has-success">
                                                <label class="control-label">Input with success</label>
                                                <div class="input-icon right">
                                                    <i class="fa fa-check tooltips" data-original-title="You look OK!" data-container="body"></i>
                                                    <input type="text" class="form-control"> </div>
                                            </div>
                                            <div class="form-group has-warning">
                                                <label class="control-label">Input with warning</label>
                                                <div class="input-icon right">
                                                    <i class="fa fa-warning tooltips" data-original-title="please provide an email" data-container="body"></i>
                                                    <input type="text" class="form-control"> </div>
                                            </div>
                                            <div class="form-group has-error">
                                                <label class="control-label">Input with error</label>
                                                <div class="input-icon right">
                                                    <i class="fa fa-exclamation tooltips" data-original-title="please write a valid email" data-container="body"></i>
                                                    <input type="text" class="form-control"> </div>
                                            </div>
                                        </div>
                                        <div class="form-actions right">
                                            <button type="button" class="btn default">Cancel</button>
                                            <button type="submit" class="btn green">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="portlet box purple">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-gift"></i> Horizontal Form Validation States </div>
                                    <div class="tools">
                                        <a href="" class="collapse"> </a>
                                        <a href="#portlet-config" data-toggle="modal" class="config"> </a>
                                        <a href="" class="reload"> </a>
                                        <a href="" class="remove"> </a>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <form role="form" class="form-horizontal">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Default input</label>
                                                <div class="col-md-8">
                                                    <div class="input-icon right">
                                                        <i class="fa fa-info-circle tooltips" data-original-title="Email address" data-container="body"></i>
                                                        <input type="text" class="form-control"> </div>
                                                </div>
                                            </div>
                                            <div class="form-group has-success">
                                                <label class="col-md-4 control-label">Input with success</label>
                                                <div class="col-md-8">
                                                    <div class="input-icon right">
                                                        <i class="fa fa-check tooltips" data-original-title="You look OK!" data-container="body"></i>
                                                        <input type="text" class="form-control"> </div>
                                                </div>
                                            </div>
                                            <div class="form-group has-warning">
                                                <label class="col-md-4 control-label">Input with warning</label>
                                                <div class="col-md-8">
                                                    <div class="input-icon right">
                                                        <i class="fa fa-warning tooltips" data-original-title="please provide an email" data-container="body"></i>
                                                        <input type="text" class="form-control"> </div>
                                                </div>
                                            </div>
                                            <div class="form-group has-error">
                                                <label class="col-md-4 control-label">Input with error</label>
                                                <div class="col-md-8">
                                                    <div class="input-icon right">
                                                        <i class="fa fa-exclamation tooltips" data-original-title="please write a valid email" data-container="body"></i>
                                                        <input type="text" class="form-control"> </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-offset-4 col-md-8">
                                                    <button type="button" class="btn default">Cancel</button>
                                                    <button type="submit" class="btn blue">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-md-12">
                            <!-- BEGIN SAMPLE FORM PORTLET-->
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-share font-dark"></i>
                                        <span class="caption-subject font-dark bold uppercase">More Form Samples</span>
                                    </div>
                                    <div class="actions">
                                        <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                            <i class="icon-cloud-upload"></i>
                                        </a>
                                        <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                            <i class="icon-wrench"></i>
                                        </a>
                                        <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                            <i class="icon-trash"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <h4>Inline Form</h4>
                                    <form class="form-inline" role="form">
                                        <div class="form-group">
                                            <label class="sr-only" for="exampleInputEmail2">Email address</label>
                                            <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Enter email"> </div>
                                        <div class="form-group">
                                            <label class="sr-only" for="exampleInputPassword2">Password</label>
                                            <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password"> </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"> Remember me </label>
                                        </div>
                                        <button type="submit" class="btn btn-default">Sign in</button>
                                    </form>
                                    <hr>
                                    <h4>Inline Form With Icons</h4>
                                    <form class="form-inline" role="form">
                                        <div class="form-group">
                                            <label class="sr-only" for="exampleInputEmail22">Email address</label>
                                            <div class="input-icon">
                                                <i class="fa fa-envelope"></i>
                                                <input type="email" class="form-control" id="exampleInputEmail22" placeholder="Enter email"> </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="sr-only" for="exampleInputPassword42">Password</label>
                                            <div class="input-icon">
                                                <i class="fa fa-user"></i>
                                                <input type="password" class="form-control" id="exampleInputPassword42" placeholder="Password"> </div>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"> Remember me </label>
                                        </div>
                                        <button type="submit" class="btn btn-default">Sign in</button>
                                    </form>
                                    <hr>
                                    <h4>Horizontal Form</h4>
                                    <form class="form-horizontal" role="form">
                                        <div class="form-group">
                                            <label for="inputEmail1" class="col-md-2 control-label">Email</label>
                                            <div class="col-md-4">
                                                <input type="email" class="form-control" id="inputEmail1" placeholder="Email"> </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputPassword12" class="col-md-2 control-label">Password</label>
                                            <div class="col-md-4">
                                                <input type="password" class="form-control" id="inputPassword12" placeholder="Password"> </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-offset-2 col-md-4">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox"> Remember me </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-offset-2 col-md-10">
                                                <button type="submit" class="btn blue">Sign in</button>
                                            </div>
                                        </div>
                                    </form>
                                    <hr>
                                    <h4>Horizontal Form With Icons</h4>
                                    <form class="form-horizontal" role="form">
                                        <div class="form-group">
                                            <label for="inputEmail12" class="col-md-2 control-label">Email</label>
                                            <div class="col-md-4">
                                                <div class="input-icon">
                                                    <i class="fa fa-envelope"></i>
                                                    <input type="email" class="form-control" id="inputEmail12" placeholder="Email"> </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputPassword1" class="col-md-2 control-label">Password</label>
                                            <div class="col-md-4">
                                                <div class="input-icon right">
                                                    <i class="fa fa-user"></i>
                                                    <input type="password" class="form-control" id="inputPassword1" placeholder="Password"> </div>
                                                <div class="help-block"> with right aligned icon </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-offset-2 col-md-4">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox"> Remember me </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-offset-2 col-md-10">
                                                <button type="submit" class="btn green">Sign in</button>
                                            </div>
                                        </div>
                                    </form>
                                    <hr>
                                    <h4>Column Sizing</h4>
                                    <form role="form">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <input type="text" class="form-control" placeholder=".col-md-2"> </div>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control" placeholder=".col-md-3"> </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder=".col-md-4"> </div>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control" placeholder=".col-md-2"> </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- END SAMPLE FORM PORTLET-->
                        </div>
                    </div>
                </div>
                <!-- END PAGE CONTENT INNER -->
            </div>
        </div>
        <!-- END PAGE CONTENT BODY -->
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
    <!-- BEGIN QUICK SIDEBAR -->
    <a href="javascript:;" class="page-quick-sidebar-toggler">
        <i class="icon-login"></i>
    </a>
    <div class="page-quick-sidebar-wrapper" data-close-on-body-click="false">
        <div class="page-quick-sidebar">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="javascript:;" data-target="#quick_sidebar_tab_1" data-toggle="tab"> Users
                        <span class="badge badge-danger">2</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:;" data-target="#quick_sidebar_tab_2" data-toggle="tab"> Alerts
                        <span class="badge badge-success">7</span>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> More
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu pull-right">
                        <li>
                            <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab">
                                <i class="icon-bell"></i> Alerts </a>
                        </li>
                        <li>
                            <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab">
                                <i class="icon-info"></i> Notifications </a>
                        </li>
                        <li>
                            <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab">
                                <i class="icon-speech"></i> Activities </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab">
                                <i class="icon-settings"></i> Settings </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active page-quick-sidebar-chat" id="quick_sidebar_tab_1">
                    <div class="page-quick-sidebar-chat-users" data-rail-color="#ddd" data-wrapper-class="page-quick-sidebar-list">
                        <h3 class="list-heading">Staff</h3>
                        <ul class="media-list list-items">
                            <li class="media">
                                <div class="media-status">
                                    <span class="badge badge-success">8</span>
                                </div>
                                <img class="media-object" src="../assets/layouts/layout/img/avatar3.jpg" alt="...">
                                <div class="media-body">
                                    <h4 class="media-heading">Bob Nilson</h4>
                                    <div class="media-heading-sub"> Project Manager </div>
                                </div>
                            </li>
                            <li class="media">
                                <img class="media-object" src="../assets/layouts/layout/img/avatar1.jpg" alt="...">
                                <div class="media-body">
                                    <h4 class="media-heading">Nick Larson</h4>
                                    <div class="media-heading-sub"> Art Director </div>
                                </div>
                            </li>
                            <li class="media">
                                <div class="media-status">
                                    <span class="badge badge-danger">3</span>
                                </div>
                                <img class="media-object" src="../assets/layouts/layout/img/avatar4.jpg" alt="...">
                                <div class="media-body">
                                    <h4 class="media-heading">Deon Hubert</h4>
                                    <div class="media-heading-sub"> CTO </div>
                                </div>
                            </li>
                            <li class="media">
                                <img class="media-object" src="../assets/layouts/layout/img/avatar2.jpg" alt="...">
                                <div class="media-body">
                                    <h4 class="media-heading">Ella Wong</h4>
                                    <div class="media-heading-sub"> CEO </div>
                                </div>
                            </li>
                        </ul>
                        <h3 class="list-heading">Customers</h3>
                        <ul class="media-list list-items">
                            <li class="media">
                                <div class="media-status">
                                    <span class="badge badge-warning">2</span>
                                </div>
                                <img class="media-object" src="../assets/layouts/layout/img/avatar6.jpg" alt="...">
                                <div class="media-body">
                                    <h4 class="media-heading">Lara Kunis</h4>
                                    <div class="media-heading-sub"> CEO, Loop Inc </div>
                                    <div class="media-heading-small"> Last seen 03:10 AM </div>
                                </div>
                            </li>
                            <li class="media">
                                <div class="media-status">
                                    <span class="label label-sm label-success">new</span>
                                </div>
                                <img class="media-object" src="../assets/layouts/layout/img/avatar7.jpg" alt="...">
                                <div class="media-body">
                                    <h4 class="media-heading">Ernie Kyllonen</h4>
                                    <div class="media-heading-sub"> Project Manager,
                                        <br> SmartBizz PTL </div>
                                </div>
                            </li>
                            <li class="media">
                                <img class="media-object" src="../assets/layouts/layout/img/avatar8.jpg" alt="...">
                                <div class="media-body">
                                    <h4 class="media-heading">Lisa Stone</h4>
                                    <div class="media-heading-sub"> CTO, Keort Inc </div>
                                    <div class="media-heading-small"> Last seen 13:10 PM </div>
                                </div>
                            </li>
                            <li class="media">
                                <div class="media-status">
                                    <span class="badge badge-success">7</span>
                                </div>
                                <img class="media-object" src="../assets/layouts/layout/img/avatar9.jpg" alt="...">
                                <div class="media-body">
                                    <h4 class="media-heading">Deon Portalatin</h4>
                                    <div class="media-heading-sub"> CFO, H&D LTD </div>
                                </div>
                            </li>
                            <li class="media">
                                <img class="media-object" src="../assets/layouts/layout/img/avatar10.jpg" alt="...">
                                <div class="media-body">
                                    <h4 class="media-heading">Irina Savikova</h4>
                                    <div class="media-heading-sub"> CEO, Tizda Motors Inc </div>
                                </div>
                            </li>
                            <li class="media">
                                <div class="media-status">
                                    <span class="badge badge-danger">4</span>
                                </div>
                                <img class="media-object" src="../assets/layouts/layout/img/avatar11.jpg" alt="...">
                                <div class="media-body">
                                    <h4 class="media-heading">Maria Gomez</h4>
                                    <div class="media-heading-sub"> Manager, Infomatic Inc </div>
                                    <div class="media-heading-small"> Last seen 03:10 AM </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="page-quick-sidebar-item">
                        <div class="page-quick-sidebar-chat-user">
                            <div class="page-quick-sidebar-nav">
                                <a href="javascript:;" class="page-quick-sidebar-back-to-list">
                                    <i class="icon-arrow-left"></i>Back</a>
                            </div>
                            <div class="page-quick-sidebar-chat-user-messages">
                                <div class="post out">
                                    <img class="avatar" alt="" src="../assets/layouts/layout/img/avatar3.jpg" />
                                    <div class="message">
                                        <span class="arrow"></span>
                                        <a href="javascript:;" class="name">Bob Nilson</a>
                                        <span class="datetime">20:15</span>
                                        <span class="body"> When could you send me the report ? </span>
                                    </div>
                                </div>
                                <div class="post in">
                                    <img class="avatar" alt="" src="../assets/layouts/layout/img/avatar2.jpg" />
                                    <div class="message">
                                        <span class="arrow"></span>
                                        <a href="javascript:;" class="name">Ella Wong</a>
                                        <span class="datetime">20:15</span>
                                        <span class="body"> Its almost done. I will be sending it shortly </span>
                                    </div>
                                </div>
                                <div class="post out">
                                    <img class="avatar" alt="" src="../assets/layouts/layout/img/avatar3.jpg" />
                                    <div class="message">
                                        <span class="arrow"></span>
                                        <a href="javascript:;" class="name">Bob Nilson</a>
                                        <span class="datetime">20:15</span>
                                        <span class="body"> Alright. Thanks! :) </span>
                                    </div>
                                </div>
                                <div class="post in">
                                    <img class="avatar" alt="" src="../assets/layouts/layout/img/avatar2.jpg" />
                                    <div class="message">
                                        <span class="arrow"></span>
                                        <a href="javascript:;" class="name">Ella Wong</a>
                                        <span class="datetime">20:16</span>
                                        <span class="body"> You are most welcome. Sorry for the delay. </span>
                                    </div>
                                </div>
                                <div class="post out">
                                    <img class="avatar" alt="" src="../assets/layouts/layout/img/avatar3.jpg" />
                                    <div class="message">
                                        <span class="arrow"></span>
                                        <a href="javascript:;" class="name">Bob Nilson</a>
                                        <span class="datetime">20:17</span>
                                        <span class="body"> No probs. Just take your time :) </span>
                                    </div>
                                </div>
                                <div class="post in">
                                    <img class="avatar" alt="" src="../assets/layouts/layout/img/avatar2.jpg" />
                                    <div class="message">
                                        <span class="arrow"></span>
                                        <a href="javascript:;" class="name">Ella Wong</a>
                                        <span class="datetime">20:40</span>
                                        <span class="body"> Alright. I just emailed it to you. </span>
                                    </div>
                                </div>
                                <div class="post out">
                                    <img class="avatar" alt="" src="../assets/layouts/layout/img/avatar3.jpg" />
                                    <div class="message">
                                        <span class="arrow"></span>
                                        <a href="javascript:;" class="name">Bob Nilson</a>
                                        <span class="datetime">20:17</span>
                                        <span class="body"> Great! Thanks. Will check it right away. </span>
                                    </div>
                                </div>
                                <div class="post in">
                                    <img class="avatar" alt="" src="../assets/layouts/layout/img/avatar2.jpg" />
                                    <div class="message">
                                        <span class="arrow"></span>
                                        <a href="javascript:;" class="name">Ella Wong</a>
                                        <span class="datetime">20:40</span>
                                        <span class="body"> Please let me know if you have any comment. </span>
                                    </div>
                                </div>
                                <div class="post out">
                                    <img class="avatar" alt="" src="../assets/layouts/layout/img/avatar3.jpg" />
                                    <div class="message">
                                        <span class="arrow"></span>
                                        <a href="javascript:;" class="name">Bob Nilson</a>
                                        <span class="datetime">20:17</span>
                                        <span class="body"> Sure. I will check and buzz you if anything needs to be corrected. </span>
                                    </div>
                                </div>
                            </div>
                            <div class="page-quick-sidebar-chat-user-form">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Type a message here...">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn green">
                                            <i class="icon-paper-clip"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane page-quick-sidebar-alerts" id="quick_sidebar_tab_2">
                    <div class="page-quick-sidebar-alerts-list">
                        <h3 class="list-heading">General</h3>
                        <ul class="feeds list-items">
                            <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-info">
                                                <i class="fa fa-check"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"> You have 4 pending tasks.
                                                        <span class="label label-sm label-warning "> Take action
                                                            <i class="fa fa-share"></i>
                                                        </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> Just now </div>
                                </div>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <div class="col1">
                                        <div class="cont">
                                            <div class="cont-col1">
                                                <div class="label label-sm label-success">
                                                    <i class="fa fa-bar-chart-o"></i>
                                                </div>
                                            </div>
                                            <div class="cont-col2">
                                                <div class="desc"> Finance Report for year 2013 has been released. </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date"> 20 mins </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-danger">
                                                <i class="fa fa-user"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"> You have 5 pending membership that requires a quick review. </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> 24 mins </div>
                                </div>
                            </li>
                            <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-info">
                                                <i class="fa fa-shopping-cart"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"> New order received with
                                                <span class="label label-sm label-success"> Reference Number: DR23923 </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> 30 mins </div>
                                </div>
                            </li>
                            <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-success">
                                                <i class="fa fa-user"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"> You have 5 pending membership that requires a quick review. </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> 24 mins </div>
                                </div>
                            </li>
                            <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-info">
                                                <i class="fa fa-bell-o"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"> Web server hardware needs to be upgraded.
                                                <span class="label label-sm label-warning"> Overdue </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> 2 hours </div>
                                </div>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <div class="col1">
                                        <div class="cont">
                                            <div class="cont-col1">
                                                <div class="label label-sm label-default">
                                                    <i class="fa fa-briefcase"></i>
                                                </div>
                                            </div>
                                            <div class="cont-col2">
                                                <div class="desc"> IPO Report for year 2013 has been released. </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date"> 20 mins </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <h3 class="list-heading">System</h3>
                        <ul class="feeds list-items">
                            <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-info">
                                                <i class="fa fa-check"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"> You have 4 pending tasks.
                                                        <span class="label label-sm label-warning "> Take action
                                                            <i class="fa fa-share"></i>
                                                        </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> Just now </div>
                                </div>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <div class="col1">
                                        <div class="cont">
                                            <div class="cont-col1">
                                                <div class="label label-sm label-danger">
                                                    <i class="fa fa-bar-chart-o"></i>
                                                </div>
                                            </div>
                                            <div class="cont-col2">
                                                <div class="desc"> Finance Report for year 2013 has been released. </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date"> 20 mins </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-default">
                                                <i class="fa fa-user"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"> You have 5 pending membership that requires a quick review. </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> 24 mins </div>
                                </div>
                            </li>
                            <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-info">
                                                <i class="fa fa-shopping-cart"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"> New order received with
                                                <span class="label label-sm label-success"> Reference Number: DR23923 </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> 30 mins </div>
                                </div>
                            </li>
                            <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-success">
                                                <i class="fa fa-user"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"> You have 5 pending membership that requires a quick review. </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> 24 mins </div>
                                </div>
                            </li>
                            <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-warning">
                                                <i class="fa fa-bell-o"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"> Web server hardware needs to be upgraded.
                                                <span class="label label-sm label-default "> Overdue </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> 2 hours </div>
                                </div>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <div class="col1">
                                        <div class="cont">
                                            <div class="cont-col1">
                                                <div class="label label-sm label-info">
                                                    <i class="fa fa-briefcase"></i>
                                                </div>
                                            </div>
                                            <div class="cont-col2">
                                                <div class="desc"> IPO Report for year 2013 has been released. </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date"> 20 mins </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-pane page-quick-sidebar-settings" id="quick_sidebar_tab_3">
                    <div class="page-quick-sidebar-settings-list">
                        <h3 class="list-heading">General Settings</h3>
                        <ul class="list-items borderless">
                            <li> Enable Notifications
                                <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="success" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                            <li> Allow Tracking
                                <input type="checkbox" class="make-switch" data-size="small" data-on-color="info" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                            <li> Log Errors
                                <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="danger" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                            <li> Auto Sumbit Issues
                                <input type="checkbox" class="make-switch" data-size="small" data-on-color="warning" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                            <li> Enable SMS Alerts
                                <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="success" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                        </ul>
                        <h3 class="list-heading">System Settings</h3>
                        <ul class="list-items borderless">
                            <li> Security Level
                                <select class="form-control input-inline input-sm input-small">
                                    <option value="1">Normal</option>
                                    <option value="2" selected>Medium</option>
                                    <option value="e">High</option>
                                </select>
                            </li>
                            <li> Failed Email Attempts
                                <input class="form-control input-inline input-sm input-small" value="5" /> </li>
                            <li> Secondary SMTP Port
                                <input class="form-control input-inline input-sm input-small" value="3560" /> </li>
                            <li> Notify On System Error
                                <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="danger" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                            <li> Notify On SMTP Error
                                <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="warning" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                        </ul>
                        <div class="inner-content">
                            <button class="btn btn-success">
                                <i class="icon-settings"></i> Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<!-- BEGIN PRE-FOOTER -->
<div class="page-prefooter">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12 footer-block">
                <h2>About</h2>
                <p> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam dolore. </p>
            </div>
            <div class="col-md-3 col-sm-6 col-xs12 footer-block">
                <h2>Subscribe Email</h2>
                <div class="subscribe-form">
                    <form action="javascript:;">
                        <div class="input-group">
                            <input type="text" placeholder="mail@email.com" class="form-control">
                                    <span class="input-group-btn">
                                        <button class="btn" type="submit">Submit</button>
                                    </span>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12 footer-block">
                <h2>Follow Us On</h2>
                <ul class="social-icons">
                    <li>
                        <a href="javascript:;" data-original-title="rss" class="rss"></a>
                    </li>
                    <li>
                        <a href="javascript:;" data-original-title="facebook" class="facebook"></a>
                    </li>
                    <li>
                        <a href="javascript:;" data-original-title="twitter" class="twitter"></a>
                    </li>
                    <li>
                        <a href="javascript:;" data-original-title="googleplus" class="googleplus"></a>
                    </li>
                    <li>
                        <a href="javascript:;" data-original-title="linkedin" class="linkedin"></a>
                    </li>
                    <li>
                        <a href="javascript:;" data-original-title="youtube" class="youtube"></a>
                    </li>
                    <li>
                        <a href="javascript:;" data-original-title="vimeo" class="vimeo"></a>
                    </li>
                </ul>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12 footer-block">
                <h2>Contacts</h2>
                <address class="margin-bottom-40"> Phone: 800 123 3456
                    <br> Email:
                    <a href="mailto:info@metronic.com">info@metronic.com</a>
                </address>
            </div>
        </div>
    </div>
</div>
<!-- END PRE-FOOTER -->
<!-- BEGIN INNER FOOTER -->
<div class="page-footer">
    <div class="container"> 2014 &copy; Metronic by keenthemes.
        <a href="http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes" title="Purchase Metronic just for 27$ and get lifetime updates for free" target="_blank">Purchase Metronic!</a>
    </div>
</div>
<div class="scroll-to-top">
    <i class="icon-arrow-up"></i>
</div>
<!-- END INNER FOOTER -->
<!-- END FOOTER -->
@include('includes.core-scripts')
</body>

</html>