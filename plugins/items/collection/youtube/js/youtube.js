var tag = document.createElement('script');
tag.src = "https://www.youtube.com/player_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

function onYouTubePlayerAPIReady() {
  document.querySelectorAll('[data-youtube]').forEach(youtube_player =>
    {
      var ytplayer;
      ytplayer = new YT.Player(youtube_player.id, {
        videoId: youtube_player.dataset.youtube,
        events: {
          'onReady': onPlayerReady,
          'onStateChange': onPlayerStateChange
        }
      });
    }
  );
}

function onPlayerReady(event) {
  // call_my_function("YoutubePlayerReady");
}

function onPlayerStateChange(event) {
  // call_my_function("YoutubePlayerStateChange");
}
