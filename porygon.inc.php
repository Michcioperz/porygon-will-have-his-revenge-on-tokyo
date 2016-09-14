<?php
  define("PORYGON_VERSION", "0.1.0");
  require_once "config.inc.php";
  if ((defined("DEBUG_KEY") && $_COOKIE["DEBUG_KEY"] === DEBUG_KEY) || (!defined("DEBUG_KEY") && !defined("PRODUCTION_ENVIRONMENT"))) {
    error_reporting(E_ALL || E_STRICT);
    ini_set('html_errors', true);
  } else {
    set_error_handler(function($errno, $errstr) {
      ob_end_clean();
      die("An error has occured. Porygon can no longer have revenge on Tokyo.");
    });
  }
  ob_start();
  function assert_database() {
    global $db;
    if (!defined("SQL_UP")) $db = new PDO(SQL_URI, SQL_USER, SQL_PASSWORD);
  }
  $_injects = array();
  function inject($scope, $func) {
    global $_injects;
    assert(gettype($func) === 'object' && get_class($func) === 'Closure');
    if (!array_key_exists($scope, $_injects)) $_injects[$scope] = array();
    array_push($_injects[$scope], $func);
  }
  function _render_injects($scope) {
    global $_injects;
    foreach ($_injects[$scope] as $inject) {
      echo $inject();
    }
  }
  function done() {
    _render_injects("html");
    ob_end_flush();
    die();
  }
  inject("html", function() {
?>
<!DOCTYPE html>
<html lang="<?php if (defined("SITE_LANG")) echo SITE_LANG; else echo "pl"; ?>">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if (defined("PAGE_TITLE")) echo PAGE_TITLE . " | "; echo SITE_TITLE; ?></title>
    <meta name="generator" content="Porygon Will Have His Revenge On Tokyo v<?php echo PORYGON_VERSION; ?>">
    <?php _render_injects("head"); ?>
  </head>
  <body>
    <?php _render_injects("body"); ?>
  </body>
</html>
<?php }); ?>
