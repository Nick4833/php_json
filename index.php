<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<script type="text/javascript" src="bootstrap/js/jquery.min.js"></script>
</head>
<script type="text/javascript">
	$(document).ready(function() {
		$("#addStudentdiv").show();
		$("#editStudentdiv").hide();
		showData();
		function showData() {
			$.get('student.json', function(response){
				if (response) {
					alert(JSON.stringify(response));
					var stuArray = response;
					var html = "";
					var j = 1;
					$.each(stuArray, function(index, el) {
						html += `<tr>
						<td>${j++}</td>
						<td>${el.name}</td>
						<td>${el.gender}</td>
						<td>${el.email}</td>
						<td>
							<button class="btn btn-primary btn-sm detail" data-id="${index}" data-name="${el.name}" data-gender="${el.gender}" data-email="${el.email}" data-address="${el.address}" data-profile="${el.profile}">Detail</button>
							<button class="btn btn-warning btn-sm edit" data-id=${index}>Edit</button>
							<button class="btn btn-danger btn-sm delete" data-id="${index}">Delete</button>
						</td>
						</tr>`;
					});
					$('tbody').html(html);
				}
			});
		}

		$("tbody").on('click', '.detail', function(event) {
			var id = $(this).data("id");
			var name = $(this).data("name");
			var gender = $(this).data("gender");
			var email = $(this).data("email");
			var address = $(this).data("address");
			var profile = $(this).data("profile");

			$("#stu_img").attr('src', profile);
			$("#stu_name").text("Name: " + name);
			$("#stu_email").text("Email: " + email);
			$("#stu_gender").text("Gender: " + gender);
			$("#stu_address").text("Address: " + address);

			$("#detailModal").modal("show");
		});

		$("tbody").on('click', '.delete', function(event) {
			var id = $(this).data("id");
			alert(id);
			var ans = confirm("Delete?");
			if(ans) {
				$.post('deletestudent.php', {id:id}, function(response) {
					showData();
				})
			}
		});


		$("tbody").on('click', '.edit', function(event) {
			$("#addStudentdiv").hide();
			$("#editStudentdiv").show();
			var id = $(this).data("id");
			$.get("student.json", function(response) {
				if(response) {
					var dataArr = response;

					var edit_name = dataArr[id].name;
					var edit_email = dataArr[id].email;
					var edit_gender = dataArr[id].gender;
					var edit_address = dataArr[id].address;
					var edit_profile = dataArr[id].profile;

					$("#edit_id").val(id);
					$("#edit_img").attr("src", edit_profile);
					$("#edit_name").val(edit_name);
					$("#edit_email").val(edit_email);
					$("#edit_address").val(edit_address);
					$("#old_photo").val(edit_profile);

					if(edit_gender == "Male") {
						$("#edit_male").prop("checked", "checked");
					}else {
						$("#edit_female").prop("checked", "checked");
					}
				}
			})

		});



	});
</script>
<body>

	<div class="modal" id="detailModal">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Student Detail</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	      	<div class="container">
	      		<div class="row">
	      			<div class="col-md-5">
	      				<img src="" id="stu_img" class="img-fluid">
	      			</div>
	      			<div class="col-md-7">
	      				<p id="stu_name"></p>
	      				<p id="stu_email"></p>
	      				<p id="stu_gender"></p>
	      				<p id="stu_address"></p>
	      			</div>
	      		</div>
	      	</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>


	<div class="container" id="addStudentdiv">
		<div class="row mt-5">
			<div class="col-12 text-center">
				<h1 class="display-4"> Add New Student </h1>
			</div>
		</div>

		<div class="row mt-5">
			<div class="col align-self-center">
				<form action="addStudent.php" method="POST" enctype="multipart/form-data">
					<div class="form-group row">
						<label for="profile" class="col-sm-2 col-form-label"> Profile </label>
					    <div class="col-sm-10">
					    	<input type="file"  id="profile" name="profile">
					    </div>
					</div>

					<div class="form-group row">
						<label for="name" class="col-sm-2 col-form-label"> Name </label>
					    <div class="col-sm-10">
					    	<input type="text" class="form-control" id="name" placeholder="Enter Name" name="name">
					    </div>
					</div>

					<div class="form-group row">
						<label for="name" class="col-sm-2 col-form-label"> Email </label>
					    <div class="col-sm-10">
					    	<input type="email" class="form-control" id="name" placeholder="Enter Email" name="email">
					    </div>
					</div>

					<fieldset class="form-group">
					    <div class="row">
					    	<legend class="col-form-label col-sm-2 pt-0"> Gender </legend>
					      
					      	<div class="col-sm-10">
					        
					        	<div class="form-check">
					          		<input class="form-check-input" type="radio" name="gender" id="male" value="Male" checked>
					          		<label class="form-check-label" for="male">
					            		Male
					          		</label>
					        	</div>
					        
					        	<div class="form-check">
					          		<input class="form-check-input" type="radio" name="gender" id="female" value="Female">
					          		<label class="form-check-label" for="female">
					            		Female
					          		</label>
					        	</div>
					        
					      </div>
					    </div>
					</fieldset>

					<div class="form-group row">
						<label for="address" class="col-sm-2 col-form-label"> Address </label>
					    <div class="col-sm-10">
					    	<textarea class="form-control" rows="5" name="address"></textarea>
					    </div>
					</div>

					<div class="form-group row">
					    <div class="col-sm-10">
					   		<button type="submit" class="btn btn-primary">
					   			SAVE
					   		</button>
					    </div>
					</div>


				</form>
			</div>
		</div>
	</div>


		<div class="container" id="editStudentdiv">
		<div class="row mt-5">
			<div class="col-12 text-center">
				<h1 class="display-4"> Edit Student </h1>
			</div>
		</div>

		<div class="row mt-5">
			<div class="col align-self-center">
				<form action="updatestudent.php" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="edit_id" id="edit_id" value="">
					<div class="form-group row">
						<label for="edit_profile" class="col-sm-2 col-form-label"> Profile </label>
					    <div class="col-sm-10">
					    	<input type="file"  id="edit_profile" name="edit_profile">
					    	<input type="hidden" name="old_photo" id="old_photo">
					    	<img src="" id="edit_img" width="100" height="100" class="d-block mt-1">
					    </div>
					</div>

					<div class="form-group row">
						<label for="edit_name" class="col-sm-2 col-form-label"> Name </label>
					    <div class="col-sm-10">
					    	<input type="text" class="form-control" id="edit_name" placeholder="Enter Name" name="edit_name">
					    </div>
					</div>

					<div class="form-group row">
						<label for="edit_email" class="col-sm-2 col-form-label"> Email </label>
					    <div class="col-sm-10">
					    	<input type="email" class="form-control" id="edit_email" placeholder="Enter Email" name="edit_email">
					    </div>
					</div>

					<fieldset class="form-group">
					    <div class="row">
					    	<legend class="col-form-label col-sm-2 pt-0"> Gender </legend>
					      
					      	<div class="col-sm-10">
					        
					        	<div class="form-check">
					          		<input class="form-check-input" type="radio" name="edit_gender" id="edit_male" value="Male" checked>
					          		<label class="form-check-label" for="edit_male">
					            		Male
					          		</label>
					        	</div>
					        
					        	<div class="form-check">
					          		<input class="form-check-input" type="radio" name="edit_gender" id="edit_female" value="Female">
					          		<label class="form-check-label" for="edit_female">
					            		Female
					          		</label>
					        	</div>
					        
					      </div>
					    </div>
					</fieldset>

					<div class="form-group row">
						<label for="edit_address" class="col-sm-2 col-form-label"> Address </label>
					    <div class="col-sm-10">
					    	<textarea class="form-control" rows="5" name="edit_address"></textarea>
					    </div>
					</div>

					<div class="form-group row">
					    <div class="col-sm-10">
					   		<button type="submit" class="btn btn-primary">
					   			UPDATE
					   		</button>
					    </div>
					</div>


				</form>
			</div>
		</div>
	</div>








	<table class="table table-bordered">
		<thead>
			<tr>
				<th> # </th>
				<th> Name </th>
				<th> Gender </th>
				<th> Email </th>
				<th> Action </th>
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>


<script type="text/javascript" src="bootstrap/js/jquery.min.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
	
</script>

</body>
</html>