function onYouTubePlayerAPIReady() {
    document.querySelectorAll('[data-youtube]').forEach(youtube_player => {
        new YT.Player(youtube_player.id, {
            videoId: youtube_player.dataset.youtube,
            events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange
            }
        });
    });
}

function onPlayerReady(event) {
  // call_my_function("YoutubePlayerReady");
}

function onPlayerStateChange(event) {
  // call_my_function("YoutubePlayerStateChange");
}
