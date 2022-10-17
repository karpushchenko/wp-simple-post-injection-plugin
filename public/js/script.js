// Frontend render of oldest posts
var wpspiApp = {
    init: function() {
        wpspiApp.config = {
			action: 'wpspi_get_posts',
		};
		// Get posts after init
		wpspiApp.getPosts();
    },

	// Get post data and trigger rendering
    getPosts: function() {
		jQuery.post( wpspiAjax.url, wpspiApp.config, function( result ) {
			if( result.success ){
				wpspiApp.renderPosts( result.data );
			}
		});
    },

	// Output post data in the end of <body> tag
	renderPosts: function( data ) {
		// Render posts if data is not empty
		if(data.length){
			let html = '';
			data.forEach(element => {
				html += `<article class="wpspi-post">${element}</article>`;
			});
			html = `<div class="wpspi-posts container">
			<h2>Oldest Posts</h2>
			${html}
			</div>`;
			jQuery('body').append( html );
		}
	},
};

// Init on document ready
jQuery( document ).ready( wpspiApp.init );
