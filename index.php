<?php
	
	ob_start(); // Output Buffering Start

	session_start();

	$pageTitle = 'HomePage';
	
	include 'init.php';
?>
	<div class="container">
		<h1 class="text-center">show all items</h1>
			<div class="row">
			<?php
				$allitems = get_all('*','items','WHERE approve =1','','item_ID','DESC');
				foreach ($allitems as $item) {
					echo '<div class="col-sm-6 col-md-3">';
						echo '<div class="thumbnail item-box">';
							echo '<span class="price-tag">$ '.$item['price'].'</span>';
							echo '<img src="img.png" alt="" class="img-responsive"/>';
							echo '<div class="caption">';
							 	echo '<h3><a href="items.php?itemid='.$item['item_ID'].'">'. $item['name'] .'</a></h3>';
							 	echo '<p>'. $item['description'] .'</p>';
							 	echo '<div class="date">'.$item['addDate'].'</div>';
							echo '</div>';
						echo '</div>';
					echo'</div>';
				}		
			?>
			</div>

	</div>
	}		
<?php
	include $tpl . 'footer.php'; 

	ob_end_flush(); // Release The Output

?>