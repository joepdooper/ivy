// import * as swup from '../../../node_modules/swup/dist/Swup.umd.js';
//
// const swp = new Swup;
//
// swp.hooks.on('page:view', () => {
//   call_my_function("swupPageView");
// });
//
// swp.hooks.before('content:replace', () => {
// 	call_my_function("swupContentReplace");
// });

window.addEventListener('DOMContentLoaded', (event) => {
	document.querySelectorAll('[type=submit]').forEach(function(el){
		el.addEventListener("click", function(e) {
			setTimeout(function(){
				document.getElementById("loading-mode").checked = true;
			}, 500);
		});
	});
});
