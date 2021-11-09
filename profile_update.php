<?php include "include/config.php";

$log = $_SESSION['user'];

if(!isset($_SESSION['user'])){
	$data->redirect('index');
}

$getUser = $data->callingData('users'," contact='$log'");

?>

<!DOCTYPE html>
<html>
<head>
	<?php include "include/link.php";?>
	<title>profile update</title>
</head>
<body>

	<form action="" method="post" enctype="multipart/form-data" class="col-lg-4">
		<div class="form-group">
		<label class="mt-3"><h4>UPDATE PROFILE PICTURE</h4></label>
		<input type="file" name="profile_image" class="mb-3">
		<input type="submit" name="update" value="update" class="btn btn-primary form-control">
		</div>
	</form>


	<?php
				if(isset($_POST['update'])){

					$edit_id = $getUser[0]['user_id'];
					
					//image work

					$image = $_FILES['profile_image']['name'];
					$tmp_img = $_FILES['profile_image']['tmp_name'];

					move_uploaded_file($tmp_img,"image/$image");

					$data->updateData('users',"image='$image'","user_id= '$edit_id'");
					if($data){
						echo "<script>alert('update ho gya')</script>";
					}
					else{
						echo "<script>alert('update nhi hua')</script>";
					}
					echo"<script>window.open('profile.php','_self')</script>";
				}
				?>
			

</body>
</html>

