g_category = 'office';

function retrieveProjects(_page, _category)
{
	// Update menu.
	$('a[title=' + g_category + ']').removeClass('but_pressed');
	$('a[title=' + _category + ']').addClass('but_pressed');
	
	// When changing page, category remains the same.
	if(_category != null)
		g_category = _category; 
	
	// Retrieve PRJ_PER_PAGE projects based on page and category.
	$.get(
		'project-list.php',
		{method: 'project-list', page : _page, category : g_category},
		function(data) {
			$('#project-list').html(data);
		}
	);
}