<?php

  //*****************//
 // ERROR REPORTING //
//*****************//

    error_reporting(E_ALL);
    ini_set('display_errors', 1);


echo '<!DOCTYPE html>

<html lang="en-GB">
<head>
<meta charset="utf-8">
<title>Kubaru by Rounin Media</title>
<meta name="viewport" content="initial-scale=1.0" />
</head>

<body>

<form class="kubaru" method="post" action="https://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'].'?kubaru=true">

<h1 class="kubaruHeading">Kubaru by Rounin Media</h1>

<input type="submit" class="readPagesSubmit" value="Update Pages" />
';


if ((isset($_GET['kubaru'])) && ($_GET['kubaru'] === 'true')) {

  $Skip_Folders = array('.', '..', 'index.php', 'page.json');

  $FilePath = $_SERVER['DOCUMENT_ROOT'].'/.assets/content/pages/nail-products/';

  $Subfolders = scandir($FilePath);

  for ($i = 0; $i < count($Subfolders); $i++) {

    if (in_array($Subfolders[$i], $Skip_Folders)) continue;

    $SubFilePath = $FilePath.'/'.$Subfolders[$i];
    $SubSubfolders = scandir($SubFilePath);

    for ($j = 0; $j < count($SubSubfolders); $j++) {

      if (in_array($SubSubfolders[$j], $Skip_Folders)) continue;

      $Page_To_Read = 'https://'.$_SERVER['HTTP_HOST'].'/nail-products/'.$Subfolders[$i].'/'.$SubSubfolders[$j].'/';

      echo '<p>'.$Page_To_Read.'</p>';


      $Page_Manifest = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/.assets/content/pages/nail-products/'.$Subfolders[$i].'/'.$SubSubfolders[$j].'/page.json');
      $Page_Manifest_Array = json_decode($Page_Manifest, TRUE);

      $Page_Manifest_Array['Document_Overview']['Document_Information']['Preload_Assets'][1][1]['URL'] = '/.assets/design/elements/fonts/scotia-beauty-logo.woff2';
      $Saved_Ashiva_Page_Build = $Page_Manifest_Array['Ashiva_Page_Build'];
      unset($Page_Manifest_Array['Ashiva_Page_Build']);
      unset($Page_Manifest_Array['Structured_Data']);

      $New_JSON_Data = json_encode($Page_Manifest_Array, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
      $New_JSON_Data = substr($New_JSON_Data, 0, -1);
      $New_JSON_Data .= ', "Document_Data" : {"JSON_Linked_Data": {"Directory" : {"Page" : ["Product"], "Elements" : {"Breadcrumbs" : "Breadcrumbs"}, "Global" : ["Organization"]}, "Product": {}}, "Content_Data" : {"Directory" : {"Global" : ["SB_Translations"], "Elements" : {"" : ""}, "Page" : [""]}}}, "Ashiva_Page_Build": {"Page_Scaffold": "Global", "Page_Stylesheets": ["Global"], "Page_Scripts": ["Global"], "Ashiva_Page_Modules": [""]}}';
      
      $New_JSON_Data_Array = json_decode($New_JSON_Data, TRUE);
      $New_JSON_Data_Ready = json_encode($New_JSON_Data_Array, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

      $fp = fopen($_SERVER['DOCUMENT_ROOT'].'/.assets/content/pages/nail-products/'.$Subfolders[$i].'/'.$SubSubfolders[$j].'/page.json', 'w');
      fwrite($fp, $New_JSON_Data_Ready);
      fclose($fp);
    }
  }
}


echo '</form>

</body>
</html>';

?>
