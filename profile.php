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
	<title>Profile</title>
	<?php include "include/link.php";?>
</head>
<body>
	<?php include "include/header.php";?>

	<div class="container-fluid mt-5">
		<div class="row pt-5">
			<div class="col-lg-2" style="position: fixed;left: 0;top: 60px;">
				<div class="card">
					<div class="card-body">
						<img src="image/<?= $getUser[0]['image'];?>" class="img-fluid rounded-circle mb-2" height="150px" width="150px">
						<a href="profile_update.php" class="btn btn-primary mt-2 mb-2">Update profile pic</a>
						<h1 class="h5 text-center"><?= $getUser[0]['name'];?></h1>
						<p class="small text-center"><?= $getUser[0]['contact'];?></p>

					</div>
				</div>
			</div>
			<div class="col-lg-6" style="position: absolute;left: 16%">
				<div class="card">
					<div class="card-header">Write Post</div>
					<div class="card-body">
						<form action="Profile.php" method="post" enctype="multipart/form-data">
							<textarea name="content" rows="6" class="form-control"></textarea>
							<input type="file" name="post_image" class="float-left mt-4">
							<input type="submit" name="write_post" class="mt-2 btn btn-primary float-right" value="Write post">
						</form>
					</div>
				</div>

				<?php
                //SELECT * FROM TABLE1 JOIN table2 ON table1.col = table2.col;
				$callingPost = $data->callingData('posts JOIN users ON posts.post_by = users.user_id ORDER BY posts.post_id DESC');

				foreach ($callingPost as $post): 
	
				?>

				<div class="card mt-5 shadow">
					<div class="card-header">
						<?= $post['name'];?>
					</div>
					
						<div class="card-body">
							 <p class="lead font-weight-bold"><?= $post['post_content'];?></p>

							 <?php if($post['post_image'] != ""): ?>
							 	<img src="image/<?php echo $post['post_image'];?>" class="w-100">
							 <?php endif;?>
						</div>

						<div class="card-footer">
							<div class="row mt-3">
								<div class="col">
									<a href="" class="btn btn-info" data-toggle="collapse" data-target="#comment<?= $post['post_id'];?>">Comments</a>
								</div>
								<div class="col">
									<form action="profile.php" method="post">
										<input type="hidden" name="post_id" value="<?= $post['post_id'];?>">
										
 
										<?php
										$post_id = $post['post_id'];
										$user_id = $getUser[0]['user_id'];

										if($data->checkData('postLike'," like_by='$user_id' AND like_on='$post_id'")){
											$btn = "bg-success text-white";
										}
										else{
											$btn = "bg-light";
										}
									
										?>

										<button type="submit" name="send_like" class="btn <?= $btn;?>">Like</button>

										
									</form>
								</div>
							</div>

							<div class="collapse" id="comment<?= $post['post_id'];?>">
								<div class="row mt-3">

									<?php
									$post_id = $post['post_id'];
									$commentCalling = $data->callingData('comments JOIN users ON Comments.user_id = users.user_id',"post_id='$post_id'");
									foreach ($commentCalling as $comment):
									?>
									<div class="col-lg-12 mb-2">
										<div class="card">
										  <div class="card-body">
										  	<p class="small py-0 my-0"><?= $comment['name'];?></p>
										  	<p class="small py-0 my-0"><?= date("D d-m-Y h:m:s A",strtotime($comment['timestamps']));?></p>
											<h6><?= $comment['content'];?></h6>
										  </div>
									    </div>
									</div>

								<?php endforeach;?>

									<form action="" method="post" class="form-inline">
										<input type="text" name="comment" class="form-control" size="74" placeholder="Write your comment">
										<input type="hidden" name="post_id" value="<?= $post['post_id'];?>">
										<input type="submit" name="comment_send" class="btn btn-danger" value="Go">
									</form>

							    </div>
							</div>

						</div>
				</div>
			<?php endforeach;?>


									<?php
									if(isset($_POST['comment_send'])){
										$comment = $_POST['comment'];
										$post_id = $_POST['post_id'];
										$user_id = $getUser[0]['user_id'];

										$query = $data->insertData("comments","(content,post_id,user_id)value('$comment','$post_id','$user_id')");

										if ($query==true) {
											$data->redirect('profile');
										}
									}
									?>
			

			</div>
			<div class="col-lg-2" style="position: fixed;right: 0;">
				advertisement
			</div>
			<div class="col-lg-2" style="position: fixed;right: 10%;">
				Friends
			</div>
		</div>
	</div>







	<?php include "include/footer.php";?>

</body>
</html>


<?php

if (isset($_POST['write_post'])) {
	$content = $_POST['content'];
	$post_by= $getUser[0]['user_id'];

	$post_image = $_FILES['post_image']['name'];

	$temp = $_FILES['post_image']['tmp_name'];

	move_uploaded_file($temp, "image/$post_image");

	$run = $data->insertData('posts',"(post_content,post_by,post_image) value ('$content','$post_by','$post_image')");

	if($run){
		$data->redirect('profile');
	}
}

if(isset($_POST['send_like'])){
	$post_id = $_POST['post_id'];
	$user_id = $getUser[0]['user_id'];

	if($data->checkData('postLike'," like_by='$user_id' AND like_on='$post_id'")==false){
		$query = $data->insertData("postLike","(like_by,like_on)value('$user_id','$post_id')");
	}
	else{
		$query = $data->deleteData("postLike","(like_by='$user_id' AND like_on='$post_id')");
	}

	$data->redirect('profile');
}

?>