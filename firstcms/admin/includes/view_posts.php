<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<style type = "text/css">
th, td , tr , table {padding:0; margin:0;}
th {border-left: 2px solid #333; border-bottom: 3px solid #333}
td {border-left: 2px solid #999 ;}
h2 (padding:10px;)
</style>
</head>
<body>
<table align="center" bgcolor="#FF999" width="780">
	<tr>
		<td colspan="8" align="center" bgcolor="#0099CC"><h2>View all posts here </h2> </td>
	</tr>
    <tr>
		<th>Post ID </th>
		<th>Title </th>
		<th>Author </th>
		<th>Image</th>
		<th>Comments</th>
		<th>Edit</th>
		<th>Delete</th>
	</tr>

<?php
include ("includes/database.php");

    $get_posts="select * from posts";
    
    $run_posts= mysql_query($get_posts);

    $i=1;

    while ($row_posts = mysql_fetch_array($run_posts)) {
    	$post_id=$row_posts['post_id'];
    	$post_title=$row_posts['post_title'];
    	$post_author=$row_posts['post_author'];
    	$post_image=$row_posts['post_image'];
?>
	<tr align="center">
		<td><?php echo $i++; ?> </td>
		<td><?php echo $post_title; ?> </td>
		<td><?php echo $post_author; ?> </td>
		<td><img src ="news_images/<?php echo $post_image; ?>" width="40 height ="40"> </td>
		<td>
			<?php
			$get_comments="select * from comments where post_id='$post_id'";

			$run_comments=mysql_query($get_comments);

			$count=mysql_num_rows($run_comments);
			echo $count;
			?>
		</td>
		<td><a href="index.php?edit_post=<?php echo $post_id; ?>">Edit</a></td>
		<td><a href="includes/delete_post.php?delete_post=<?php echo $post_id; ?>">Delete</a></td>
	</tr>
<?php }  ?>
</table>
</body>
</html>