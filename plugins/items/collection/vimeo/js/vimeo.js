document.addEventListener('DOMContentLoaded', function () {

  document.querySelectorAll('[data-vimeo]').forEach(vimeo_player =>
    {
      const options = {
        id: vimeo_player.dataset.vimeo,
        loop: false,
        dnt: true,
        responsive: true,
        title: false,
        byline: false,
        portrait: false
      }
      const vimeo = new Vimeo.Player(vimeo_player.id, options);
      vimeo.on('loaded', function() {
        console.log('Loaded video with id: ' + vimeo_player.id);
        if (typeof macy != "undefined") {
					macy.reInit();
				}
    	});
      vimeo.on('play', function() {
    		console.log('Played video with id: ' + vimeo_player.id);
    	});
    }
  );

});
