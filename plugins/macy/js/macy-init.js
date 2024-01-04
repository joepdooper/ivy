if (document.getElementById("grid")) {
	var macy =  Macy({
		container: '#grid',
		trueOrder: false,
		waitForImages: true,
		debug: true,
		columns: 3,
		breakAt: {
			768: 2,
			480: 1
		}
	});
}

function reInitMacy(){
	window.setTimeout(() => {
		macy.reInit();
	}, 100);
}
function removeMacy(){
	window.setTimeout(() => {
		macy.remove();
	}, 100);
}

add_to_function("imageSrcPreview",reInitMacy);
add_to_function("savedSortedList",reInitMacy);
add_to_function("startSortingList",removeMacy);
add_to_function("YoutubePlayerReady",reInitMacy);
