<?php

function write_message ($message_info)
{
	$id_user = 0;

	if (isset($_SESSION["id_user"])){
		$id_user = intval($_SESSION["id_user"]);
	}

	$delete_link = "";

	if ($id_user == $message_info["id_user"]){
		$delete_link = <<<EOD
<p class="message-delete"><a href="dashboard_message_delete.php?id_message={$message_info["id_message"]}">Eliminar</a></p>
EOD;
	}


	$edit_link = "";
	if ($id_user == $message_info["id_user"]){
		$edit_link = <<<EOD
<p class="message-edit"><a href="dashboard_message_edit.php?id_message={$message_info["id_message"]}">Editar</a></p>
EOD;
	}

	echo <<<EOD
<section class="message">
<h3><a href="profile.php?user={$message_info["username"]}">{$message_info["name"]}</a></h3>
<p class="message-text">{$message_info["message"]}</p>
<p class="message-date">{$message_info["post_time"]}</p>
{$delete_link}
{$edit_link}
</section>
EOD;
}

?>
