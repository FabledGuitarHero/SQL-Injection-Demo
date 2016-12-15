<?php
  ini_set('display_errors',1);
  ini_set('display_startup_errors',1);
  error_reporting(-1);

  include_once('cms.php');
  $obj = new cms('localhost', 'root', 'root', 'cmsDatabase');
  $obj->connect();

  if ($_POST)
    $obj->write($_POST);

  $action = isset($_GET['action']) ? $_GET['action'] : "";
  if ($action === 'write')
    echo $obj->display_admin();
  else if ($action){
    $obj->render($action);
  }
  else {
    //Page ID 2 is main page
    $obj->render(2);
  }

?>
