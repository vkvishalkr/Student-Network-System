<?php require_once('include/config.php');

if(isset($_SESSION['user'])){
	$data->redirect('profile');
}

$nameError = $contactError = $dobError = $passwordError = $re_passwordError = "";

$loginContactError = $loginPasswordError = "";

$cond = isset($_POST['create_account'])

?>

<?php

if (isset($_POST['create_account'])) {
	
	$name = $_POST['name'];
	$contact = $_POST['contact'];
	$dob = $_POST['dob'];
	$password = $_POST['password'];

   

	if(!preg_match("/^[A-z ]{3,}$/", $name)){
		$nameError = "<p class = 'text-danger small my-0'>Name is Invalid</p>";
	}

	elseif(!preg_match("/^[0-9]{10}$/", $contact)){
		$contactError = "<p class = 'text-danger small my-0'>contact is Invalid it shpuld be in 10 digit</p>";
	}
	elseif($dob == ""){
		$dobError = "<p class = 'text-danger small my-0'>Date of birth is required</p>";
	}
	elseif(strlen($password)< 6){
		$passwordError = "<p class = 'text-danger small my-0'>password must be more than 6 character</p>";
	}
	elseif($password != $_POST['re_password']){
		$re_passwordError = "<p class =  'text-danger small my-0'>confirm password doesnt matched</p>";
	}

	else{
	    $encrypted_password = sha1($password);
		

	
		//database insert work 
	

		$query = "(name,contact,dob,password,status,) value ('$name','$contact','$dob','$encrypted_password','1')";

		$data->insertData('users',$query);

       	
}
}

?>



<!DOCTYPE html>
<html>
<head>
	<title>Stunet | Student Network</title>
	<?php require_once('include/link.php');?>
</head>
<body class="bg_light">
	<?php require_once('include/header.php');?>

	<div class="container mt-3">
		<div class="row">
			<div class="col-lg-8 mt-5">
				<div class="jumbotron">
					<h2 class="h2">Welcome in purnea student community</h2>
				    <h2 class="h5">Create an account and Explore more.</h2>
				    <ul>
					   <li>Study Materials</li>
					   <li>Share Moments</li>
					   <li>Play Quiz</li>
					   <li>Connect with Friends</li>
				    </ul>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="card mt-5">
					<div class="card-body">
						<h2 class="text-uppercase h5 text-secondary">Create an account 100% free</h2>

						<form action="index.php" method="post">
							<div class="form-group">
								<label for="name">Name</label>
								<input type="text" name="name" id="name" class="form-control" value="<?= ($cond)? $name : '';?>">
								<?= $nameError;?>
							</div>

							<div class="form-group">
								<label for="contact">Contact</label>
								<input type="number" name="contact" id="contact" class="form-control" value="<?= ($cond)? $contact : '';?>">
								<?= $contactError;?>
							</div>

							<div class="form-group">
								<label for="dob">Date of Birth</label>
								<input type="date" name="dob" id="dob" class="form-control">
								<?= $dobError;?>
							</div>

							<div class="form-group">
								<label for="name">Password</label>
								<input type="password" name="password" id="password" class="form-control">
								<?= $passwordError;?>
							</div>

							<div class="form-group">
								<label for="re_password">Retype Password</label>
								<input type="password" name="re_password" id="" class="form-control">
								<?= $re_passwordError;?>
							</div>



							<div class="form-group">
								<input type="submit" name="create_account"  class="btn btn-success btn-block">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>








	<?php require_once('include/footer.php');?>
</body>
</html>


<?php



if(isset($_POST['login'])){
	$contact = $_POST['contact'];
	$password = $_POST['password'];

	if(!preg_match("/^[0-9]{10}$/", $contact)){
		$loginContactError = "<p class = 'text-danger small my-0'>contact is Invalid it should be in 10 digit</p>";
	}
	
	elseif(strlen($password)< 6){
		$loginPasswordError = "<p class = 'text-danger small my-0'>password must be more than 6 character</p>";
	}

	else{
		$password = sha1($password);

	$result = $data->checkData('users',"contact='$contact' AND password='$password'");

	if ($result==true): 
		$_SESSION['user'] = $contact;
		$data->redirect('profile');
	else:
		echo "fail contact no & password is invalid";
	endif;
    
    }
}

?>