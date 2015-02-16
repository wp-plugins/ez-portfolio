jQuery(document).ready(function($) {
	$(window).load(function() {
		/* initialize shuffle plugin */
		var $grid = $('#grid');
			 
		$grid.shuffle({
			itemSelector: '.item' // the selector for the items in the grid
		});

		$('#filter a').click(function (e) {
			e.preventDefault();
				 
			// set active class
			$('#filter a').removeClass('active');
			$(this).addClass('active');
				 
			// get group name from clicked item
			var groupName = $(this).attr('data-group');
				 
			// reshuffle grid
			$grid.shuffle('shuffle', groupName );
		});
	});	
});