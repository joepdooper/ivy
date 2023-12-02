<script>
//if('serviceWorker' in navigator) {
//navigator.serviceWorker
//.register('service-worker.js')
//.then(function() { console.log("Service Worker Registered"); });
//}
</script>

<script>
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
</script>

<?php if($auth->isLoggedIn()): ?>
	<script>
	var grid = document.getElementById('grid');
	if(grid){
		var items = grid.children;
		var list = {};
		function setSortList() {
			for (var i = 0; i < items.length; i++) {
				var item = items[i];
				item.dataset.sort = i;
				list[i] = item.id.replace('item-', '');
			}
			return list;
		}
		setSortList();
		var sortable = Sortable.create(grid, {
			draggable: ".item",
			animation: 300,
			easing: "cubic-bezier(1, 0, 0, 1)",
			ghostClass: "ghost",
			filter: ".dissableSortable",
			preventOnFilter: true,
			onStart: function (evt) {
				call_my_function("startSortingList");
			},
			onUpdate: function (evt) {
				axios
				.post('item/sort/', {
					data: setSortList()
				})
				.then(response => {
					// console.log(response.data);
					call_my_function("savedSortedList");
				})
				.catch(error =>{
					console.log(error);
				});
			},
		});
	}
</script>
<?php endif; ?>

<script>
document.querySelectorAll('.item-text p').forEach(item_text =>
	{
		if(linkify.find(item_text.innerHTML).length){
			item_text.innerHTML = linkifyHtml(item_text.innerHTML);
		}
	}
);
</script>

<script>
window.addEventListener('DOMContentLoaded', (event) => {
	document.querySelectorAll('[type=submit]').forEach(function(el){
		el.addEventListener("click", function(e) {
			setTimeout(function(){
				document.getElementById("loading-mode").checked = true;
			}, 500);
		});
	});
});
</script>
