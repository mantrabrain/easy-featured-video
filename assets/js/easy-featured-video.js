jQuery(function ($) {
	// Selecting video
	var easyFeaturedVideo = {
		init: function () {
			this.initPlyr();
		},
		initPlyr: function () {
			const players = Plyr.setup('[data-plyr="true"]');

//            var fvPlayer = new Plyr('.easy-featured-video');
		}
	};

	$(document).ready(function () {
		easyFeaturedVideo.init();
	});


});
