$(document).ready(function() {
	$(function() {
	    $( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
	  });

	//this resets the curent page to 1 and then submits the form after each keypress to get it to update as as you type.
	$('#search_form').keyup(function() {
		$('#hidden').val('1');
		$('#search_form').submit();
	});

	//this resets the current page to 1 and then submits the form after after you update the date fields.
	$('#date_from, #date_to').change(function() {
		$('#hidden').val('1');
		$('#search_form').submit();
	});

	//this is the function that happens on submit.  return false keeps it from going to the process page.  it will use the process page, but not actually take the user there.
	$('#search_form').submit(function(){
		$.post(
			$(this).attr('action'),
			$(this).serialize(),
			function(data){
				$('#results_table_body').html(data.table);
				$('#pages').html(data.pages);
				//this last one will take the value of the button, puts it into the hidden field and then submits.
				$('button').click(function() {
					$('#hidden').val($(this).attr('id'));
					$('#search_form').submit();
				});
			},
		"json"
		)
		return false;
	});

	//this automatically submits the form (and with blank fields it will load everything) on document ready. this means that the page does not need to query the database to get and display everything on page load.  it's the same thing that happens on key up above.
	$('#search_form').submit();
});
