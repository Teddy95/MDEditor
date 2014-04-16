<?php
$files = glob('../../attachment/*.jpg');
?>
<div class='MDEditor_body_actioncontainer_content_attachment'>
	<h2>Attachment</h2>

	<hr />

	<form>
		<b>Upload file: </b><input type='file' style='display: inline;' />
	</form>

	<hr />
	
	<?php
	foreach ($files as $file) {
		echo "<img class='MDEditor_attachment_image' src='" . str_replace('../../', '', $file) . "' alt='' />";
	}
	?>
</div>