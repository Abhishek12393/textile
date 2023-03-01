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
						<li class="breadcrumb-item active">Letter Listing</li>
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
							<div class="card lobipanel-basic">
								<div class="card-header">
									<div class="card-title">Form Bundle Listing</div>
								</div>
								<div class="card-body">
								 
								<div class="table-responsive">
											<table id="basicExample2" class="table custom-table">
												<thead>
													<tr>
														<th>ID</th>
													 <th>RDO</th>
															<!--<th>ADO</th>
														<th>Photo & Signature</th>
														<th>Letter No</th>
														<th>No. of Form</th>
														<th>No. of Data Entry</th>
														<th>No. of Verified</th>
														<th>No. of Rejected</th>
														<th>No. of PDF Genrated</th>
														<th>Form Uploaded</th>
														<th>Letter Date</th>
														<th>Added Date</th>
														<th>Action</th> -->
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>data</td>
														<td>data</td>
												</tr>
													 
												</tbody>
											</table>
										</div>
								</div>

								<div class="table-container">
								<div class="t-header">Ajax --</div>
								<div class="table-responsive">
									<table id="table-listing" class="table custom-table">
										<thead>
										<tr>
												<th>First name</th>
												<th>Last name</th>
		 
										</tr>

										</thead>
			 
						    	</table>
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

		<!-- Data Tables -->
		<script src="<?php echo base_url('assets/'); ?>vendor/datatables/dataTables.min.js"></script>
		<script src="<?php echo base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap.min.js"></script>
		
		<!-- Custom Data tables -->
		<!-- <script src="<?php echo base_url('assets/'); ?>vendor/datatables/custom/custom-datatables.js"></script>
		<script src="<?php echo base_url('assets/'); ?>vendor/datatables/custom/fixedHeader.js"></script> -->

		<!-- Download / CSV / Copy / Print -->
		<!-- <script src="<?php echo base_url('assets/'); ?>vendor/datatables/buttons.min.js"></script>
		<script src="<?php echo base_url('assets/'); ?>vendor/datatables/jszip.min.js"></script>
		<script src="<?php echo base_url('assets/'); ?>vendor/datatables/pdfmake.min.js"></script>
		<script src="<?php echo base_url('assets/'); ?>vendor/datatables/vfs_<?php echo base_url('assets/'); ?>fonts/.js"></script>
		<script src="<?php echo base_url('assets/'); ?>vendor/datatables/html5.min.js"></script>
		<script src="<?php echo base_url('assets/'); ?>vendor/datatables/buttons.print.min.js"></script> -->


		<!-- Main JS -->
		<!-- <script src="<?php echo base_url('assets/'); ?>js/main.js"></script> -->

		<script>
			    // jQuery(window).load(function ()
					// {
					// 		var $ = jQuery;
					
					// 		table = $('#table-listing').DataTable({ 
					
					// 				"processing": true, //Feature control the processing indicator.
					// 				"serverSide": true, //Feature control DataTables' server-side processing mode.
					// 				"order": [], //Initial no order.,
							
					// 				// Load data for the table's content from an Ajax source
					// 				"ajax": {
					// 						"url": "<?php echo base_url()?>index.php?admin/ajax_form_bundle_listings",
					// 						"type": "POST"
					// 				},
					// 		"lengthMenu": [ 50, 100, 200, 400, 600 ],
					
					// 				//Set column definition initialisation properties.
					// 				"columnDefs": [
					// 				{ 
					// 						"targets": [ 3, 4, 5, 6, 7, 8, 11 ], //first column / numbering column
					// 						"orderable": false, //set not orderable
					// 				},
					// 				],
					
					// 		});
					// 		//alert('asdf');
					// 		$(".dataTables_wrapper select").select2({
					// 				minimumResultsForSearch: -1
					// 		});
						
					// });
				  
					$(document).ready(function () {
								$('#table-listing').DataTable( {
									
									processing: true,
									serverSide: true,
									"order": [], //Initial no order.,
									ajax: {
												url: '<?php echo base_url('/letters/ajax_form_bundle_listing'); ?>',
												dataSrc: 'data',
												type: "POST",
								 
											},
										columns:  [
											{ data: 'first_name' },
											{ data: 'last_name' } 
										],
										"drawCallback": function (settings) { 
											// Here the response
												var response = settings.json;
												console.log(response , 'response');
										},
										"lengthMenu": [ 5, 50, 100, 200, 400, 600 ],
										"iDisplayLength": 5,
										"language": {
											"lengthMenu": "Display _MENU_ Records Per Page",
											"info": "Showing Page _PAGE_ of _PAGES_",
										}
										 
										 
								} );
				
					})
					 
 
		</script>

	</body>
</html>