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
						<li class="breadcrumb-item active">Bank Name Listing</li>
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
							<div class="custom-actions-btns mb-5">
								<!-- <a href="#" class="btn btn-primary">
									<i class="icon-export"></i> Export
								</a> -->
								<a href="./rwa/add_rwa" class="btn btn-success">
									<i class="icon-add"></i> Add New Bank
								</a>
							</div>
						</div>
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							
							<div class="table-container">
								<div class="t-header">Bank Name Listing</div>
								<div class="table-responsive">
									<table id="basicExample" class="table custom-table">
										<thead>
											<tr>
												<th>Bank Name</th>
												<th>Bank code</th>
												<th>Status</th>
												<th>Added Date</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($message as $m){ ?>
											<tr>
												<td><?php echo $m->bank_name == '' ?'--': $m->bank_name;  ?></td> 
                      <td><?php echo $m->bank_code == '' ?'--': $m->bank_code; ?></td>
											<td><?php //echo $m->is_active == '' ?'--': 'Active'; 
												echo 'Active'?></td> <!-- -->
										 
											<td><?php echo $m->create_date; ?></td>
											<td class="td-actions">
													<a href="<?php echo site_url("bankingName/edit/").$m->id; ?>" class="icon green" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit Row">
														<i class="icon-circle-with-minus"></i>
													</a>
													<a href="#" class="icon blue" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete Row">
														<i class="icon-cancel"></i>
													</a>
											</td>
 
											</tr>

											<?php } ?>
											 
										</tbody>
									</table>
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

		<!-- Data Tables -->
		<script src="<?php echo base_url('assets/'); ?>vendor/datatables/dataTables.min.js"></script>
		<script src="<?php echo base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap.min.js"></script>
		
		<!-- Custom Data tables -->
		<script src="<?php echo base_url('assets/'); ?>vendor/datatables/custom/custom-datatables.js"></script>
		<script src="<?php echo base_url('assets/'); ?>vendor/datatables/custom/fixedHeader.js"></script>

		<!-- Download / CSV / Copy / Print -->
		<script src="<?php echo base_url('assets/'); ?>vendor/datatables/buttons.min.js"></script>
		<script src="<?php echo base_url('assets/'); ?>vendor/datatables/jszip.min.js"></script>
		<script src="<?php echo base_url('assets/'); ?>vendor/datatables/pdfmake.min.js"></script>
		<script src="<?php echo base_url('assets/'); ?>vendor/datatables/vfs_<?php echo base_url('assets/'); ?>fonts/.js"></script>
		<script src="<?php echo base_url('assets/'); ?>vendor/datatables/html5.min.js"></script>
		<script src="<?php echo base_url('assets/'); ?>vendor/datatables/buttons.print.min.js"></script>


		<!-- Main JS -->
		<script src="<?php echo base_url('assets/'); ?>js/main.js"></script>

	</body>
</html>