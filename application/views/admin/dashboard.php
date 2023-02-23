<?php $this->load->view("inc/header"); ?>

		<!-- Loading starts -->
		<div id="loading-wrapper">
			<div class="spinner-border" role="status">
				<span class="sr-only">Loading...</span>
			</div>
		</div>
		<!-- Loading ends -->


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
						<li class="breadcrumb-item active">CRM Dashboard</li>
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
						<div class="col-xl-5 col-lg-12 col-md-12 col-sm-12 col-12">
							<!-- Row starts -->
							<div class="row gutters">
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="goal-card">
										<i class="icon-user1"></i>
										<h2>2599</h2>
										<h6>Customers</h6>
									</div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="goal-card">
										<i class="icon-shopping-cart1"></i>
										<h2>4005</h2>
										<h6>Orders</h6>
									</div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="goal-card">
										<i class="icon-shopping-bag1"></i>
										<h2>3250</h2>
										<h6>Revenue</h6>
									</div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="goal-card">
										<i class="icon-file-text"></i>
										<h2>2475</h2>
										<h6>Invoices</h6>
									</div>
								</div>
							</div>
							<!-- Row ends -->
						</div>
						<div class="col-xl-7 col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="card h-310">
								<div class="card-header">
									<div class="card-title">Earnings</div>
								</div>
								<div class="card-body pt-0">
									<!-- Row starts -->
									<div class="row gutters">
										<div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 col-12">
											<div class="graph-label-container">
												<div class="graph-label">
													<i class="icon-controller-play"></i>
													<div class="label-detail">
														<h5>$45,000</h5>
														<p>Report GSK</p>
													</div>
												</div>
												<div class="graph-label">
													<i class="icon-controller-play"></i>
													<div class="label-detail">
														<h5>$60,000</h5>
														<p>Report MRS</p>
													</div>
												</div>
												<div class="graph-label">
													<i class="icon-controller-play"></i>
													<div class="label-detail">
														<h5>$75,000</h5>
														<p>Report AGS</p>
													</div>
												</div>
												<div class="graph-label">
													<i class="icon-controller-play"></i>
													<div class="label-detail">
														<h5>$90,000</h5>
														<p>Profit</p>
													</div>
												</div>
											</div>
										</div>
										<div class="col-xl-9 col-lg-9 col-md-8 col-sm-12 col-12">
											<div id="earnings"></div>
										</div>
									</div>
									<!-- Row ends -->
								</div>
							</div>
						</div>
						<!--div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="card">
								<div class="card-header">
									<div class="card-title">Sales</div>
								</div>
								<div class="card-body pt-0">
									<div id="compare-sales"></div>
								</div>
							</div>
						</div>
						<div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="card">
								<div class="card-header">
									<div class="card-title">Income</div>
								</div>
								<div class="card-body pt-0">
									<div id="compare-expenses"></div>
								</div>
							</div>
						</div-->
					</div>
					<!-- Row end -->

					<!-- Row start -->
					<!--div class="row gutters">
						<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
							<div class="card h-340">
								<div class="card-header">
									<div class="card-title">Todo's</div>
								</div>
								<div class="card-body">
									<div class="customScroll5">
										<div class="todo-container">
											<ul class="todo-body">
												<li class="todo-list">
													<div class="todo-info">
														<span class="dot blue"></span>
														<p>Team Meeting</p>
														<p>Thursday at 3:30 PM</p>
													</div>
												</li>
												<li class="todo-list">
													<div class="todo-info">
														<span class="dot orange"></span>
														<p>Make new page</p>
														<p>Wednesday at 10:30 AM</p>
													</div>
												</li>
												<li class="todo-list done">
													<div class="todo-info">
														<span class="dot yellow"></span>
														<p>Product launch</p>
														<p>Sunday at Baur Lac, Zurich</p>
													</div>
												</li>
												<li class="todo-list done">
													<div class="todo-info">
														<span class="dot green"></span>
														<p>Code Review</p>
														<p>Friday at 2:00PM</p>
													</div>
												</li>
												<li class="todo-list">
													<div class="todo-info">
														<span class="dot blue"></span>
														<p>Team Meeting</p>
														<p>Thursday at 3:30 PM</p>
													</div>
												</li>
												<li class="todo-list">
													<div class="todo-info">
														<span class="dot orange"></span>
														<p>Make new page</p>
														<p>Wednesday at 10:30 AM</p>
													</div>
												</li>
												<li class="todo-list">
													<div class="todo-info">
														<span class="dot yellow"></span>
														<p>Product launch</p>
														<p>Sunday at Baur Lac, Zurich</p>
													</div>
												</li>
												<li class="todo-list done">
													<div class="todo-info">
														<span class="dot green"></span>
														<p>Code Review</p>
														<p>Friday at 2:00PM</p>
													</div>
												</li>
												<li class="todo-list">
													<div class="todo-info">
														<span class="dot blue"></span>
														<p>Team Meeting</p>
														<p>Thursday at 3:30 PM</p>
													</div>
												</li>
												<li class="todo-list">
													<div class="todo-info">
														<span class="dot orange"></span>
														<p>Make new page</p>
														<p>Wednesday at 10:30 AM</p>
													</div>
												</li>
												<li class="todo-list">
													<div class="todo-info">
														<span class="dot yellow"></span>
														<p>Product launch</p>
														<p>Sunday at Baur Lac, Zurich</p>
													</div>
												</li>
												<li class="todo-list done">
													<div class="todo-info">
														<span class="dot green"></span>
														<p>Code Review</p>
														<p>Friday at 2:00PM</p>
													</div>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
							<div class="card h-340">
								<div class="card-header">
									<div class="card-title">Statistics</div>
								</div>
								<div class="card-body">
									<div class="customScroll5">
										<ul class="statistics">
											<li>
												<span class="stat-icon">
													<i class="icon-eye1"></i>
												</span>
												A new ticket opened.
											</li>
											<li>
												<span class="stat-icon">
													<i class="icon-thumbs-up1"></i>
												</span>
												That's A great idea!
											</li>
											<li>
												<span class="stat-icon">
													<i class="icon-star2"></i>
												</span>
												Tell us what you think.
											</li>
											<li>
												<span class="stat-icon">
													<i class="icon-shopping-bag1"></i>
												</span>
												A new item sold.
											</li>
											<li>
												<span class="stat-icon">
													<i class="icon-check-circle"></i>
												</span>
												Design approved.
											</li>
											<li>
												<span class="stat-icon">
													<i class="icon-clipboard"></i>
												</span>
												Assigned new task to Zyan.
											</li>
											<li>
												<span class="stat-icon">
													<i class="icon-eye1"></i>
												</span>
												A new ticket opened.
											</li>
											<li>
												<span class="stat-icon">
													<i class="icon-thumbs-up1"></i>
												</span>
												That's A great idea!
											</li>
											<li>
												<span class="stat-icon">
													<i class="icon-star2"></i>
												</span>
												Tell us what you think.
											</li>
											<li>
												<span class="stat-icon">
													<i class="icon-shopping-bag1"></i>
												</span>
												A new item sold.
											</li>
											<li>
												<span class="stat-icon">
													<i class="icon-check-circle"></i>
												</span>
												Design approved.
											</li>
											<li>
												<span class="stat-icon">
													<i class="icon-clipboard"></i>
												</span>
												Assigned new task to Zyan.
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="card h-340">
								<div class="card-header">
									<div class="card-title">Top Pages Visited</div>
								</div>
								<div class="card-body">
									<div class="customScroll5">
										<ul class="recent-links">
											<li>
												<a href="#">Bootstrap admin template</a>
											</li>
											<li>
												<a href="#">Images resources</a>
											</li>
											<li>
												<a href="#">Best admin templates 2020</a>
											</li>
											<li>
												<a href="#">Javascript libraries</a>
											</li>
											<li>
												<a href="#">Angular widgets</a>
											</li>
											<li>
												<a href="#">UX library</a>
											</li>
											<li>
												<a href="#">Bootstrap admin template</a>
											</li>
											<li>
												<a href="#">Images resources</a>
											</li>
											<li>
												<a href="#">Best admin templates 2020</a>
											</li>
											<li>
												<a href="#">Javascript libraries</a>
											</li>
											<li>
												<a href="#">Angular widgets</a>
											</li>
											<li>
												<a href="#">UX library</a>
											</li>
											<li>
												<a href="#">Bootstrap admin template</a>
											</li>
											<li>
												<a href="#">Images resources</a>
											</li>
											<li>
												<a href="#">Best admin templates 2020</a>
											</li>
											<li>
												<a href="#">Javascript libraries</a>
											</li>
											<li>
												<a href="#">Angular widgets</a>
											</li>
											<li>
												<a href="#">UX library</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div-->
					<!-- Row end -->

					<!-- Row start -->
					<div class="row gutters">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="card h-310">
								<div class="card-header">
									<div class="card-title">Top Keywords</div>
								</div>
								<div class="card-body d-flex">
									<div id="my_favorite_latin_words" class="w-100"></div>
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

		<!-- Polyfill JS -->
		<script src="<?php echo base_url('assets/'); ?>vendor/polyfill/polyfill.min.js"></script>

		<!-- Apex Charts -->
		<script src="<?php echo base_url('assets/'); ?>vendor/apex/apexcharts.min.js"></script>
		<script src="<?php echo base_url('assets/'); ?>vendor/apex/crm/compare-sales.js"></script>
		<script src="<?php echo base_url('assets/'); ?>vendor/apex/crm/compare-sales1.js"></script>
		<script src="<?php echo base_url('assets/'); ?>vendor/apex/crm/earnings.js"></script>

		<!-- jQcloud Keywords -->
		<script src="<?php echo base_url('assets/'); ?>vendor/jqcloud/jqcloud-1.0.4.min.js"></script>
		<script src="<?php echo base_url('assets/'); ?>vendor/jqcloud/custom-jqcloud.js"></script>

		<!-- Main JS -->
		<script src="<?php echo base_url('assets/'); ?>js/main.js"></script>

	</body>
</html>