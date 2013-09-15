<?php  

require("mysql_connect_sorting.php");

//if nothing is in post, redirect
if(!$_POST)
{
	header("Location: ../index.php");
}
else
{

	//start with a base query that can be added onto later. The base will pull everything, the stuff added on will filter.

	$query = "SELECT leads_id, first_name, last_name, DATE(registered_datetime) AS registered_datetime, email FROM leads";

	//create the same base for a count query
	$count_query = "SELECT count(*) FROM leads";

	//initialize an array that can be added onto.
	$query_add_ons = array();

	//do the same for the count query
	$count_add_ons = array();

	// for every POST item, add it's MYSQL text onto the search array.
	if($_POST['name'] != NULL)
	{

		$query_like_name = " first_name LIKE '{$_POST['name']}%' OR last_name LIKE '{$_POST['name']}%' ";


		$query_add_ons[] = $query_like_name;

	}
	if($_POST['date_from'] != NULL)
	{

		$query_date_from = " DATE(registered_datetime) >= '{$_POST['date_from']}' ";


		$query_add_ons[] = $query_date_from;

	}
	if($_POST['date_to'] != NULL)
	{

		$query_date_to = " DATE(registered_datetime) <= '{$_POST['date_to']}' ";

		$query_add_ons[] = $query_date_to;

	}

	//Build the final queries for search and count based on what may or may not have come through in POST.
	if($_POST['name'] != NULL or $_POST['date_from'] != NULL or $_POST['date_to'] != NULL)
	{
		//if more than one thing came in, do this to both the search and count queries.
		if(count($query_add_ons) > 0)
		{
			$query .= " WHERE" . $query_add_ons[0];

			$count_query .= " WHERE" . $query_add_ons[0];

			//we added the first item, now remove it from the array and never reference it again.
			$remove_first = array_shift($query_add_ons);

			//for what is left, do this to both the search and count queries.
			foreach ($query_add_ons as $row) 
			{
				$query .= " AND " . $row;
				$count_query .= " AND " . $row;
			}
		}
		//if only one thing came in, do this.
		else
		{
			$query .= " WHERE" . $query_add_ons[0];
			$count_query .= " WHERE" . $query_add_ons[0];
		} 
	}

	//now take the hidden ID field and do some math to figure out where in the list of results to start the display.
	$start = ($_POST['action'] * 10) - 10;

	//add the limit to the constructed results query
	$query .= " LIMIT {$start} ,10";

	//send the queries to the database and get the results.
	$results = fetch_all($query);

	$count_results = fetch_record($count_query);

	//turn the count results into an integer so math can be applied.
	$count = intval($count_results['count(*)']);

	//divide the count by 10 and round up.
	$page_count = ceil($count / 10);

	//initialize these for later
	$table_html = NULL;
	$data = array();
	$pages_html = NULL;

	//for each result, add a table row and tack it onto the end of the html variable.
	foreach ($results as $row) 
	{

		$table_html .= "
		<tr>
			<td>{$row['leads_id']}</td>
			<td>{$row['first_name']} </td>
			<td>{$row['last_name']} </td>
			<td>{$row['registered_datetime']} </td>
			<td>{$row['email']} </td>
		</tr>
		"; 
	}

	//create the html for the list of pages and add them to the pages variable made earlier.
	for($i = 1; $i <= $page_count; $i++)
	{
		$pages_html .= "<li><button type='button' id='{$i}'>{$i}</button></li>";
	}
	//put the count html and results html into a keyed array.
	$data['table'] = $table_html;
	$data['pages'] = $pages_html;

	//encode it into json for the script
	echo json_encode($data);
}
?>