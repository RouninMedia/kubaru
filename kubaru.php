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

<h1 class="kubaruHeading">Kubaru by Rounin Media</h1>';

if ((!isset($_GET['kubaru'])) || ($_GET['kubaru'] !== 'true')) {

  echo '<input type="submit" class="readPagesSubmit" value="Update Pages" />';
}


if ((isset($_GET['kubaru'])) && ($_GET['kubaru'] === 'true')) {

  echo '<button type="button" onclick="window.location = \'https://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'].'\';">Reset Kubaru</button>';


  function Gather_Pages($Array) {

    $Skip_Folders = array('.', '..', 'cgi-bin', '.assets', 'api', 'assets', 'content', 'data', 'developers', 'elements', 'email-confirmation', 'form', 'forms', 'media', 'scripts');

    for ($i = 0; $i < count($Array); $i++) {

      $Subfolders = scandir($Array[$i]);

      for ($j = 0; $j < count($Subfolders); $j++) {

        if (in_array($Subfolders[$j], $Skip_Folders)) continue;
        if (!is_dir($Array[$i].'/'.$Subfolders[$j])) continue;

        $Array[] = $Array[$i].'/'.$Subfolders[$j];
      }

      $Array = array_unique($Array);
    }

    return $Array;
  }

  $URL_List = array($_SERVER['DOCUMENT_ROOT']);
  $URL_List = Gather_Pages($URL_List);

  $Pages = array();

  echo '<ol>';

  for ($i = 0; $i < count($URL_List); $i++) {

    $Full_Path = str_replace($_SERVER['DOCUMENT_ROOT'], $_SERVER['DOCUMENT_ROOT'].'/.assets/content/pages', $URL_List[$i]);
    $Full_Path .= '/page.json';
    $Full_Path = str_replace('/pages/page.json', '/pages/scotia-beauty-homepage/page.json', $Full_Path);
    $Full_Path = str_replace('/de/page.json', '/de/scotia-beauty-startseite/page.json', $Full_Path);
    
    echo '<li>';

    if (!file_exists($Full_Path)) {

      echo '<strong>MISSING:</strong> ';
    }

    echo $Full_Path.'</li>';

    $Pages[] = $Full_Path;
  }

  echo '</ol>';




  for ($i = 0; $i < count($Pages); $i++) {


    $Page_Manifest_JSON = file_get_contents($Pages[$i]);
    $Page_Manifest_Array = json_decode($Page_Manifest_JSON, true);


    // DIRECTIVES


    if (strpos($Pages[$i], '/nail-products/') !== FALSE) {

      unset($Page_Manifest_Array['Ashiva_Page_Build']['Modules']['Scotia_Beauty']);

      $Page_Manifest_Array['Ashiva_Page_Build']['Modules']['Scotia_Beauty'] = [];

      $Page_Manifest_Array['Ashiva_Page_Build']['Modules']['Scotia_Beauty'][] = 'SB_Body_Data';
      $Page_Manifest_Array['Ashiva_Page_Build']['Modules']['Scotia_Beauty'][] = 'SB_Colour_Charts';
      $Page_Manifest_Array['Ashiva_Page_Build']['Modules']['Scotia_Beauty'][] = 'SB_Nail_Categories';
      $Page_Manifest_Array['Ashiva_Page_Build']['Modules']['Scotia_Beauty'][] = 'SB_Translations::EN';
      $Page_Manifest_Array['Ashiva_Page_Build']['Modules']['Scotia_Beauty'][] = 'SB_nextPage';
    }


/*
    if (strpos($Pages[$i], '/nail-products/') !== FALSE) {

      unset($Page_Manifest_Array['Ashiva_Page_Build']['Modules']['Scotia_Beauty'][array_search('SB_Next_Page', $Page_Manifest_Array['Ashiva_Page_Build']['Modules']['Scotia_Beauty'])]);
    }
*/

    /*

    if (strpos($Pages[$i], '/nail-products/') !== FALSE) {

      $Page_Manifest_Array['Ashiva_Page_Build']['Modules']['Scotia_Beauty'][] = 'SB_nextPage';
      sort($Page_Manifest_Array['Ashiva_Page_Build']['Modules']['Scotia_Beauty']);
    }

    if (strpos($Pages[$i], '/nail-products/') !== FALSE) {

      $Page_Manifest_Array['Document_Data']['JSON_Linked_Data']['Directory']['Page']  = array('SB_Product');
      $Page_Manifest_Array['Document_Data']['JSON_Linked_Data']['Directory']['Elements']  = array('Ashiva_Breadcrumbs');
      $Page_Manifest_Array['Document_Data']['JSON_Linked_Data']['Directory']['Global']  = array('Ashiva_Organization');
      $Page_Manifest_Array['Document_Data']['JSON_Linked_Data']['Directory']['Page']  = array('SB_Product');
      $Page_Manifest_Array['Document_Data']['JSON_Linked_Data']['SB_Product']  = array('');
    }

    if (strpos($Pages[$i], '/nail-products/') !== FALSE) {

      unset($Page_Manifest_Array['Ashiva_Page_Modules']);
      $Page_Manifest_Array['Ashiva_Page_Build']['Modules'] = array('Scotia_Beauty' => array('SB_Body_Data', 'SB_Colour_Charts', 'SB_Nail_Categories', 'SB_Translations::EN'));
    }

    $Page_Manifest_Array['Ashiva_Page_Build']['Modules']['Scotia_Beauty'][] = 'SB_Nail_Categories';
    sort($Page_Manifest_Array['Ashiva_Page_Build']['Modules']['Scotia_Beauty']);

    $Page_Manifest_Array['Ashiva_Page_Build']['Modules']['Scotia_Beauty'] = array_unique($Page_Manifest_Array['Ashiva_Page_Build']['Modules']['Scotia_Beauty']);
    sort($Page_Manifest_Array['Ashiva_Page_Build']['Modules']['Scotia_Beauty']);

    $Saved_Modules = $Page_Manifest_Array['Ashiva_Page_Build']['Modules'];
    $Page_Manifest_Array['Ashiva_Page_Build']['Modules'] = array();
    $Page_Manifest_Array['Ashiva_Page_Build']['Modules']['Scotia_Beauty'] = $Saved_Modules;

    $Page_Manifest_Array['Ashiva_Page_Build']['Modules'][] = 'SB_Body_Data';

    $Page_Manifest_Array['Ashiva_Page_Build']['Modules'] = array('SB_Colour_Charts', 'SB_Translations::EN');
    unset($Page_Manifest_Array['Ashiva_Page_Modules']);

    $Page_Manifest_Array['Ashiva_Page_Modules']['Directory']['Current'] = array('SB_Colour_Charts', 'SB_Translations::EN');

    $Page_Manifest_Array['Ashiva_Page_Modules']['Directory']['Global'] = array();

    unset($Page_Manifest_Array['Ashiva_Page_Build']['Ashiva_Page_Modules']);
    unset($Page_Manifest_Array['Document_Data']['Content_Data']);

    $Page_Manifest_Array['Ashiva_Page_Modules'] = array();
    $Page_Manifest_Array['Ashiva_Page_Modules']['Directory'] = array();
    $Page_Manifest_Array['Ashiva_Page_Modules']['Directory']['Global'] = array('SB_Colour_Charts', 'SB_Translations');
    $Page_Manifest_Array['Ashiva_Page_Modules']['Directory']['Current'] = array();
    $Page_Manifest_Array['Ashiva_Page_Modules']['Directory']['Page'] = array();
    $Page_Manifest_Array['Ashiva_Page_Modules']['Directory']['Extensions'] = array();

    $Page_Manifest_Array['Document_Data']['Content_Data']['Directory']['Global'] = array('SB_Colour_Charts', 'SB_Translations');

    if (strpos($Pages[$i], '/nail-products/') !== FALSE) {

      $Page_Manifest_Array['Document_Data']['JSON_Linked_Data']['Directory']['Page'] = array('SB_Product');
      unset($Page_Manifest_Array['Document_Data']['JSON_Linked_Data']['Product::Product']);
      $Page_Manifest_Array['Document_Data']['JSON_Linked_Data']['SB_Product'] = [];
    }

    $Page_Manifest_Array['Document_Data']['JSON_Linked_Data']['Directory']['Elements'] = array('Ashiva_Breadcrumbs');
    $Page_Manifest_Array['Document_Data']['JSON_Linked_Data']['Directory']['Global'] = array('Ashiva_Organization');


    $Page_Manifest_Array['Document_Overview']['Document_Information']['Document_Language'] = array('en', 'GB');

    
    if (strpos($Pages[$i], '/de/') !== FALSE) {

      $Page_Manifest_Array['Document_Overview']['Document_Information']['Document_Language'] = array('de');
    }

        
    unset($Page_Manifest_Array['Document_Data']['JSON_Linked_Data']['Product']);

    $Page_Manifest_Array['Document_Data']['JSON_Linked_Data']['Directory']['Page'] = array();
    $Page_Manifest_Array['Document_Data']['JSON_Linked_Data']['Directory']['Elements'] = array('Breadcrumbs::Breadcrumbs');
    $Page_Manifest_Array['Document_Data']['JSON_Linked_Data']['Directory']['Global'] = array('Organization::Organization');

    if ((strpos($Pages[$i], '/nail-products/') !== FALSE) && (count(explode('/', $Pages[$i])) > 13)) {

      $Page_Manifest_Array['Document_Data']['JSON_Linked_Data']['Directory']['Page'] = array('Product::Product');
      $Page_Manifest_Array['Document_Data']['JSON_Linked_Data']['Product : Product'] = array();
    }

    $Page_Manifest_Array['Document_Data']['Content_Data']['Directory']['Global'] = array('SB_Colour_Charts::SB_Colour_Charts', 'SB_Translations::SB_Translations');
    $Page_Manifest_Array['Document_Data']['Content_Data']['Directory']['Elements'] = array();
    $Page_Manifest_Array['Document_Data']['Content_Data']['Directory']['Page'] = array();

    */






    $New_Page_Manifest_JSON = json_encode($Page_Manifest_Array, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

/*
    echo '<pre>';
    echo $Page_Manifest_JSON;

    echo $New_Page_Manifest_JSON;
    echo '</pre>';
*/    
    
      //********************//
     // WRITE DATA TO FILE //
    //********************//

    $fp = fopen($Pages[$i], 'w');
    fwrite($fp, $New_Page_Manifest_JSON);
    fclose($fp);
  }
}


echo '</form>

<script>

</script>

</body>
</html>';

?>
