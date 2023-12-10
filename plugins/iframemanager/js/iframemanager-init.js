(function(){

  var manager = iframemanager();

  manager.run({
    currLang: 'en',
    services : {

      youtube : {
        embedUrl: 'https://www.youtube-nocookie.com/embed/{data-id}',
        thumbnailUrl: 'https://i3.ytimg.com/vi/{data-id}/hqdefault.jpg',
        iframe : {
          allow : 'accelerometer; encrypted-media; gyroscope; picture-in-picture; fullscreen;',
        },
        cookie : {
          name : 'cc_youtube'
        },
        languages : {
          en : {
            notice: 'This content is hosted by a third party. By showing the external content you accept the <a rel="noreferrer" href="https://www.youtube.com/t/terms" title="Terms and conditions" target="_blank">terms and conditions</a> of youtube.com.',
            loadBtn: 'Load video',
            loadAllBtn: 'Don\'t ask again'
          }
        }
      },

      vimeo : {
        embedUrl: 'https://player.vimeo.com/video/{data-id}',
        thumbnailUrl: function(id, setThumbnail){
          
          var url = "https://vimeo.com/api/v2/video/" + id + ".json";
          var xhttp = new XMLHttpRequest();

          xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              var src = JSON.parse(this.response)[0].thumbnail_large;
              setThumbnail(src);
            }
          };

          xhttp.open("GET", url, true);
          xhttp.send();
        },
        iframe : {
          allow : 'accelerometer; encrypted-media; gyroscope; picture-in-picture; fullscreen;',
        },
        cookie : {
          name : 'cc_vimeo'
        },
        languages : {
          'en' : {
            notice: 'This content is hosted by a third party. By showing the external content you accept the <a rel="noreferrer" href="https://vimeo.com/terms" title="Terms and conditions" target="_blank">terms and conditions</a> of vimeo.com.',
            loadBtn: 'Load video',
            loadAllBtn: 'Don\'t ask again'
          }
        }
      }

    }
  });

})();
