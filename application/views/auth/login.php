<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Meta -->
		<meta name="description" content="Responsive Bootstrap4 Dashboard Template">
		<meta name="author" content="ParkerThemes">
		<link rel="shortcut icon" href="<?php echo base_url('assets/'); ?>img/fav.png" />

		<!-- Title -->
		<title>Artisan Data Management System | Login</title>
		
		<!-- *************
			************ Common Css Files *************
		************ -->
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="<?php echo base_url('assets/'); ?>css/bootstrap.min.css" />

		<!-- Master CSS -->
		<link rel="stylesheet" href="<?php echo base_url('assets/'); ?>css/main.css" />

	</head>

	<body class="authentication">

		<!-- Container start -->
		<div class="container">
			<?php //echo $this->session->userdata['admin_in']['role_id']; ?>
			<form action="<?php echo site_url('auth/index'); ?>" method="POST" id="inputForm">
				<div class="row justify-content-md-center">
					<div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
						<div class="login-screen">
							<div class="login-box">
								<a href="#" class="login-logo">
									<img src="<?php echo base_url('assets/'); ?>img/logo-dark.png" alt="Le Rouge Admin Dashboard" />
								</a>
								<h5>Welcome back,<br />Please Login to your Account.</h5>
								<?php if($this->session->flashdata('status')){ ?>
									<div role="alert" class="alert alert-danger" style="padding: 5px 18px;">
										<?php echo $this->session->flashdata('status'); ?>
									</div>
								<?php } ?>
								<div class="form-group">
									<input type="email" class="form-control" name="email" required data-parsley-error-message="Username" placeholder="Username" />
								</div>
								<div class="form-group">
									<input type="password" name="password" required class="form-control" placeholder="Password" />
								</div>
								<div class="actions mb-4">
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="remember_pwd">
										<label class="custom-control-label" for="remember_pwd">Remember me</label>
									</div>
									<button type="submit" class="btn btn-primary">Login</button>
								</div>
								<div class="forgot-pwd">
									<a class="link" href="javascript:void(0)">Forgot password?</a>
								</div>
								<hr>
								<div class="actions align-left">
									<span class="additional-link">New here?</span>
									<a href="javascript:void(0)" class="btn btn-dark">Create an Account</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>

		</div>
		<!-- Container end -->
		<script src="<?php echo base_url('assets/');?>js/jquery.min.js"></script>
		<script src="<?php echo base_url('assets/');?>js/bootstrap.bundle.min.js"></script>
		<script src="<?php echo base_url('assets/');?>js/parsley.js"></script>
		<script src="<?php echo base_url('assets/');?>js/custom_dev.js"></script>
	</body>
</html>