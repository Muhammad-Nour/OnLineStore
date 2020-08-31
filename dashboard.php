<?php

	ob_start(); //output bufferig

	session_start();

	if (isset($_SESSION['Username'])) {

		$pageTitle = 'Dashboard';

		include 'init.php';

		/*GetLatest function for getting latest item added to DB*/
		$latest_users_count =  5; 
		$latestusers = get_latest('*','users','UserID',$latest_users_count);

		$latest_items_count =  5; 
		$latestitems = get_latest('*','items','item_ID',$latest_items_count);

		$latest_comments_count =  5; 
		$latestcomments = get_latest('*','comments','comment_ID',$latest_items_count);

/* 		Start 		Dashboard 		Page */

?>
	<div class="home-stat">
		<div class="container text-center">
			<h1>Dashboard</h1>
			<div class="row">

				<div class="col-md-3">
					<div class="stat st-mem">
						<i class="fa fa-users"></i>
						<div class="info">
							total members
							<span>
								<a href="members.php"><?php usercount('Username','users');?></a>
							</span>
						</div>
					</div>
				</div>

				<div class="col-md-3">
					<div class="stat st-pen">
						<i class="fa fa-user-plus"></i>
						<div class="info">
							pending members
							<span>
								<a href="members.php?page=pendding"><?php echo checkitem("RegStatus","users",0);?></a>
							</span>
						</div>
					</div>
				</div>

				<div class="col-md-3">
					<div class="stat st-itm">
						<i class="fa fa-tag"></i> 
						<div class="info">
							total items
							<span>
								<a href="items.php"><?php usercount('item_ID','items');?></a>
							</span>
						</div>
					</div>
				</div>

				<div class="col-md-3">
					<div class="stat st-com">
						<i class="fa fa-comments"></i>
						<div class="info">
							total comments
							<span>
								<a href="comments.php"><?php usercount('comment_ID','comments');?></a>
							</span>
						</div>
					</div>
				</div>

			</div>
		</div>	
	</div>

	<div class="latest">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-users"></i> Latest <?php echo $latest_users_count ;?> 
							Registerd Users
							<span class="toggle-info pull-right">
								<i class="fa fa-lg fa-minus"></i>
							</span>
						</div>
						<div class="panel-body">
							<ul class="list-unstyled latest-users">
								<?php

								if(! empty($latestusers)){
									foreach ($latestusers as $user)
										{
											echo '<li>';
												echo $user['Username'];
												echo '<a href="members.php?do=Edit&userid='.$user['UserID'].'">';
													echo '<span class="btn btn-success pull-right">';
														echo '<i class="fa fa-edit"></i>Edit'; 
														if($user['RegStatus']==0)
														{
															echo "<a href='members.php?do=Activate&userid="
															.$user['UserID']."'class='btn btn-info pull-right'>
															<i class='fa fa-check'></i> Activate<a>";
														}
													echo '</span>';
												echo '</a>';
											echo '</li>';
										}
									}else
										{
											echo "There's No Record To Show";
										} 

									?>	
							 </ul>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-tag"></i> Latest <?php echo $latest_users_count;?> 
							Items
							<span class="toggle-info pull-right">
								<i class="fa fa-lg fa-minus"></i>
							</span>
						</div>
						<div class="panel-body">
							<ul class="list-unstyled latest-items">
							<?php
								if(! empty($latestitems)){
								foreach ($latestitems as $item)
									{
										echo '<li>';
											echo $item['name'];
											echo '<a href="items.php?do=Edit&itemid='.$item['item_ID'].'">';
												echo '<span class="btn btn-success pull-right">';
													echo '<i class="fa fa-edit"></i>Edit';
													if($item['approve']==0)
													{
														echo "<a href='items.php?do=Approve&itemid="
														.$item['item_ID']."'class='btn btn-info pull-right'>
														<i class='fa fa-check'></i> approve<a>";
													}
												echo '</span>';
											echo '</a>';
										echo '</li>';
									}
								}else{
									echo "There's No Record To Show";
									} 
							?>	
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-comments"></i> Latest <?php echo $latest_comments_count ;?> 
							Comments
							<span class="toggle-info pull-right">
								<i class="fa fa-lg fa-minus"></i>
							</span>
						</div>
						<div class="panel-body">
							<?php
								$stmt = $con->prepare("	SELECT 
															comments.*,users.Username As username
														FROM 
															comments
														Inner join 
															users
														on 
															users.UserID = comments.user_id
														order by 
															comment_ID DESC 
														limit 
															$latest_comments_count");
							$stmt->execute();
							$comments = $stmt->fetchAll();
							if(! empty($comments)){
							foreach ($comments as $comment) 
								{
									echo "<div class=comment-box>";
										echo "<span class='member-name'>" . $comment['username'] . "</span>";
										echo "<p class='member-comment'>" . $comment['comment']  . "</p>";	 
									echo "</div>";		
								}
							}else{
								echo "There's No Record To Show";
								} 
						 	?> 
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php
/* 		End 		Dashboard 		Page */

		include $tpl . 'footer.php';

	}else{

		header('Location: index.php');

		exit();
	}


	ob_end_flush();
?>