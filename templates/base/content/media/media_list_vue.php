<div v-if="!base" class="previous">
	<div class="definition" @dblclick="fetchDirecory(previous.dirname)">
		<div class="icon">
			<?php echo file_get_contents(_PUBLIC_PATH . 'media/icon/' . "feather/chevron-left.svg");?>
		</div>
		<div class="text">
			<strong>{{ previous.basename }}</strong>
		</div>
	</div>
</div>

<div v-if="!base" class="parent">
	<div class="definition">
		<div class="icon">
			<?php echo file_get_contents(_PUBLIC_PATH . 'media/icon/' . "feather/folder.svg"); ?>
		</div>
		<div class="text">
			<strong>{{ current.basename }}</strong>
		</div>
	</div>
</div>

<ul>
	<li v-for="item in items">

		<div class="{{ item.type }}">
			<div class="definition" @dblclick="item.type === 'dir' ? fetchDirecory(item.path) : showFile(item.path)">

				<div v-if="item.type === 'dir'" class="icon">
					<?php echo file_get_contents(_PUBLIC_PATH . 'media/icon/' . "feather/folder.svg"); ?>
				</div>

				<div v-if="item.filetype === 'image'" class="icon">
					<?php echo file_get_contents(_PUBLIC_PATH . 'media/icon/' . "feather/image.svg"); ?>
				</div>

				<div v-if="item.filetype === 'audio'" class="icon">
					<?php echo file_get_contents(_PUBLIC_PATH . 'media/icon/' . "feather/music.svg"); ?>
				</div>

				<div v-if="item.filetype === 'video'" class="icon">
					<?php echo file_get_contents(_PUBLIC_PATH . 'media/icon/' . "feather/video.svg"); ?>
				</div>

				<div v-if="item.filetype === 'file'" class="icon">
					<?php echo file_get_contents(_PUBLIC_PATH . 'media/icon/' . "feather/file.svg"); ?>
				</div>

				<div class="text">
					<strong>{{ item.name }}<span v-if="item.type === 'file'">.{{ item.extension }}</span></strong>
				</div>

				<div v-if="item.type === 'file'" class="info">
					{{ item.date }} - {{ item.size }}
				</div>

				<!-- {{ item.type }} {{ item.name }} {{ item.path }} -->
			</div>
		</div>

	</li>
</ul>
