<?php $this->load->view("inc/header"); ?>

		<!-- Page wrapper start -->
		<div class="page-wrapper pinned">
			
			<!-- Sidebar wrapper start -->
			<?php $this->load->view("inc/sidebar"); ?>
			<!-- Sidebar wrapper end -->

			<!-- Page content start  -->
			<div class="page-content">

				<!-- Header start -->
				<?php $this->load->view("inc/navbar"); ?>
				<!-- Header end -->

				<!-- Page header start -->
				<div class="page-header">
					<ol class="breadcrumb">
						<li class="breadcrumb-item">Home</li>
						<li class="breadcrumb-item">User</li>
						<li class="breadcrumb-item active">Edit</li>
					</ol>

					<ul class="app-actions">
						<li>
							<a href="#" id="reportrange">
								<span class="range-text"></span>
								<i class="icon-chevron-down"></i>	
							</a>
						</li>
						<li>
							<a href="#">
								<i class="icon-export"></i>
							</a>
						</li>
					</ul>
				</div>
				<!-- Page header end -->
				
				<!-- Main container start -->
				<div class="main-container">

					<!-- Row start -->
					<div class="row gutters">

						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="card">
								<div class="card-body">
									
									<div class="row gutters">
										<div class="col-xl-4 col-lglg-4 col-md-4 col-sm-4 col-12">
											<div class="form-group">
												<label for="inputName">Input Type</label>
												<input type="text" class="form-control" id="inputName" placeholder="Enter full name">
											</div>
										</div>
										<div class="col-xl-4 col-lglg-4 col-md-4 col-sm-4 col-12">
											<div class="form-group">
												<label for="inputEmail">Input Email</label>
												<input type="email" class="form-control" id="inputEmail" placeholder="Enter email">
											</div>
										</div>
										<div class="col-xl-4 col-lglg-4 col-md-4 col-sm-4 col-12">
											<div class="form-group">
												<label for="inputPwd">Password</label>
												<input type="password" class="form-control" id="inputPwd" placeholder="Password">
											</div>
										</div>
										<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
											<div class="form-group">
												<label for="inputReadOnly">Readonly Input</label>
												<input class="form-control" id="inputReadOnly" type="text" placeholder="Readonly input" readonly>
											</div>
										</div>
										<div class="col-xl-4 col-lglg-4 col-md-4 col-sm-4 col-12">
											<div class="form-group">
												<label for="disabledInput">Disabled Input</label>
												<input type="text" id="disabledInput" class="form-control" placeholder="Disabled input" disabled>
											</div>
										</div>
										<div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
											<button type="submit" class="btn btn-primary my-1">Submit</button>
										</div>
									</div>

								</div>
							</div>
						</div>

					</div>
					<!-- Row end -->

				</div>
				<!-- Main container end -->

			</div>
			<!-- Page content end -->

		</div>
		<!-- Page wrapper end -->

		<!--**************************
			**************************
				**************************
							Required JavaScript Files
				**************************
			**************************
		**************************-->
		<!-- Required jQuery first, then Bootstrap Bundle JS -->
		<script src="<?php echo base_url('assets/'); ?>js/jquery.min.js"></script>
		<script src="<?php echo base_url('assets/'); ?>js/bootstrap.bundle.min.js"></script>
		<script src="<?php echo base_url('assets/'); ?>js/moment.js"></script>


		<!-- *************
			************ Vendor Js Files *************
		************* -->
		<!-- Slimscroll JS -->
		<script src="<?php echo base_url('assets/'); ?>vendor/slimscroll/slimscroll.min.js"></script>
		<script src="<?php echo base_url('assets/'); ?>vendor/slimscroll/custom-scrollbar.js"></script>

		<!-- Daterange -->
		<script src="<?php echo base_url('assets/'); ?>vendor/daterange/daterange.js"></script>
		<script src="<?php echo base_url('assets/'); ?>vendor/daterange/custom-daterange.js"></script>


		<!-- Main JS -->
		<script src="<?php echo base_url('assets/'); ?>js/main.js"></script>

	</body>
</html>