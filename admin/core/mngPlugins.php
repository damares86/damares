<?php


##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################


require __DIR__ . "/coreConfig.php";

if (filter_input(INPUT_POST, "new")) {

  if ($_FILES["zip_file"]["name"]) {
    $filename = $_FILES["zip_file"]["name"];
    $source = $_FILES["zip_file"]["tmp_name"];
    $type = $_FILES["zip_file"]["type"];


    $name = explode(".", $filename);
    $accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
    foreach ($accepted_types as $mime_type) {
      if ($mime_type == $type) {
        $okay = true;
        break;
      }
    }

    $continue = strtolower($name[1]) == 'zip' ? true : false;
    if (!$continue) {
      header("Location: ../index.php?p=allPlugins&msg=pluginUploadFormatErr");
      exit;
    }

    $path = "../plugins/";
    if (!is_dir($path)) {
      mkdir($path);
      chmod($path, 0777);
    }

    $target_path = "../plugins/" . $filename;  // change this to the correct site path


    if (move_uploaded_file($source, $target_path)) {
      $zip = new ZipArchive();
      $x = $zip->open($target_path);

      $folder = "../plugins/";
      if ($x === true) {
        $zip->extractTo($folder); // change this to the correct site path
        $zip->close();

        $plugin->chmod_R($folder, 0777);

        unlink($target_path);
      }

      require $folder . $name[0] . '/config.php';

      $plugin->pluginname = $pluginname;
      $plugin->description = $description;

      if ($plugin->insert(['pluginname', 'description'])) {
        header("Location: ../index.php?p=allPlugins&msg=pluginUploadSucc");
        exit;
      } else {
        header("Location: ../index.php?p=allPlugins&err=pluginDbErr");
        exit;
      }
    } else {
      header("Location: ../index.php?p=allPlugins&err=pluginUploadErr");
      exit;
    }
  }
}

$op = filter_input(INPUT_GET, "op");

$idPlugin = filter_input(INPUT_GET, "idPlugin");
$plugin->id = $idPlugin;
$pluginFolder = $plugin->showPluginnameById();

$path = "../plugins/$pluginFolder";

include "$path/starter.php";
$exclude = array('..', '.', 'alert', 'func', '.gitkeep');

if ($op == "add") {

  // create table

  $error = 0;
  $errorPerm = 0;
  if ($query_create_table) {
    if (!$db->query($query_create_table)) {
      $error++;
    }
  }

  echo "error create table: " . $error . "<br>";

  if (isset($parent_table)) {
    for ($i = 0; $i < count($parent_table); $i++) {
      $section->link = $parent_table[$i]['link'];
      $section->label = $parent_table[$i]['label'];
      $section->icon = $parent_table[$i]['icon'];

      if (!$section->insertParent()) {
        $error++;
      }

      echo "error insert parent: " . $error . "<br>";


      // get the section parent inserted
      $section->table = 'sectionParent';
      $section->link = $parent_table[$i]['link'];
      $stmt = $section->showAllWhere('id', ['link']);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      extract($row);

      // get the permission for the user that added the plugin
      $rolessection->table = 'rolesSection';
      $rolessection->role_id = $_SESSION['role_id'];
      $stmt1 = $rolessection->showAllWhere('id', ['role_id']);
      $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
      extract($row1);

      $permissions = explode(',', $row1['section_id']);
      $permissions[] = $row['id'];

      $permissions_str = implode(',', $permissions);

      $rolessection->section_id = $permissions_str;

      // set permission for the user that added the plugin
      if (!$rolessection->update(['section_id'], 'role_id')) {
        $errorPerm++;
      }

      echo "error perm parent user: " . $errorPerm . "<br>";


      // set permission for the root user
      if ($_SESSION['role_id'] != 1) {
        $rolessection->table = 'rolesSection';
        $rolessection->section_id = $permissions_str;
        $rolessection->role_id = 1;
        if (!$rolessection->update(['section_id'], 'role_id')) {
          $errorPerm++;
        }

        echo "error perm parent root: " . $errorPerm . "<br>";
      }
    }
  }

  $row2 = $section->showByLink($link_parent, "sectionParent");

  if ($row2) {
    $pluginname_db = $row2['link'];
  } else {
    $pluginname_db = $link_parent;
  }

  if (isset($child_table)) {


    for ($i = 0; $i < count($child_table); $i++) {
      $section->parent_id = $row2['id'];

      $section->link = $child_table[$i]['link'];
      $section->label = $child_table[$i]['label'];
      $section->icon = $child_table[$i]['icon'];

      if (!$section->insertChild()) {
        $error++;
      }

      echo "error insert child: " . $error . "<br>";


      // get the section parent inserted
      $section->table = 'sectionChild';
      $section->link = $child_table[$i]['link'];
      $stmt = $section->showAllWhere('id', ['link']);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      extract($row);

      // get the permission for the user that added the plugin
      $rolessection->table = 'rolesSectionChild';
      $rolessection->role_id = $_SESSION['role_id'];
      $stmt1 = $rolessection->showAllWhere('id', ['role_id']);
      $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
      extract($row1);

      $permissions = explode(',', $row1['section_id']);
      $permissions[] = $row['id'];

      $permissions_str = implode(',', $permissions);

      $rolessection->section_id = $permissions_str;

      // set permission for the user that added the plugin
      if (!$rolessection->update(['section_id'], 'role_id')) {
        $errorPerm++;
      }
      echo "error perm child user: " . $errorPerm . "<br>";

      // set permission for the root user
      if ($_SESSION['role_id'] != 1) {
        $rolessection->table = 'rolesSectionChild';
        $rolessection->section_id = $permissions_str;
        $rolessection->role_id = 1;
        if (!$rolessection->update(['section_id'], 'role_id')) {
          $errorPerm++;
        }
        echo "error perm child root: " . $errorPerm . "<br>";
      }
    }
  }

  $plugin->installed = 1;
  $plugin->active = 1;
  $plugin->pluginname = $pluginname;

  echo "pluginname: " . $pluginname;

  if (!$plugin->update(['installed', 'active'], 'pluginname')) {
    $error++;
  }

  echo "error update installed: " . $error . "<br>";

  // copy assets files
  foreach (glob("$path/assets/*") as $row) {
    $item = pathinfo($row);

    if (copy($path . '/assets/' . $item['basename'] . '', '../assets/css/' . $item['basename'] . '')) {
      chmod('../assets/css/' . $item['basename'] . '', 0777);
    } else {
      $error++;
    }
  }


  // copy class files
  foreach (glob("$path/class/*") as $row) {
    $item = pathinfo($row);

    if (copy($path . '/class/' . $item['basename'] . '', '../class/' . $item['basename'] . '')) {
      chmod('../class/' . $item['basename'] . '', 0777);
    } else {
      $error++;
    }
  }



  // copy core files
  foreach (scandir("$path/core/") as $row) {
    $item = pathinfo($row);
    if (!in_array($item['basename'], $exclude)) {
      if (copy($path . '/core/' . $item['basename'] . '', '' . $item['basename'] . '')) {
        chmod('' . $item['basename'] . '', 0777);
      } else {
        $error++;
      }
    }
  }


  // copy inc files
  $scan = scandir($path . '/inc');

  foreach ($scan as $folder) {
    if (!in_array($folder, $exclude)) {
      if (copy($path . '/inc/' . $folder . '', '../inc/' . $folder . '')) {
        chmod('../inc/' . $folder . '', 0777);
      } else {
        $error++;
      }
    }
  }

  // copy inc/func files
  foreach (glob("$path/inc/func/*") as $row) {
    $item = pathinfo($row);

    if (copy($path . '/inc/func/' . $item['basename'] . '', '../inc/func/' . $item['basename'] . '')) {
      chmod('../inc/func/' . $item['basename'] . '', 0777);
    } else {
      $error++;
    }
  }

  // copy inc/settings files
  foreach (glob("$path/settings/*") as $row) {
    $item = pathinfo($row);

    if (copy($path . '/settings/' . $item['basename'] . '', '../inc/func/' . $item['basename'] . '')) {
      chmod('../inc/func/' . $item['basename'] . '', 0777);
    } else {
      $error++;
    }
  }

  // copy script files
  foreach (glob("$path/script/*") as $row) {
    $item = pathinfo($row);

    if (copy($path . '/script/' . $item['basename'] . '', '../script/' . $item['basename'] . '')) {
      chmod('../script/' . $item['basename'] . '', 0777);
    } else {
      $error++;
    }
  }

  // copy locale files
  $scan = scandir($path . '/locale');
  foreach ($scan as $folder) {
    if (is_dir("$path/locale/$folder") && !in_array($folder, $exclude)) {

      // copy locale files
      foreach (glob("$path/locale/$folder/*") as $row) {
        $item = pathinfo($row);

        if (copy($path . '/locale/' . $folder . '/' . $item['basename'] . '', '../locale/' . $folder . '/' . $item['basename'] . '')) {
          chmod('../locale/' . $folder . '/' . $item['basename'] . '', 0777);
        } else {
          $error++;
        }
      }
    }
  }


  // copy manual files
  foreach (glob("$path/manual/*") as $row) {
    $item = pathinfo($row);

    if (copy($path . '/manual/' . $item['basename'] . '', '../manual/' . $item['basename'] . '')) {
      chmod('../manual/' . $item['basename'] . '', 0777);
    } else {
      $error++;
    }
  }

  // copy frontend files
  foreach (glob("$path/frontend/*") as $row) {
    $item = pathinfo($row);

    if (copy($path . '/frontend/' . $item['basename'] . '', '../../' . $item['basename'] . '')) {
      chmod('../../' . $item['basename'] . '', 0777);
    } else {
      $error++;
    }
  }

  // copy uploads files
  foreach (glob("$path/uploads/*") as $row) {
    $item = pathinfo($row);

    if (copy($path . '/uploads/' . $item['basename'] . '', '../uploads/' . $item['basename'] . '')) {
      chmod('../uploads/' . $item['basename'] . '', 0777);
    } else {
      $error++;
    }
  }
  echo "error on copy: " . $error . "<br>";


  unlink("../inc/class_initialize.php");
  if ($error == 0) {

    $perm = '' ;
    if($errorPerm>0){
      $perm = '&err=pluginPerm' ;
    }
    header("Location: ../index.php?p=allPlugins&msg=pluginAdd$perm");
    exit;
  } else {
    header("Location: ../index.php?p=allPlugins&err=pluginAddErr");
    exit;
  }
} else if ($op == "dis") {

  $error = 0;
  $errorPerm = 0;

  $pluginId = filter_input(INPUT_GET, 'idPlugin');
  $plugin->id = $pluginId;
  $stmt = $plugin->showAllWhere('id', ['id']);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  extract($row);
  $pluginname = $row['pluginname'];

  if (!$db->query("UPDATE " . $prefix . "plugins SET active = 0 WHERE pluginname = '$pluginname'")) {
    $error++;
  }

  if ($child_table) {

    $childSection = [];
    $permissions_child_updated = [];

    for ($i = 0; $i < count($child_table); $i++) {

      $section->link = $child_table[$i]['link'];
      $section->table = 'sectionChild';
      $stmt1 = $section->showAllWhere('id', ['link']);
      $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
      extract($row1);

      $childSection[] = $row1['id'];

      if (!$section->deleteByLink("sectionChild")) {
        $error++;
      }
    }

    // get the permission for the user that disabled the plugin
    $rolessection->table = 'rolesSectionChild';
    $rolessection->role_id = $_SESSION['role_id'];
    $stmt2 = $rolessection->showAllWhere('id', ['role_id']);
    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
    extract($row2);

    $permissions = explode(',', $row2['section_id']);


    foreach ($permissions as $item) {
      if (!in_array($item, $childSection)) {
        $permissions_child_updated[] = $item;
      }
    }
  }

  $rolessection->table = 'rolesSectionChild';
  $rolessection->role_id = $_SESSION['role_id'];
  !is_null($perm_child_str) ? $perm_child_str = implode(',', $permissions_child_updated) : $perm_child_str = '';
  $rolessection->section_id = $perm_child_str;

  // set permission for the user that disabled the plugin
  if (!$rolessection->update(['section_id'], 'role_id')) {
    $errorPerm++;
  }

  // set permission for the root user
  if ($_SESSION['role_id'] != 1) {
    $rolessection->table = 'rolesSectionChild';
    $rolessection->role_id = 1;
    $rolessection->section_id = $perm_child_str;
    if (!$rolessection->update(['section_id'], 'role_id')) {
      $errorPerm++;
    }
  }

  $parentSection = [];
  $permissions_parent_updated = [];

  if ($parent_table) {
    for ($i = 0; $i < count($parent_table); $i++) {
      $section->link = $parent_table[$i]['link'];
      $section->table = 'sectionParent';
      $stmt3 = $section->showAllWhere('id', ['link']);
      $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
      extract($row3);

      $parentSection[] = $row3['id'];

      if (!$section->deleteByLink("sectionParent")) {
        $error++;
      }
    }

    // get the permission for the user that disabled the plugin
    $rolessection->table = 'rolesSection';
    $rolessection->role_id = $_SESSION['role_id'];
    $stmt4 = $rolessection->showAllWhere('id', ['role_id']);
    $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
    extract($row4);

    $permissions = explode(',', $row4['section_id']);


    foreach ($permissions as $item) {
      if (!in_array($item, $parentSection)) {
        $permissions_parent_updated[] = $item;
      }
    }
  }

  $rolessection->table = 'rolesSection';
  $rolessection->role_id = $_SESSION['role_id'];
  !is_null($perm_parent_str) ? $perm_parent_str = implode(',', $permissions_child_updated) : $perm_parent_str = '';
  $rolessection->section_id = $perm_parent_str;

  // set permission for the user that disabled the plugin
  if (!$rolessection->update(['section_id'], 'role_id')) {
    $errorPerm++;
  }

  // set permission for the root user
  if ($_SESSION['role_id'] != 1) {
    $rolessection->table = 'rolesSection';
    $rolessection->role_id = 1;
    $rolessection->section_id = $perm_parent_str;
    if (!$rolessection->update(['section_id'], 'role_id')) {
      $errorPerm++;
    }
  }

  $err_perm_msg = '';
  if ($errorPerm > 0) {
    $err_perm_msg = '&err=errPermPlugin';
  }

  if ($error == 0) {
    header("Location: ../index.php?p=allPlugins&msg=pluginDis$err_perm_msg ");
    exit;
  } else {
    header("Location: ../index.php?p=allPlugins&err=pluginDisErr$err_perm_msg ");
    exit;
  }
} else if ($op == "rm") {

  // REMOVE
  $error = 0;
  if ($query_drop_table) {
    if (!$db->query($query_drop_table)) {
      $error++;
    }
  }



  if ($child_table) {

    $childSection = [];
    $permissions_child_updated = [];

    for ($i = 0; $i < count($child_table); $i++) {

      $section->link = $child_table[$i]['link'];
      $section->table = 'sectionChild';
      $stmt1 = $section->showAllWhere('id', ['link']);
      $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
      extract($row1);

      $childSection[] = $row1['id'];

      if (!$section->deleteByLink("sectionChild")) {
        $error++;
      }
    }

    // get the permission for the user that disabled the plugin
    $rolessection->table = 'rolesSectionChild';
    $rolessection->role_id = $_SESSION['role_id'];
    $stmt2 = $rolessection->showAllWhere('id', ['role_id']);
    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
    extract($row2);

    $permissions = explode(',', $row2['section_id']);


    foreach ($permissions as $item) {
      if (!in_array($item, $childSection)) {
        $permissions_child_updated[] = $item;
      }
    }
  }

  $rolessection->table = 'rolesSectionChild';
  $rolessection->role_id = $_SESSION['role_id'];
  !is_null($perm_child_str) ? $perm_child_str = implode(',', $permissions_child_updated) : $perm_child_str = '';
  $rolessection->section_id = $perm_child_str;

  // set permission for the user that disabled the plugin
  if (!$rolessection->update(['section_id'], 'role_id')) {
    $errorPerm++;
  }

  // set permission for the root user
  if ($_SESSION['role_id'] != 1) {
    $rolessection->table = 'rolesSectionChild';
    $rolessection->role_id = 1;
    $rolessection->section_id = $perm_child_str;
    if (!$rolessection->update(['section_id'], 'role_id')) {
      $errorPerm++;
    }
  }

  $parentSection = [];
  $permissions_parent_updated = [];

  if ($parent_table) {
    for ($i = 0; $i < count($parent_table); $i++) {
      $section->link = $parent_table[$i]['link'];
      $section->table = 'sectionParent';
      $stmt3 = $section->showAllWhere('id', ['link']);
      $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
      extract($row3);

      $parentSection[] = $row3['id'];

      if (!$section->deleteByLink("sectionParent")) {
        $error++;
      }
    }

    // get the permission for the user that disabled the plugin
    $rolessection->table = 'rolesSection';
    $rolessection->role_id = $_SESSION['role_id'];
    $stmt4 = $rolessection->showAllWhere('id', ['role_id']);
    $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
    extract($row4);

    $permissions = explode(',', $row4['section_id']);


    foreach ($permissions as $item) {
      if (!in_array($item, $parentSection)) {
        $permissions_parent_updated[] = $item;
      }
    }
  }

  $rolessection->table = 'rolesSection';
  $rolessection->role_id = $_SESSION['role_id'];
  !is_null($perm_parent_str) ? $perm_parent_str = implode(',', $permissions_child_updated) : $perm_parent_str = '';
  $rolessection->section_id = $perm_parent_str;

  // set permission for the user that disabled the plugin
  if (!$rolessection->update(['section_id'], 'role_id')) {
    $errorPerm++;
  }

  // set permission for the root user
  if ($_SESSION['role_id'] != 1) {
    $rolessection->table = 'rolesSection';
    $rolessection->role_id = 1;
    $rolessection->section_id = $perm_parent_str;
    if (!$rolessection->update(['section_id'], 'role_id')) {
      $errorPerm++;
    }
  }

  $err_perm_msg = '';
  if ($errorPerm > 0) {
    $err_perm_msg = '&err=errPermPlugin';
  }


  $plugin->id = filter_input(INPUT_GET, 'idPlugin');
  $plugin->installed = 0;
  $plugin->active = 0;

  if (!$plugin->update(['installed', 'active'], 'id')) {
    $error++;
  }
  unlink("../inc/class_initialize.php");

  // DELETE ALL FILES

  // remove assets files
  foreach (glob("$path/assets/*") as $row) {
    $item = pathinfo($row);

    if (!unlink('../assets/css/' . $item['basename'] . '')) {
      $error++;
    }
  }

  // remove class files
  foreach (glob("$path/class/*") as $row) {
    $item = pathinfo($row);
    if (!unlink('../class/' . $item['basename'] . '')) {
      $error++;
    }
  }

  // remove core files
  foreach (glob("$path/core/*") as $row) {
    $item = pathinfo($row);

    if (!unlink('' . $item['basename'] . '')) {
      $error++;
    }
  }

  // remove inc files

  $scan = scandir($path . '/inc');

  foreach ($scan as $file) {
    if (!in_array($file, $exclude)) {
      if (!unlink('../inc/' . $file . '')) {
        $error++;
      }
    }
  }

  // remove inc/func files
  foreach (glob("$path/inc/func/*") as $row) {
    $item = pathinfo($row);

    if (!unlink('../inc/func/' . $item['basename'] . '')) {
      $error++;
    }
  }

  // remove setting files
  foreach (glob("$path/settings/*") as $row) {
    $item = pathinfo($row);

    if (!unlink('../inc/func/' . $item['basename'] . '')) {
      $error++;
    }
  }

  // remove script files
  foreach (glob("$path/script/*") as $row) {
    $item = pathinfo($row);

    if (!unlink('../script/' . $item['basename'] . '')) {
      $error++;
    }
  }

  // remove manual files
  foreach (glob("$path/manual/*") as $row) {
    $item = pathinfo($row);

    if (!unlink('../manual/' . $item['basename'] . '')) {
      $error++;
    }
  }

  $scan = scandir($path . '/locale');
  $exclude = array('..', '.');
  foreach ($scan as $folder) {
    if (is_dir("$path/locale/$folder") && !in_array($folder, $exclude)) {
      // copy locale files
      foreach (glob("$path/locale/$folder/*") as $row) {
        $item = pathinfo($row);

        if (!unlink('../locale/' . $folder . '/' . $item['basename'] . '')) {

          $error++;
        }
      }
    }
  }

  // remove frontend files
  foreach (glob("$path/frontend/*") as $row) {
    $item = pathinfo($row);

    if (!unlink('../../' . $item['basename'] . '')) {
      $error++;
    }
  }

  // remove uploads files
  foreach (glob("$path/uploads/*") as $row) {
    $item = pathinfo($row);

    if (!unlink('../uploads/' . $item['basename'] . '')) {
      $error++;
    }
  }

  if ($error == 0) {
    header("Location: ../index.php?p=allPlugins&msg=pluginRm$err_perm_msg ");
    exit;
  } else {
    header("Location: ../index.php?p=allPlugins&err=pluginRmErr$err_perm_msg ");
    exit;
  }
}
