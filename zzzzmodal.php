<?php
  ob_start();
  //set title
  echo "<script>setTimeout(function(){var tts = document.getElementsByTagName(\"title\");if(tts.length > 0)tts[0].innerHTML=\"Patient Record\"; else {var tt0 = document.createElement(\"TITLE\"); tt0.innerHTML = \"My title\"; document.head.appendChild(tt0);}}, 200);</script>";

	// Redirect the user to login page if he is not logged in.
	/*if(!isset($_SESSION['loggedIn'])){
		header('Location: login.php');
		exit();
	}*/
  require_once "mainBackend.php";
  require_once('header.php');
  require_once('footer.html');

  $outpatient = new Hardware();
  $patientRecords = $outpatient->patientRecord();
  $getPatientRecords = $outpatient->getPatientRecord();
  $deletePatientRecords = $outpatient->deletePatientRecord();
  ob_end_flush();
?>
<br>

<div class="container-fluid">

	

	<!-- DataTales Example -->
	<div class="card shadow mb-4">

		<div class="card-header py-3 ">

			<!-- Page Heading -->
			<h5 class="mb-2 text-gray-800">Patient Records Table
				<a style="background-color: #ECAC3D; border-color: #ECAC3D;float: right;" href="opdform.php" class="btn btn-success pull-right"><i
					class="fa fa-plus"></i> Add New Patient
				</a>
			</h5>

		</div>
		<div class="card-body">
			<form method="POST" name="form" action="patientRecords.php">
				<div class="table">
					<table id="dataTable" class="table table-bordered table-hover" >
						<thead>
						<tr>
							<th>Case No.</th>
							<th>Last Name</th>
							<th>First Name</th>
							<th>Middle Name</th>
							<th>Gender</th>
							<th>Age</th>
							<th>Contact No.</th>
							<th>Date Added</th>
							<th class='text-center'>Action</th>
						</tr>
						</thead>
						<tbody>
						<?php if($patientRecords){ $counter = 0; ?>
							<?php foreach($patientRecords as $record): $counter += 1;?>
								<tr>
									<td><?= $record['pr_id'];?></td>
									<td><?= $record['pr_lname'];?></td>
									<td><?= $record['pr_fname'];?></td>
									<td><?= $record['pr_mname'];?></td>
									<td><?= $record['pr_gen'];?></td>
									<td><?= $record['pr_age'];?></td>
									<td><?= $record['pr_number'];?></td>
									<td><?= $record['pr_date'];?></td>
									<td width="13%" class='text-center'>
										<a href="patientRecordsView.php?pr_id=<?=$record['pr_id'];?>" class="mr-4" title="View Record" data-toggle="tooltip">
											<i class="fa fa-eye"></i></a>
										<a href="patientRecordsUpdate.php?pr_id=<?=$record['pr_id'];?>" class="mr-4" title="Update Record" data-toggle="tooltip">
											<i class="fa fa-edit"></i></a>	
										<div style="display: inline;" >
											<a href="#" onclick="$('.delete_id').val('<?=$record['pr_id'];?>')" 
											data-id="<?=$record['pr_id'];?>" data-toggle="modal"  data-target="#delPatientRecordModal"  
											title='Delete Record' >
												<i class="fas fa-trash-alt"></i></a>
											</a>
										</div>
										<!-- Delete Patient Record Modal-->
										<div class="modal fade" id="delPatientRecordModal" tabindex="-1" role="dialog" 
											aria-hidden="true">
											<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLabel">Delete Patient Record</h5>
												<button class="close" type="button" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">×</span>
												</button>
												</div>
												<div class="modal-body">
													<p>Are you sure you want to delete this record? </p>
													<input hidden name="delete_id" class="delete_id">
										
												</div>

												<div class="modal-footer">
													<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
													<button name="deletePatientRecord" onclick="deleteRecord()" type="submit" 
													class="btn btn-success btn-icon-split">
														<span class="icon text-white-100">Delete</span>
													</button>
												</div>
											</div>
											</div>
										</div>
											
									</td>
								</tr>
							<?php endforeach; ?>
						<?php } ?>
						</tbody>
					</table>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
	<i class="fas fa-angle-up"></i>
</a>






<script>
	function deleteRecord() {
	var id = $(".delete_id").val();

		$.ajax({
		url:"/delete.php",
		method:"POST",
		data:{
		id: id,
		},
		success:function(response) {
		
	},
	});
	} 
</script>