<!DOCTYPE html>
<html lang="en">  
	<head>
		<title>Ajax Sorting</title>
		<?php include("php/header.php"); ?>
	</head>
	<body>
		<div class="span6" id="container">
			<div id="top">
				<form class="form-inline" id="search_form" action="php/process_ajax_sorting.php" method="post">
					<input id="hidden" type="hidden" name="action" value="1">
					<label for="name">Name:</label>
					<input class="input-medium search-query" id="name" type="text" name="name">
					<label for="date_to">From:</label>					
					<input class="input-mini datepicker" id="date_from" type="text" name="date_from">
					<label for="date_from">To:</label>
					<input class="input-mini datepicker" id="date_to" type="text" name="date_to">
					<!-- <input type="submit" value="Submit"> -->
				</form>
				<div class="pagination pagination-mini pagination-right">
					<ul id='pages'>
						<!-- this gets filled in with the process page and javascript -->
					</ul>
				</div>
			</div>
			<div>
				<table class="table table-bordered table-striped table-condensed" id="ajax_sorting_table">
					<thead>
						<tr>
							<th>ID</th>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Registered</th>
							<th>Email</th>
						</tr>
					</thead>
					<tbody id="results_table_body">
						<!-- this is populated on page load and json -->
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>