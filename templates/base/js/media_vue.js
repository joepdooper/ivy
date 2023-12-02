document.addEventListener('DOMContentLoaded', function () {

	var current_dir = window.location.pathname.replace(/[^/]*$/, '');
	var base_media_dir = 'media/upload';

	document.getElementById('showFile').innerHTML = "";

	const { createApp } = Vue

	createApp({
		mounted(){
			this.fetchDirecory(base_media_dir);
		},
		data() {
			return {
				message: null,
				base: false,
				previous: [],
				current: [],
				items: []
			}
		},
		methods: {
			async fetchDirecory(path){
				this.message = 'Fetching';
				await axios
				.get(current_dir + 'core/posts/get.media_list.php', {
					params: {
						dir: path
					}
				})
				.then(response => {
					// handle success
					console.log(response.data);
					this.previous = response.data.previous;
					this.items = response.data.items;
					this.current = response.data.current;
					this.base = (base_media_dir == response.data.current.dirname) ? true : false;
					this.message = null;
				})
				.catch(error =>{
					this.errors.push(error);
					console.log(error);
				});
			},
			showFile(path){
				this.message = 'Show file';
				console.log(path);
			}
		}
	}).mount('#vuemedialist')
});
