<div class='MDEditor_body_actioncontainer_content_attachment'>
<?php
/**
 * Read language file
 */
$json = file_get_contents('../lang/' . $_GET['lang'] . '.json');
$lang = json_decode($json, true);

/**
 * Check action
 */
if (isset($_GET)) {
	if (isset($_GET['action']) && $_GET['action'] == 'delete') {
		$files = glob('../../attachment/*.*');

		foreach ($files as $file) {
			unlink($file);
		}
	}

	if (isset($_GET['action']) && $_GET['action'] == 'upload') {
		if (isset($_FILES)) {
			$_FILES['MDEditor_fileupload']['error'] == 0;
			
			if (file_exists('../../attachment/' . $_FILES['MDEditor_fileupload']['name'])) {
				$filename = explode('.', $_FILES['MDEditor_fileupload']['name']);
				$filename[0] = uniqid();
				$filename = implode('.', $filename);
			} else {
				$filename = $_FILES['MDEditor_fileupload']['name'];
			}

			move_uploaded_file($_FILES['MDEditor_fileupload']['tmp_name'], '../../attachment/' . $filename);
		}
	}
}

/**
 * Search directory for files
 */
$files = glob('../../attachment/*.*');
?>
	<h2 data-element='MDEditor_%ELEMENTNAME%_source_attachment_headline'></h2>

	<hr />

	<div data-element='MDEditor_%ELEMENTNAME%_source_attachment_fileupload_error' style='display: none;'></div>

	<form data-element='MDEditor_%ELEMENTNAME%_source_attachment_fileupload_form'>
		<b data-element='MDEditor_%ELEMENTNAME%_source_attachment_fileupload'></b><b>: </b><input data-element='MDEditor_%ELEMENTNAME%_source_attachment_fileupload_input' name='MDEditor_fileupload' type='file' style='display: inline;' />
	</form>

	<hr />
	
	<?php	
	if (count($files) > 0) {
		$i = 0;
		$j = 0;

		foreach ($files as $file) {
			if (substr($file, -4, 4) == '.jpg' || substr($file, -4, 4) == '.png' || substr($file, -4, 4) == '.gif') {
				$i++;
				$j++;

				if ($i == 1) {
					echo "<p><i data-element='MDEditor_%ELEMENTNAME%_source_attachment_content_images'></i><i>:</i></p>";
				}

				echo "<img id='MDEditor_attachment_" . $j . "' class='MDEditor_attachment_image tipNDelay' src='" . $_GET['path'] . str_replace('../../', '', $file) . "' alt='' onclick='mdeditorInsert(\"" . $j . "\");' data-insertType='image' data-file='" . $_GET['path'] . str_replace('../../', '', $file) . "' title='" . $lang['tooltip']['insert'] . "<br /><i class=\"fa fa-picture-o\"></i> <b>" . str_replace('../../attachment/', '', $file) . "</b>' />";
			}
		}

		$i = 0;

		foreach ($files as $file) {
			if (substr($file, -4, 4) == '.mp3' || substr($file, -4, 4) == '.wma' || substr($file, -4, 4) == '.wav') {
				$i++;
				$j++;

				if ($i == 1) {
					echo "<p><i data-element='MDEditor_%ELEMENTNAME%_source_attachment_content_audio'></i><i>:</i></p>";
				}

				$filename = explode('.', basename($file));
				$filename = '.' . $filename[count($filename)-1];
				echo "<div id='MDEditor_attachment_" . $j . "' class='MDEditor_attachment_placeholder tipN' onclick='mdeditorInsert(\"" . $j . "\");' data-insertType='link' data-file='" . $_GET['path'] . str_replace('../../', '', $file) . "' title='" . $lang['tooltip']['sethyperlink'] . "<br /><i class=\"fa fa-music\"></i> <b>" . str_replace('../../attachment/', '', $file) . "</b>'><p><i class='fa fa-music'></i></p><p>" . $filename . "</p></div>";
			}
		}

		$i = 0;

		foreach ($files as $file) {
			if (substr($file, -4, 4) == '.mp4' || substr($file, -4, 4) == '.avi' || substr($file, -4, 4) == '.3gp' || substr($file, -4, 4) == '.mov') {
				$i++;
				$j++;

				if ($i == 1) {
					echo "<p><i data-element='MDEditor_%ELEMENTNAME%_source_attachment_content_videos'></i><i>:</i></p>";
				}

				$filename = explode('.', basename($file));
				$filename = '.' . $filename[count($filename)-1];
				echo "<div id='MDEditor_attachment_" . $j . "' class='MDEditor_attachment_placeholder tipN' onclick='mdeditorInsert(\"" . $j . "\");' data-insertType='link' data-file='" . $_GET['path'] . str_replace('../../', '', $file) . "' title='" . $lang['tooltip']['sethyperlink'] . "<br /><i class=\"fa fa-video-camera\"></i> <b>" . str_replace('../../attachment/', '', $file) . "</b>'><p><i class='fa fa-video-camera'></i></p><p>" . $filename . "</p></div>";
			}
		}

		$i = 0;

		foreach ($files as $file) {
			if (substr($file, -4, 4) != '.jpg' && substr($file, -4, 4) != '.png' && substr($file, -4, 4) != '.gif' && substr($file, -4, 4) != '.mp3' && substr($file, -4, 4) != '.wma' && substr($file, -4, 4) != '.wav' && substr($file, -4, 4) != '.mp4' && substr($file, -4, 4) != '.avi' && substr($file, -4, 4) != '.3gp' && substr($file, -4, 4) != '.mov') {
				$i++;
				$j++;

				if ($i == 1) {
					echo "<p><i data-element='MDEditor_%ELEMENTNAME%_source_attachment_content_other'></i><i>:</i></p>";
				}

				$filename = explode('.', basename($file));
				$filename = '.' . $filename[count($filename)-1];
				echo "<div id='MDEditor_attachment_" . $j . "' class='MDEditor_attachment_placeholder tipN' onclick='mdeditorInsert(\"" . $j . "\");' data-insertType='link' data-file='" . $_GET['path'] . str_replace('../../', '', $file) . "' title='" . $lang['tooltip']['sethyperlink'] . "<br /><i class=\"fa fa-file\"></i> <b>" . str_replace('../../attachment/', '', $file) . "</b>'><p><i class='fa fa-file'></i></p><p>" . $filename . "</p></div>";
			}
		}
	} else {
		echo "<i data-element='MDEditor_%ELEMENTNAME%_source_attachment_content_empty'></i>";
	}
	?>

	<hr />

	<div style='text-align: right;'>
		<a data-element='MDEditor_%ELEMENTNAME%_source_attachment_content_button_deleteall' class='btn btn-danger'>
			<i class='fa fa-trash-o'></i> <span data-element='MDEditor_%ELEMENTNAME%_source_attachment_content_button_deleteall_span'></span>
		</a>
	</div>
</div>
<script type='text/javascript' language='javascript'>
	$("[data-element]").each(function () {
		$(this).mdeditorCreateElementID();
	});

	$('.tipN').tipsy({
		title: 'title',
		trigger: 'hover',
		html: true,
		gravity: 's'
	});

	$('.tipNDelay').tipsy({
		title: 'title',
		trigger: 'hover',
		html: true,
		gravity: 's',
		delayIn: 1000,
		fade: true
	});

	var elementName;
	var language;
	elementName = mdeditor.elementName;
	language = mdeditor.lang;

	function mdeditorReload (action, source) {
		if (action == 'delete') {
			$('#MDEditor_' + elementName + '_body_actioncontainer_content').empty().css('vertical-align', 'middle').html("<img class='MDEditor_ajaxloader' src='" + mdeditor.url + "img/ajax.gif' alt='AJAX load' />");
			$('#MDEditor_' + elementName + '_body_actioncontainer').fadeIn(200);
			$('#MDEditor_' + elementName + '_body_optioncontainer').fadeOut(200, function () {
				$('#MDEditor_' + elementName + '_body_optioncontainer_content').empty().css('vertical-align', 'top');
			});

			var language;
			language = mdeditor.lang;

			$.ajax({
				type: 'GET',
				url: mdeditor.url + 'core/source/attachment.php?path=' + mdeditor.url + '&lang=' + mdeditor.language + '&action=delete',
				data: 'returnData',
				success: function (returnData) {
					$('#MDEditor_' + elementName + '_body_actioncontainer_content').fadeOut(80, function () {
						$('#MDEditor_' + elementName + '_body_actioncontainer_content').empty().css('vertical-align', 'top').html(returnData).fadeIn(80);
					});
				},
				error: function () {
					$('#MDEditor_' + elementName + '_body_actioncontainer_content').fadeOut(80, function () {
						$('#MDEditor_' + elementName + '_body_actioncontainer_content').empty().css('vertical-align', 'top').html('<div class="MDEditor_body_actioncontainer_content_error"><div class="alert alert-danger"><i class="fa fa-info-circle"></i> ' + language.message.error + '</div></div>').fadeIn(80);
					});
				}
			});
		}

		if (action == 'upload') {
			var file;
			var filename;
			var filesize;
			var filetype;
			file = source.files[0];
			filename = file.name;
			filesize = file.size;
			filetype = file.type;

			var language;
			language = mdeditor.lang;

			if (filesize > mdeditor.maxUpload) {
				$('#MDEditor_' + mdeditor.elementName + '_source_attachment_fileupload_error').html('<div class="alert alert-danger"><i class="fa fa-info-circle"></i> ' + language.message.attachment.error + '</div>').fadeIn();
				return;
			}

			var formData = new FormData($('#MDEditor_' + mdeditor.elementName + '_source_attachment_fileupload_form')[0]);

			$('#MDEditor_' + elementName + '_body_actioncontainer_content').empty().css('vertical-align', 'middle').html("<img class='MDEditor_ajaxloader' src='" + mdeditor.url + "img/ajax.gif' alt='AJAX load' />");
			$('#MDEditor_' + elementName + '_body_actioncontainer').fadeIn(200);
			$('#MDEditor_' + elementName + '_body_optioncontainer').fadeOut(200, function () {
				$('#MDEditor_' + elementName + '_body_optioncontainer_content').empty().css('vertical-align', 'top');
			});

			$.ajax({
				type: 'POST',
				url: mdeditor.url + 'core/source/attachment.php?path=' + mdeditor.url + '&lang=' + mdeditor.language + '&action=upload',
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				success: function (returnData) {
					$('#MDEditor_' + elementName + '_body_actioncontainer_content').fadeOut(80, function () {
						$('#MDEditor_' + elementName + '_body_actioncontainer_content').empty().css('vertical-align', 'top').html(returnData).fadeIn(80);
					});
				},
				error: function () {
					$('#MDEditor_' + elementName + '_body_actioncontainer_content').fadeOut(80, function () {
						$('#MDEditor_' + elementName + '_body_actioncontainer_content').empty().css('vertical-align', 'top').html('<div class="MDEditor_body_actioncontainer_content_error"><div class="alert alert-danger"><i class="fa fa-info-circle"></i> ' + language.message.error + '</div></div>').fadeIn(80);
					});
				}
			});
		}
	}

	function mdeditorInsert (number) {
		if ($('#MDEditor_attachment_' + number).attr('data-insertType') == 'image') {
			$('#MDEditor_' + elementName + '_body_edit_textarea').textrange('insert', "![" + $('#MDEditor_attachment_' + number).attr('data-file').replace(mdeditor.url + 'attachment/', '') + "](" + $('#MDEditor_attachment_' + number).attr('data-file') + ")");
			$('#MDEditor_' + elementName + '_body_edit_textarea').textrange('set', $('#MDEditor_' + elementName + '_body_edit_textarea').textrange().end, 0);

			$('.tipsy').css('display', 'none');

			$('#MDEditor_' + elementName + '_body_actioncontainer').fadeOut(200, function () {
				$('#MDEditor_' + elementName + '_body_actioncontainer_content').empty().css('vertical-align', 'top');
			});
		}

		if ($('#MDEditor_attachment_' + number).attr('data-insertType') == 'link') {
			$('#MDEditor_' + elementName + '_body_edit_textarea').textrange('insert', "[" + $('#MDEditor_attachment_' + number).attr('data-file').replace(mdeditor.url + 'attachment/', '') + "](" + $('#MDEditor_attachment_' + number).attr('data-file') + ")");
			$('#MDEditor_' + elementName + '_body_edit_textarea').textrange('set', $('#MDEditor_' + elementName + '_body_edit_textarea').textrange().end, 0);

			$('.tipsy').css('display', 'none');

			$('#MDEditor_' + elementName + '_body_actioncontainer').fadeOut(200, function () {
				$('#MDEditor_' + elementName + '_body_actioncontainer_content').empty().css('vertical-align', 'top');
			});
		}
	}

	$('#MDEditor_' + elementName + '_source_attachment_headline').html(language.source.label.attachment.title);
	$('#MDEditor_' + elementName + '_source_attachment_fileupload').html(language.source.label.attachment.fileupload);
	$('#MDEditor_' + elementName + '_source_attachment_content_images').html(language.source.label.attachment.images);
	$('#MDEditor_' + elementName + '_source_attachment_content_audio').html(language.source.label.attachment.audio);
	$('#MDEditor_' + elementName + '_source_attachment_content_videos').html(language.source.label.attachment.videos);
	$('#MDEditor_' + elementName + '_source_attachment_content_other').html(language.source.label.attachment.other);
	$('#MDEditor_' + elementName + '_source_attachment_content_empty').html(language.source.label.attachment.empty);
	$('#MDEditor_' + elementName + '_source_attachment_content_button_deleteall_span').html(language.source.label.attachment.deleteall);

	$('#MDEditor_' + mdeditor.elementName + '_source_attachment_fileupload_input').off();
	$('#MDEditor_' + mdeditor.elementName + '_source_attachment_fileupload_input:file').change(function () {
		mdeditorReload('upload', this);
	});
	$('#MDEditor_' + mdeditor.elementName + '_source_attachment_content_button_deleteall').click(function () {
		mdeditorReload('delete');
	});
</script>
