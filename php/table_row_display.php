<?php 
	require("mysql_connect_sorting.php");

	$query = "SELECT leads_id, first_name, last_name, DATE(registered_datetime) AS registered_datetime, email FROM leads ";

	$results = fetch_all($query);

	  // 0 => 
   //  array (size=6)
   //    'leads_id' => string '1' (length=1)
   //    'first_name' => string 'Art' (length=3)
   //    'last_name' => string 'Lopez' (length=5)
   //    'registered_datetime' => string '2011-01-13 14:22:58' (length=19)
   //    'email' => string 'artlopez@gmail.com' (length=18)
   //    'site_id' => string '1' (length=1)

	foreach ($results as $row) 
	{
		?> 
		<tr>
			<td><?php echo $row['leads_id']; ?> </td>
			<td><?php echo $row['first_name']; ?> </td>
			<td><?php echo $row['last_name']; ?> </td>
			<td><?php echo $row['registered_datetime']; ?> </td>
			<td><?php echo $row['email']; ?> </td>
		</tr>
		<?php 
	}
 ?>