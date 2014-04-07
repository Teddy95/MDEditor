<?php
$path = dirname(__FILE__) . '/../';
require_once($path . 'markdown/Michelf/MarkdownExtra.inc.php');

use \Michelf\MarkdownExtra;
echo "<div class='MDEditor_body_actioncontainer_content_preview'>" . MarkdownExtra::defaultTransform($_GET['markup']) . "</div>";
?>