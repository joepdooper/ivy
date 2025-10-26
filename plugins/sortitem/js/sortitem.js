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
        call_my_function("savedSortedList");
      })
      .catch(error =>{
        console.log(error);
      });
    },
  });
}
