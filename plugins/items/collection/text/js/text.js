function linkifyTextItems() {
	document.querySelectorAll('.item-text p').forEach(item_text =>
		{
			if(linkify.find(item_text.innerHTML).length){
				item_text.innerHTML = linkifyHtml(item_text.innerHTML);
			}
		}
	);
}

linkifyTextItems();
// add_to_function("swupPageView",linkifyTextItems);
