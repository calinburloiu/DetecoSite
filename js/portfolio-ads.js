function retrievePortfolioAds()
{ 
	// Retrieve projects from server.
	$.get(
		'/portfolio-ads.php',
		{method: 'portfolio-ads', ms: '' + (new Date().getTime())},
		function(data) {
			$('#portfolio-ads').html(data);
		}
	);
	
	// Schedule next retrieval.
	setTimeout("retrievePortfolioAds()", 30000);
}