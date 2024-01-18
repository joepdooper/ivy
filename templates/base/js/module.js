window.addEventListener('DOMContentLoaded', (event) => {
	document.querySelectorAll('[type=submit]').forEach(function(el){
		el.addEventListener("click", function(e) {
			setTimeout(function(){
				document.getElementById("loading-mode").checked = true;
			}, 500);
		});
	});
});
