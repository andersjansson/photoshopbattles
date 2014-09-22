<?php
	ini_set ('display_errors', true);
	error_reporting (E_ALL);

	define("__ROOT__", dirname(__FILE__));

	require_once(__ROOT__."/lib/main.php");

	sliding_session_start(600);
	
	$page = isset($_GET['page']) ? (pageExists($_GET['page'], "pages") ? $_GET['page'] : '404') : 'showposts' ;

	if (pageExists($page."_logic", "inc"))
		require_once(__ROOT__."/inc/".$page."_logic.php");

	require_once(__ROOT__."/pages/header.php");
	require_once(__ROOT__."/pages/menu.php");
	require_once(__ROOT__."/pages/".$page.".php");
	require_once(__ROOT__."/pages/footer.html");

	function pageExists($page, $folder){
		if (file_exists(__ROOT__."/".$folder."/".basename($page).".php"))
			return true;
		else
			return false; 
	}
?>