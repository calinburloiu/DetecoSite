function retrievePortfolioAds()
{ 
	// Retrieve projects from server.
	$.get(
		'ajax.php',
		{method: 'portfolio-ads', ms: '' + (new Date().getTime())},
		function(data) {
			$('#portfolio-ads').html(data);
		}
	);
	
	// Schedule next retrieval.
	setTimeout("retrievePortfolioAds()", 30000);
}