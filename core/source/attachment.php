<div class='MDEditor_body_actioncontainer_content_attachment'>
<?php
/**
 * Read language file
 */
$json = file_get_contents('../lang/' . $_GET['lang'] . '.json');
$lang = json_decode($json, true);

/**
 * Error message configurations
 */
$errorDisplay = 'none';
$errorMsg = '';

/**
 * Check action
 */
if (isset($_GET)) {
	if (isset($_GET['action']) && $_GET['action'] == 'delete') {
		if (isset($_GET['file']) && is_array($_GET['file']) === true) {
			foreach ($_GET['file'] as $file) {
				unlink('../../attachment/' . basename($file));
			}
		} else {
			$files = glob('../../attachment/*.*');

			foreach ($files as $file) {
				unlink($file);
			}
		}
	}

	if (isset($_GET['action']) && $_GET['action'] == 'upload') {
		if (isset($_FILES)) {
			if($_FILES['MDEditor_fileupload']['error'] != 0) {
				$errorDisplay = 'block';
				$errorMsg = '<div class=\'alert alert-danger\'><i class=\'fa fa-warning\'></i> ' . $lang['message']['attachment']['error']['unknown'] . '</div>';
			} else {
				$badChars = array('!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '=', '+', '\\', '"', '\'', '®', '©', '/', '?', '~', '`', '´', '[', ']', '{', '}', '♥', '♀', '♂', ',', '♪', '♫', '«', '»', '“', '™', '•', '|');
				$_FILES['MDEditor_fileupload']['name'] = str_replace($badChars, '', $_FILES['MDEditor_fileupload']['name']);
				$_FILES['MDEditor_fileupload']['name'] = str_replace('–', '-', $_FILES['MDEditor_fileupload']['name']);
				$_FILES['MDEditor_fileupload']['name'] = str_replace(' ', '_', trim($_FILES['MDEditor_fileupload']['name']));

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
}

/**
 * Search directory for files
 */
$files = glob('../../attachment/*.*');
?>
	<h2 data-element='MDEditor_%ELEMENTNAME%_source_attachment_headline'></h2>

	<hr />

	<div data-element='MDEditor_%ELEMENTNAME%_source_attachment_fileupload_error' style='display: <?php echo $errorDisplay; ?>;'><?php echo $errorMsg; ?></div>

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

				echo "<div id='MDEditor_attachment_" . $j . "' class='MDEditor_attachment_image tipNDelay' style='background: url(\"" . $_GET['path'] . str_replace('../../', '', $file) . "\") center center;' onclick='mdeditorInsert(\"" . $j . "\");' data-insertType='image' data-marked='false' data-number='" . $j . "' data-file='" . $_GET['path'] . str_replace('../../', '', $file) . "' title='" . $lang['tooltip']['insert'] . "<br /><i class=\"fa fa-picture-o\"></i> <b>" . str_replace('../../attachment/', '', $file) . "</b>'></div>";
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
				echo "<div id='MDEditor_attachment_" . $j . "' class='MDEditor_attachment_placeholder tipN' onclick='mdeditorInsert(\"" . $j . "\");' data-insertType='link' data-marked='false' data-number='" . $j . "' data-file='" . $_GET['path'] . str_replace('../../', '', $file) . "' title='" . $lang['tooltip']['sethyperlink'] . "<br /><i class=\"fa fa-music\"></i> <b>" . str_replace('../../attachment/', '', $file) . "</b>'><p><i class='fa fa-file-audio-o'></i></p><p>" . $filename . "</p></div>";
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
				echo "<div id='MDEditor_attachment_" . $j . "' class='MDEditor_attachment_placeholder tipN' onclick='mdeditorInsert(\"" . $j . "\");' data-insertType='link' data-marked='false' data-number='" . $j . "' data-file='" . $_GET['path'] . str_replace('../../', '', $file) . "' title='" . $lang['tooltip']['sethyperlink'] . "<br /><i class=\"fa fa-video-camera\"></i> <b>" . str_replace('../../attachment/', '', $file) . "</b>'><p><i class='fa fa-file-video-o'></i></p><p>" . $filename . "</p></div>";
			}
		}

		$i = 0;

		foreach ($files as $file) {
			if (substr($file, -4, 4) == '.doc' || substr($file, -5, 5) == '.docx' || substr($file, -4, 4) == '.rtf' || substr($file, -4, 4) == '.txt') {
				$i++;
				$j++;

				if ($i == 1) {
					echo "<p><i data-element='MDEditor_%ELEMENTNAME%_source_attachment_content_word'></i><i>:</i></p>";
				}

				$filename = explode('.', basename($file));
				$filename = '.' . $filename[count($filename)-1];
				echo "<div id='MDEditor_attachment_" . $j . "' class='MDEditor_attachment_placeholder tipN' onclick='mdeditorInsert(\"" . $j . "\");' data-insertType='link' data-marked='false' data-number='" . $j . "' data-file='" . $_GET['path'] . str_replace('../../', '', $file) . "' title='" . $lang['tooltip']['sethyperlink'] . "<br /><i class=\"fa fa-pencil\"></i> <b>" . str_replace('../../attachment/', '', $file) . "</b>'><p><i class='fa fa-file-word-o'></i></p><p>" . $filename . "</p></div>";
			}
		}

		$i = 0;

		foreach ($files as $file) {
			if (substr($file, -4, 4) == '.xls' || substr($file, -5, 5) == '.xlsx') {
				$i++;
				$j++;

				if ($i == 1) {
					echo "<p><i data-element='MDEditor_%ELEMENTNAME%_source_attachment_content_excel'></i><i>:</i></p>";
				}

				$filename = explode('.', basename($file));
				$filename = '.' . $filename[count($filename)-1];
				echo "<div id='MDEditor_attachment_" . $j . "' class='MDEditor_attachment_placeholder tipN' onclick='mdeditorInsert(\"" . $j . "\");' data-insertType='link' data-marked='false' data-number='" . $j . "' data-file='" . $_GET['path'] . str_replace('../../', '', $file) . "' title='" . $lang['tooltip']['sethyperlink'] . "<br /><i class=\"fa fa-bar-chart-o\"></i> <b>" . str_replace('../../attachment/', '', $file) . "</b>'><p><i class='fa fa-file-excel-o'></i></p><p>" . $filename . "</p></div>";
			}
		}

		$i = 0;

		foreach ($files as $file) {
			if (substr($file, -4, 4) == '.ppt' || substr($file, -5, 5) == '.pptx') {
				$i++;
				$j++;

				if ($i == 1) {
					echo "<p><i data-element='MDEditor_%ELEMENTNAME%_source_attachment_content_powerpoint'></i><i>:</i></p>";
				}

				$filename = explode('.', basename($file));
				$filename = '.' . $filename[count($filename)-1];
				echo "<div id='MDEditor_attachment_" . $j . "' class='MDEditor_attachment_placeholder tipN' onclick='mdeditorInsert(\"" . $j . "\");' data-insertType='link' data-marked='false' data-number='" . $j . "' data-file='" . $_GET['path'] . str_replace('../../', '', $file) . "' title='" . $lang['tooltip']['sethyperlink'] . "<br /><i class=\"fa fa-bullhorn\"></i> <b>" . str_replace('../../attachment/', '', $file) . "</b>'><p><i class='fa fa-file-powerpoint-o'></i></p><p>" . $filename . "</p></div>";
			}
		}

		$i = 0;

		foreach ($files as $file) {
			if (substr($file, -4, 4) == '.pdf') {
				$i++;
				$j++;

				if ($i == 1) {
					echo "<p><i data-element='MDEditor_%ELEMENTNAME%_source_attachment_content_pdf'></i><i>:</i></p>";
				}

				$filename = explode('.', basename($file));
				$filename = '.' . $filename[count($filename)-1];
				echo "<div id='MDEditor_attachment_" . $j . "' class='MDEditor_attachment_placeholder tipN' onclick='mdeditorInsert(\"" . $j . "\");' data-insertType='link' data-marked='false' data-number='" . $j . "' data-file='" . $_GET['path'] . str_replace('../../', '', $file) . "' title='" . $lang['tooltip']['sethyperlink'] . "<br /><i class=\"fa fa-paper-plane-o\"></i> <b>" . str_replace('../../attachment/', '', $file) . "</b>'><p><i class='fa fa-file-pdf-o'></i></p><p>" . $filename . "</p></div>";
			}
		}

		$i = 0;

		foreach ($files as $file) {
			if (substr($file, -3, 3) == '.as' || substr($file, -4, 4) == '.bat' || substr($file, -2, 2) == '.c' || substr($file, -2, 2) == '.h' || substr($file, -3, 3) == '.cs' || substr($file, -4, 4) == '.cpp' || substr($file, -3, 3) == '.cc' || substr($file, -4, 4) == '.cxx' || substr($file, -4, 4) == '.c++' || substr($file, -4, 4) == '.hpp' || substr($file, -4, 4) == '.h++' || substr($file, -4, 4) == '.inl' || substr($file, -4, 4) == '.ipp' || substr($file, -3, 3) == '.cp' || substr($file, -2, 2) == '.C' || substr($file, -3, 3) == '.hh' || substr($file, -4, 4) == '.css' || substr($file, -5, 5) == '.html' || substr($file, -4, 4) == '.htm' || substr($file, -6, 6) == '.xhtml' || substr($file, -4, 4) == '.inc' || substr($file, -4, 4) == '.tpl' || substr($file, -5, 5) == '.tmpl' || substr($file, -3, 3) == '.hs' || substr($file, -5, 5) == '.json' || substr($file, -3, 3) == '.js' || substr($file, -5, 5) == '.java' || substr($file, -3, 3) == '.md' || substr($file, -2, 2) == '.m' || substr($file, -4, 4) == '.php' || substr($file, -3, 3) == '.pl' || substr($file, -3, 3) == '.py' || substr($file, -3, 3) == '.rb' || substr($file, -5, 5) == '.rxml' || substr($file, -4, 4) == '.sql' || substr($file, -4, 4) == '.xml') {
				$i++;
				$j++;

				if ($i == 1) {
					echo "<p><i data-element='MDEditor_%ELEMENTNAME%_source_attachment_content_code'></i><i>:</i></p>";
				}

				$filename = explode('.', basename($file));
				$filename = '.' . $filename[count($filename)-1];
				echo "<div id='MDEditor_attachment_" . $j . "' class='MDEditor_attachment_placeholder tipN' onclick='mdeditorInsert(\"" . $j . "\");' data-insertType='link' data-marked='false' data-number='" . $j . "' data-file='" . $_GET['path'] . str_replace('../../', '', $file) . "' title='" . $lang['tooltip']['sethyperlink'] . "<br /><i class=\"fa fa-code\"></i> <b>" . str_replace('../../attachment/', '', $file) . "</b>'><p><i class='fa fa-file-code-o'></i></p><p>" . $filename . "</p></div>";
			}
		}

		$i = 0;

		foreach ($files as $file) {
			if (substr($file, -4, 4) == '.zip' || substr($file, -4, 4) == '.tar' || substr($file, -4, 4) == '.rar' || substr($file, -4, 4) == '.iso' || substr($file, -3, 3) == '.gz') {
				$i++;
				$j++;

				if ($i == 1) {
					echo "<p><i data-element='MDEditor_%ELEMENTNAME%_source_attachment_content_archives'></i><i>:</i></p>";
				}

				$filename = explode('.', basename($file));
				$filename = '.' . $filename[count($filename)-1];
				echo "<div id='MDEditor_attachment_" . $j . "' class='MDEditor_attachment_placeholder tipN' onclick='mdeditorInsert(\"" . $j . "\");' data-insertType='link' data-marked='false' data-number='" . $j . "' data-file='" . $_GET['path'] . str_replace('../../', '', $file) . "' title='" . $lang['tooltip']['sethyperlink'] . "<br /><i class=\"fa fa-archive\"></i> <b>" . str_replace('../../attachment/', '', $file) . "</b>'><p><i class='fa fa-file-zip-o'></i></p><p>" . $filename . "</p></div>";
			}
		}

		$i = 0;

		foreach ($files as $file) {
			if (substr($file, -4, 4) != '.jpg' && substr($file, -4, 4) != '.png' && substr($file, -4, 4) != '.gif' && substr($file, -4, 4) != '.mp3' && substr($file, -4, 4) != '.wma' && substr($file, -4, 4) != '.wav' && substr($file, -4, 4) != '.mp4' && substr($file, -4, 4) != '.avi' && substr($file, -4, 4) != '.3gp' && substr($file, -4, 4) != '.mov' && substr($file, -4, 4) != '.doc' && substr($file, -5, 5) != '.docx' && substr($file, -4, 4) != '.rtf' && substr($file, -4, 4) != '.txt' && substr($file, -4, 4) != '.xls' && substr($file, -5, 5) != '.xlsx' && substr($file, -4, 4) != '.ppt' && substr($file, -5, 5) != '.pptx' && substr($file, -4, 4) != '.pdf' && substr($file, -4, 4) != '.zip' && substr($file, -4, 4) != '.tar' && substr($file, -4, 4) != '.rar' && substr($file, -4, 4) != '.iso' && substr($file, -3, 3) != '.gz' && substr($file, -3, 3) != '.as' && substr($file, -4, 4) != '.bat' && substr($file, -2, 2) != '.c' && substr($file, -2, 2) != '.h' && substr($file, -3, 3) != '.cs' && substr($file, -4, 4) != '.cpp' && substr($file, -3, 3) != '.cc' && substr($file, -4, 4) != '.cxx' && substr($file, -4, 4) != '.c++' && substr($file, -4, 4) != '.hpp' && substr($file, -4, 4) != '.h++' && substr($file, -4, 4) != '.inl' && substr($file, -4, 4) != '.ipp' && substr($file, -3, 3) != '.cp' && substr($file, -2, 2) != '.C' && substr($file, -3, 3) != '.hh' && substr($file, -4, 4) != '.css' && substr($file, -5, 5) != '.html' && substr($file, -4, 4) != '.htm' && substr($file, -6, 6) != '.xhtml' && substr($file, -4, 4) != '.inc' && substr($file, -4, 4) != '.tpl' && substr($file, -5, 5) != '.tmpl' && substr($file, -3, 3) != '.hs' && substr($file, -5, 5) != '.json' && substr($file, -3, 3) != '.js' && substr($file, -5, 5) != '.java' && substr($file, -3, 3) != '.md' && substr($file, -2, 2) != '.m' && substr($file, -4, 4) != '.php' && substr($file, -3, 3) != '.pl' && substr($file, -3, 3) != '.py' && substr($file, -3, 3) != '.rb' && substr($file, -5, 5) != '.rxml' && substr($file, -4, 4) != '.sql' && substr($file, -4, 4) != '.xml') {
				$i++;
				$j++;

				if ($i == 1) {
					echo "<p><i data-element='MDEditor_%ELEMENTNAME%_source_attachment_content_other'></i><i>:</i></p>";
				}

				$filename = explode('.', basename($file));
				$filename = '.' . $filename[count($filename)-1];
				echo "<div id='MDEditor_attachment_" . $j . "' class='MDEditor_attachment_placeholder tipN' onclick='mdeditorInsert(\"" . $j . "\");' data-insertType='link' data-marked='false' data-number='" . $j . "' data-file='" . $_GET['path'] . str_replace('../../', '', $file) . "' title='" . $lang['tooltip']['sethyperlink'] . "<br /><i class=\"fa fa-file\"></i> <b>" . str_replace('../../attachment/', '', $file) . "</b>'><p><i class='fa fa-file-o'></i></p><p>" . $filename . "</p></div>";
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

	var elementName;
	var language;
	elementName = mdeditor.elementName;
	language = mdeditor.lang;

	function mdeditorReload (action, source) {
		if (action == 'delete') {
			var markedFiles;
			markedFiles = '';

			$('[data-marked="true"]').each(function () {
				markedFiles += "&file[]=" + $(this).attr('data-file');
			});

			$('#MDEditor_' + elementName + '_body_actioncontainer_content').empty().css('vertical-align', 'middle').html("<img class='MDEditor_ajaxloader' src='" + mdeditor.url + "img/ajax.gif' alt='AJAX load' />");
			$('#MDEditor_' + elementName + '_body_actioncontainer').fadeIn(200);
			$('#MDEditor_' + elementName + '_body_optioncontainer').fadeOut(200, function () {
				$('#MDEditor_' + elementName + '_body_optioncontainer_content').empty().css('vertical-align', 'top');
			});

			var language;
			language = mdeditor.lang;

			$.ajax({
				type: 'GET',
				url: mdeditor.url + 'core/source/attachment.php?path=' + mdeditor.url + '&lang=' + mdeditor.language + '&action=delete' + markedFiles,
				data: 'returnData',
				success: function (returnData) {
					$('#MDEditor_' + elementName + '_body_actioncontainer_content').fadeOut(80, function () {
						$('#MDEditor_' + elementName + '_body_actioncontainer_content').empty().css('vertical-align', 'top').html(returnData).fadeIn(80);
					});
				},
				error: function () {
					$('#MDEditor_' + elementName + '_body_actioncontainer_content').fadeOut(80, function () {
						$('#MDEditor_' + elementName + '_body_actioncontainer_content').empty().css('vertical-align', 'top').html('<div class="MDEditor_body_actioncontainer_content_error"><div class="alert alert-danger"><i class="fa fa-warning"></i> ' + language.message.error + '</div></div>').fadeIn(80);
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
				$('#MDEditor_' + mdeditor.elementName + '_source_attachment_fileupload_error').html('<div class="alert alert-danger"><i class="fa fa-warning"></i> ' + language.message.attachment.error.max + '</div>').fadeIn();
				return;
			}

			var filenameArray;
			var fileExtension;
			filenameArray = filename.split('.');
			fileExtension = filenameArray[filenameArray.length-1];

			for (var i = 0; i < mdeditor.notUpload.length; i++) {
				if (fileExtension == mdeditor.notUpload[i]) {
					$('#MDEditor_' + mdeditor.elementName + '_source_attachment_fileupload_error').html('<div class="alert alert-danger"><i class="fa fa-warning"></i> ' + language.message.attachment.error.not + '</div>').fadeIn();
					return;
				}
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
						$('#MDEditor_' + elementName + '_body_actioncontainer_content').empty().css('vertical-align', 'top').html('<div class="MDEditor_body_actioncontainer_content_error"><div class="alert alert-danger"><i class="fa fa-warning"></i> ' + language.message.error + '</div></div>').fadeIn(80);
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

	$('[data-marked]').off();
	$('[data-marked]').mousedown(function (e) {
		if (e.which == 3) {
			var marked;
			var number;
			marked = $(this).attr('data-marked');
			number = $(this).attr('data-number');

			if (marked == 'false') {
				$(this).attr('data-marked', 'true');
				$(this).css('border-color', '#ff9500');
				$('#MDEditor_attachment_' + number).addClass('MDEditor_addition');
				$('#MDEditor_attachment_' + number).addClass('MDEditor_addition');
			}

			if (marked == 'true') {
				$(this).attr('data-marked', 'false');
				$(this).css('border-color', '#f5f5f5');
				$('#MDEditor_attachment_' + number).removeClass('MDEditor_addition');
				$('#MDEditor_attachment_' + number).removeClass('MDEditor_addition');
			}
		}
	}).bind('contextmenu', function (e) {
		return false;
	});

	$('#MDEditor_' + elementName + '_source_attachment_headline').html(language.source.label.attachment.title);
	$('#MDEditor_' + elementName + '_source_attachment_fileupload').html(language.source.label.attachment.fileupload);
	$('#MDEditor_' + elementName + '_source_attachment_content_images').html(language.source.label.attachment.images);
	$('#MDEditor_' + elementName + '_source_attachment_content_audio').html(language.source.label.attachment.audio);
	$('#MDEditor_' + elementName + '_source_attachment_content_videos').html(language.source.label.attachment.videos);
	$('#MDEditor_' + elementName + '_source_attachment_content_word').html(language.source.label.attachment.word);
	$('#MDEditor_' + elementName + '_source_attachment_content_excel').html(language.source.label.attachment.excel);
	$('#MDEditor_' + elementName + '_source_attachment_content_powerpoint').html(language.source.label.attachment.powerpoint);
	$('#MDEditor_' + elementName + '_source_attachment_content_pdf').html(language.source.label.attachment.pdf);
	$('#MDEditor_' + elementName + '_source_attachment_content_archives').html(language.source.label.attachment.archives);
	$('#MDEditor_' + elementName + '_source_attachment_content_code').html(language.source.label.attachment.code);
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

	$(document).ready(function () {
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
	});
</script>