<?php

$total_rows="";

$post->table = 'post' ;
$stmt = $post->showAll('id') ;




$cat_id=filter_input(INPUT_GET,"cat");



if(filter_input(INPUT_GET,"cat")){
	$stmt = $post->showAll($cat_id,$from_record_num, $records_per_page);
	$total_rows=$post->countSelected($cat_id);
}else{           
	$stmt = $post->showAll($from_record_num, $records_per_page);
	$total_rows=$post->countAll();
}
	

?>

	<div class="entry col-12">
		<div class="grid-inner">
			<div class="entry-image">
				<img src="images/blog/standard/17.jpg">
			</div>
			<div class="entry-title">
				<h2><a href="post.php">This is a Standard post with a Preview Image</a></h2>
			</div>
			<div class="entry-meta">
				<ul>
					<li><i class="uil uil-schedule"></i> 10th February 2021</li>
					<li><a href="#"><i class="uil uil-user"></i> admin</a></li>
					<li><i class="uil uil-folder-open"></i> <a href="#">General</a>, <a href="#">Media</a></li>
					<li><a href="blog-single.html#comments"><i class="uil uil-comments-alt"></i> 13 Comments</a></li>
					<li><a href="#"><i class="uil uil-camera"></i></a></li>
				</ul>
			</div>
			<div class="entry-content">
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate, asperiores quod est tenetur in. Eligendi, deserunt, blanditiis est quisquam doloribus voluptate id aperiam ea ipsum magni aut perspiciatis rem voluptatibus officia eos rerum deleniti quae nihil facilis repellat atque vitae voluptatem libero at eveniet veritatis ab facere.</p>
				<a href="post.php" class="more-link">Read More</a>
			</div>
		</div>
	</div>

	<?php
	// page given in URL parameter, default page is one
	$page = filter_input(INPUT_GET,'page') ? filter_input(INPUT_GET,'page') : 1; 

	$cat="";
	$catString="";

	if(filter_input(INPUT_GET,"cat")){
		$cat=filter_input(INPUT_GET,"cat");
		$catHome="?cat=$cat";
		$catPages="&cat=$cat";
	}

	// set number of records per page
	$records_per_page = 5;
	
	// calculate for the query LIMIT clause
	$from_record_num = ($records_per_page * $page) - $records_per_page;

	echo "<ul class=\"pagination justify-content-center\">";
	
	// button for first page
	if($page>1){
		echo "<li class=\"page-item\"><a class=\"page-link\" href='blog.php' title='Go to the first page.'>";
			echo "First Page";
		echo "</a></li>";
	}

	// count all products in the database to calculate total pages
	$total_pages = ceil($total_rows / $records_per_page);
	
	// range of links to show
	$range = 2;
	
	// display links to 'range of pages' around 'current page'
	$initial_num = $page - $range;
	$condition_limit_num = ($page + $range)  + 1;
	
	for ($x=$initial_num; $x<$condition_limit_num; $x++) {
	
		// be sure '$x is greater than 0' AND 'less than or equal to the $total_pages'
		if (($x > 0) && ($x <= $total_pages)) {
	
			// current page
			if ($x == $page) {
				echo "<li class='active page-item'><a class=\"page-link\" href=\"blog.php$catHome\">$x </a></li>";
			}
	
			// not current page
			else {
				echo "<li class=\"page-item\"><a class=\"page-link\" href='?page=".$x.$catPages."'>$x</a></li>";
			}
		}
	}
	
	// button for last page
	if($page<$total_pages){
		echo "<l class=\"page-item\"><a class=\"page-link\" href='?page={$total_pages}$catPages' title='Last page is {$total_pages}.'>";
			echo "Last Page";
		echo "</a></li>";
	}
	
	echo "</ul>";
	?>


	<!-- Pager

	============================================= -->
	<!-- <div class="d-flex justify-content-between mt-5">
		<a href="#" class="btn btn-outline-secondary">&larr; Older</a>
		<a href="#" class="btn btn-outline-dark">Newer &rarr;</a>
	</div> -->
	<!-- .pager end -->
