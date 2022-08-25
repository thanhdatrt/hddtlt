<!DOCTYPE html>

<html>
<head runat="server">
    <title>QL Miễn giảm môn học</title>
    
    <!-- Site favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="vendors/images/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="{{asset('public/src/images/logo1.png')}}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{asset('public/src/images/logo1.png')}}">

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<link href="{{asset('public/vendors/styles/font-face.css')}}" rel="stylesheet" media="all">
	<link href="{{asset('public/vendors/mdi-font/css/material-design-iconic-font.min.css')}}" rel="stylesheet" media="all">
	<!-- Google Font -->
	<link href="{{asset('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap')}}" rel="stylesheet">
	<!-- Material Icons -->
    <link href="{{asset('https://fonts.googleapis.com/icon?family=Material+Icons+Round')}}" rel="stylesheet">
	<!-- CSS -->
    <link rel="stylesheet" href="{{asset('public/vendors/styles/core.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('public/vendors/styles/icon-font.min.css')}}">
	<link rel="stylesheet" href="{{asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css')}}" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" type="text/css" href="{{asset('public/src/plugins/datatables/css/dataTables.bootstrap4.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('public/src/plugins/datatables/css/responsive.bootstrap4.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('public/vendors/styles/style.css')}}">
	<!-- switchery css -->
	<link rel="stylesheet" type="text/css" href="{{asset('public/src/plugins/switchery/switchery.min.css')}}">
	<!-- bootstrap-tagsinput css -->
	<link rel="stylesheet" type="text/css" href="{{asset('public/src/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
	<!-- bootstrap-touchspin css -->
	<link rel="stylesheet" type="text/css" href="{{asset('public/src/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.css')}}">
	{{-- calendor --}}
	<link href="{{asset('public/vendors/styles/style.css')}}" rel="stylesheet" type="text/css"media="all">	
	<link rel="stylesheet" type="text/css" href="{{asset('public/src/plugins/fullcalendar/fullcalendar.css')}}">
	<link href="{{asset('https://fonts.googleapis.com/icon?family=Material+Icons')}}" rel="stylesheet">

	{{-- <link rel="stylesheet" type="text/css" href="{{asset('//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css')}}"> --}}


	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
	<script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-119386393-1');
    </script>

	<style>
		#button {
		display: inline-block;
		background-color: #0069d9;
		width: 50px;
		height: 50px;
		text-align: center;
		border-radius: 4px;
		position: fixed;
		bottom: 30px;
		right: 30px;
		transition: background-color .3s, 
			opacity .5s, visibility .5s;
		opacity: 0;
		visibility: hidden;
		z-index: 1000;
		}
		#button::after {
		content: "\f077";
		font-family: FontAwesome;
		font-weight: normal;
		font-style: normal;
		font-size: 2em;
		line-height: 50px;
		color: #fff;
		}
		#button:hover {
		cursor: pointer;
		background-color: #333;
		}
		#button:active {
		background-color: #555;
		}
		#button.show {
		opacity: 1;
		visibility: visible;
		}
	</style>

</head>
<body>

	<div class="pre-loader">
		<div class="pre-loader-box">
			<div class="loader-logo"><img src="{{asset('public/src/images/logo1.png')}}" alt=""></div>
			<div class='loader-progress' id="progress_div">
				<div class='bar' id='bar1'></div>
			</div>
			<div class='percent' id='percent1'>0%</div>
			<div class="loading-text">
				Loading...
			</div>
		</div>
	</div>

	<div class="header">
		<div class="header-left">
			<div class="menu-icon dw dw-menu"></div>
			<div class="search-toggle-icon dw dw-search2" data-toggle="header_search"></div>
			<div class="header-search">
				<form>
					<div class="form-group mb-0">
						<i class="dw dw-search2 search-icon"></i>
						<input type="text" class="form-control search-input" placeholder="Search Here">
						<div class="dropdown">
							<a class="dropdown-toggle no-arrow" href="#" role="button" data-toggle="dropdown">
								<i class="ion-arrow-down-c"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<div class="form-group row">
									<label class="col-sm-12 col-md-2 col-form-label">From</label>
									<div class="col-sm-12 col-md-10">
										<input class="form-control form-control-sm form-control-line" type="text">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-12 col-md-2 col-form-label">To</label>
									<div class="col-sm-12 col-md-10">
										<input class="form-control form-control-sm form-control-line" type="text">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-12 col-md-2 col-form-label">Subject</label>
									<div class="col-sm-12 col-md-10">
										<input class="form-control form-control-sm form-control-line" type="text">
									</div>
								</div>
								<div class="text-right">
									<button class="btn btn-primary">Search</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		
		<div class="header-right">
			<div class="dashboard-setting user-notification">
				<div class="dropdown">
					<a class="dropdown-toggle no-arrow" href="javascript:;" data-toggle="right-sidebar">
						<i class="dw dw-settings2"></i>
					</a>
				</div>
			</div>
			
			<div class="user-info-dropdown">
				<div class="dropdown">
					<a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
						<span class="user-icon">
							<?php $avatar = Session::get('avatar');
								if($avatar) {
									echo "<img src='".$avatar."' alt=''>";
								} 
							?>
						</span>
						<span class="user-name">
							<?php
								$name = Session::get('name');
								if($name) {
									echo '<span class="warning_mes">'.$name.'</span>';
								}
							?>
						</span>
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
						<a class="dropdown-item" href="{{URL::to('/profile')}}"><i class="dw dw-user1"></i> Profile</a>
						<a class="dropdown-item" href="{{URL::to('/accountmanager')}} "><i class="dw dw-settings2"></i> Setting</a>
						<a class="dropdown-item" href="{{URL::to('/logout')}}"><i class="dw dw-logout"></i> Log Out</a>
					</div>
				</div>
			</div>
			
		</div>

		<div class="right-sidebar">
			<div class="sidebar-title">
				<h3 class="weight-600 font-16 text-blue">
					Layout Settings
					<span class="btn-block font-weight-400 font-12">Cài đặt giao diện</span>
				</h3>
				<div class="close-sidebar" data-toggle="right-sidebar-close">
					<i class="icon-copy ion-close-round"></i>
				</div>
			</div>
			<div class="right-sidebar-body customscroll">
				<div class="right-sidebar-body-content">
					<h4 class="weight-600 font-18 pb-10">Nền tiêu đề</h4>
					<div class="sidebar-btn-group pb-30 mb-10">
						<a href="javascript:void(0);" class="btn btn-outline-primary header-white active">Trắng</a>
						<a href="javascript:void(0);" class="btn btn-outline-primary header-dark">Đen</a>
					</div>

					<h4 class="weight-600 font-18 pb-10">Nền thanh điều hướng</h4>
					<div class="sidebar-btn-group pb-30 mb-10">
						<a href="javascript:void(0);" class="btn btn-outline-primary sidebar-light ">Trắng</a>
						<a href="javascript:void(0);" class="btn btn-outline-primary sidebar-dark active">Đen</a>
					</div>

					<h4 class="weight-600 font-18 pb-10">Menu Dropdown Icon</h4>
					<div class="sidebar-radio-group pb-10 mb-10">
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" id="sidebaricon-1" name="menu-dropdown-icon" class="custom-control-input" value="icon-style-1" checked="">
							<label class="custom-control-label" for="sidebaricon-1"><i class="fa fa-angle-down"></i></label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" id="sidebaricon-2" name="menu-dropdown-icon" class="custom-control-input" value="icon-style-2">
							<label class="custom-control-label" for="sidebaricon-2"><i class="ion-plus-round"></i></label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" id="sidebaricon-3" name="menu-dropdown-icon" class="custom-control-input" value="icon-style-3">
							<label class="custom-control-label" for="sidebaricon-3"><i class="fa fa-angle-double-right"></i></label>
						</div>
					</div>

					<h4 class="weight-600 font-18 pb-10">Menu List Icon</h4>
					<div class="sidebar-radio-group pb-30 mb-10">
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" id="sidebariconlist-1" name="menu-list-icon" class="custom-control-input" value="icon-list-style-1" checked="">
							<label class="custom-control-label" for="sidebariconlist-1"><i class="ion-minus-round"></i></label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" id="sidebariconlist-2" name="menu-list-icon" class="custom-control-input" value="icon-list-style-2">
							<label class="custom-control-label" for="sidebariconlist-2"><i class="fa fa-circle-o" aria-hidden="true"></i></label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" id="sidebariconlist-3" name="menu-list-icon" class="custom-control-input" value="icon-list-style-3">
							<label class="custom-control-label" for="sidebariconlist-3"><i class="dw dw-check"></i></label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" id="sidebariconlist-4" name="menu-list-icon" class="custom-control-input" value="icon-list-style-4" checked="">
							<label class="custom-control-label" for="sidebariconlist-4"><i class="icon-copy dw dw-next-2"></i></label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" id="sidebariconlist-5" name="menu-list-icon" class="custom-control-input" value="icon-list-style-5">
							<label class="custom-control-label" for="sidebariconlist-5"><i class="dw dw-fast-forward-1"></i></label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" id="sidebariconlist-6" name="menu-list-icon" class="custom-control-input" value="icon-list-style-6">
							<label class="custom-control-label" for="sidebariconlist-6"><i class="dw dw-next"></i></label>
						</div>
					</div>

					<div class="reset-options pt-30 text-center">
						<button class="btn btn-danger" id="reset-settings">Mặc định</button>
					</div>
				</div>
			</div>
		</div>

		<div class="left-side-bar">
			<div class="brand-logo">
				<a href="{{URL::to('/home')}}">
					<img src="{{asset('public/src/images/logo.png')}}" width="50px" height="50px" alt="" class="dark-logo">
					<img src="{{asset('public/src/images/logo.png')}}" width="50px" height="50px" alt="" class="light-logo">
				</a>
				<div class="close-sidebar" data-toggle="left-sidebar-close">
					<i class="ion-close-round"></i>
				</div>
			</div>
			<div class="menu-block customscroll">
				<div class="sidebar-menu">
					<ul id="accordion-menu">
						<li>
							<a href="{{URL::to('/home')}}" class="dropdown-toggle no-arrow">
								<span class="micon dw dw-house-1"></span> <span class="mtext">Home</span>
							</a>
						</li>

						<li class="dropdown">
							<a href="javascript:;" class="dropdown-toggle">
								<span class="micon dw dw-edit2"></span><span class="mtext">Xét miễn giảm</span>
							</a>
							<ul class="submenu">
								<li><a href="{{URL::to('/dongbo')}}">Đồng bộ dữ liệu</a></li>
								<li><a href="{{URL::to('/xetmientruhp')}}">Xét miễn trừ cho sinh viên</a></li>
							</ul>
						</li>

						<li class="dropdown">
							<a href="javascript:;" class="dropdown-toggle">
								<span class="micon dw dw-edit2"></span><span class="mtext">Sinh viên</span>
							</a>
							<ul class="submenu">
								<li><a href="{{URL::to('/viewsinhvien')}}">Danh sách sinh viên</a></li>
								<li><a href="{{URL::to('/addsinhvien')}}">Thêm sinh viên</a></li>
							</ul>
						</li>

						<li class="dropdown">
							<a href="javascript:;" class="dropdown-toggle">
								<span class="micon dw dw-edit2"></span><span class="mtext">Chương trình đào tạo</span>
							</a>
							<ul class="submenu">
								<li><a href="{{URL::to('/viewctdt')}}">Danh sách CTĐT</a></li>
								<li><a href="{{URL::to('/addctdt')}}">Thêm CTĐT</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="javascript:;" class="dropdown-toggle">
								<span class="micon dw dw-edit2"></span><span class="mtext">Thông tin môn học</span>
							</a>
							<ul class="submenu">
								<li><a href="{{URL::to('/viewmonhoc')}}">Danh sách môn học</a></li>
								<li><a href="{{URL::to('/addmonhoc')}}">Thêm môn học</a></li>
							</ul>
						</li>

						<li class="dropdown">
							<a href="javascript:;" class="dropdown-toggle">
								<span class="micon dw dw-edit2"></span><span class="mtext">Thông tin lớp</span>
							</a>
							<ul class="submenu">
								<li><a href="{{URL::to('/viewlop')}}">Danh sách lớp</a></li>
								<li><a href="{{URL::to('/addlop')}}">Thêm lớp</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="javascript:;" class="dropdown-toggle">
								<span class="micon dw dw-edit2"></span><span class="mtext">Thông tin ngành học</span>
							</a>
							<ul class="submenu">
								<li><a href="{{URL::to('/viewnganh')}}">Danh sách ngành học</a></li>
								<li><a href="{{URL::to('/addnganh')}}">Thêm ngành học</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="javascript:;" class="dropdown-toggle">
								<span class="micon dw dw-edit2"></span><span class="mtext">Hệ đào tạo</span>
							</a>
							<ul class="submenu">
								<li><a href="{{URL::to('/viewhe')}}">Danh sách hệ</a></li>
								<li><a href="{{URL::to('/addhe')}}">Thêm hệ đào tạo</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="javascript:;" class="dropdown-toggle">
								<span class="micon dw dw-edit2"></span><span class="mtext">Hình thức đào tạo</span>
							</a>
							<ul class="submenu">
								<li><a href="{{URL::to('/viewhtdt')}}">Danh sách HTĐT</a></li>
								<li><a href="{{URL::to('/addhtdt')}}">Thêm HTĐT</a></li>
							</ul>
						</li>

						<li class="dropdown">
							<a href="javascript:;" class="dropdown-toggle">
								<span class="micon dw dw-edit2"></span><span class="mtext">Khóa học</span>
							</a>
							<ul class="submenu">
								<li><a href="{{URL::to('/viewkhoahoc')}}">Danh sách khóa học</a></li>
								<li><a href="{{URL::to('/addkhoahoc')}}">Thêm khóa học</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<!-- main -->
	<div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
			

            @yield('content')    


			<!-- footer -->
			<div class="footer-wrap pd-20 mb-20 card-box">
				Quản lý xét miễn giảm học phần
			</div>
		</div>
	</div>
	<a id="button"></a>
    

	<!-- js -->
	<script src="{{asset('public/vendors/scripts/core.js')}}"></script>
	<script src="{{asset('public/vendors/scripts/script.min.js')}}"></script>
	<script src="{{asset('public/vendors/scripts/process.js')}}"></script>
	<script src="{{asset('public/vendors/scripts/layout-settings.js')}}"></script>
	<script src="{{asset('public/src/plugins/apexcharts/apexcharts.min.js')}}"></script>
	
	{{-- <script src="{{asset('public/src/plugins/datatables/js/jquery.dataTables.min.js')}}"></script> --}}
	<script src="{{asset('public/src/plugins/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
	<script src="{{asset('public/src/plugins/datatables/js/dataTables.responsive.min.js')}}"></script>
	<script src="{{asset('public/src/plugins/datatables/js/responsive.bootstrap4.min.js')}}"></script>
	<script src="{{asset('public/vendors/scripts/dashboard.js')}}"></script>
	<script src="{{asset('public/src/plugins/fullcalendar/fullcalendar.min.js')}}"></script>
	<script src="{{asset('public/vendors/scripts/calendar-setting.js')}}"></script>
	<!-- switchery js -->
	<script src="{{asset('public/src/plugins/switchery/switchery.min.js')}}"></script>
	<!-- bootstrap-tagsinput js -->
	<script src="{{asset('public/src/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>
	<!-- bootstrap-touchspin js -->
	<script src="{{asset('public/src/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.js')}}"></script>
	<script src="{{asset('public/vendors/scripts/advanced-components.js')}}"></script>
	<script src="{{asset('public/src/plugins/jQuery-Knob-master/jquery.knob.min.js')}}"></script>
	<script src="{{asset('public/vendors/scripts/knob-chart-setting.js')}}"></script>
	<script>
		var btn = $('#button');

		$(window).scroll(function() {
		if ($(window).scrollTop() > 300) {
			btn.addClass('show');
		} else {
			btn.removeClass('show');
		}
		});

		btn.on('click', function(e) {
		e.preventDefault();
		$('html, body').animate({scrollTop:0}, '300');
		});

	</script>

</body>
</html>