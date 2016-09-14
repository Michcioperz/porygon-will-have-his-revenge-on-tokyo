<?php
  // Hello and welcome to Porygon Will Have His Revenge On Tokyo, version... what was it again?
  
  define("PORYGON_VERSION", "0.1.0");
  
  // Aha, alright!
  // Let's get up to speed with whatever the deities want us to deploy today.
  
  require_once "config.inc.php";
  
  // Doesn't sound too hard, does it? Okay, let's see if we're communing with a deity and what defines (haha, nailed it) a deity.
  
  if ((defined("DEBUG_KEY") && $_COOKIE["DEBUG_KEY"] === DEBUG_KEY) || (!defined("DEBUG_KEY") && !defined("PRODUCTION_ENVIRONMENT"))) {
    error_reporting(E_ALL || E_STRICT);
    ini_set('html_errors', true);
  } else {
    set_error_handler(function($errno, $errstr) {
      ob_end_clean();
      die("An error has occured. Porygon can no longer have revenge on Tokyo.");
    });
  }
  
  // Alright, I think we're all set to start scribbling.
  
  ob_start();
  
  // Let's start with the basics, a function that makes sure we have a database connection.
  
  function assert_database() {
    global $db;
    if (!defined("SQL_UP")) $db = new PDO(SQL_URI, SQL_USER, SQL_PASSWORD);
  }
  
  // Now that we got this done, the injects system. The heart of the whole thing (if you were to compare the database to a brain, or DNA, or [...])!
  
  $_injects = array();
  
  // Epic. That line there was epic.
  
  // Now let's get ready to inject stuff into that system.
  
  function inject($scope, $func) {
    global $_injects;
    // Oh, and make sure we're actually getting an anonymous function, this stuff is the only thing we can do.
    assert(gettype($func) === 'object' && get_class($func) === 'Closure');
    if (!array_key_exists($scope, $_injects)) $_injects[$scope] = array();
    array_push($_injects[$scope], $func);
  }
  
  // Once the injects are done, we'll need to run through them, and actually someone could think that this wouldn't need a function, but we like it recursive.
  
  function _render_injects($scope) {
    global $_injects;
    foreach ($_injects[$scope] as $inject) {
      echo $inject();
    }
  }
  
  // And when the preparations are done, we'll go for this thing! Neat.
  
  function done() {
    _render_injects("html");
    ob_end_flush();
    die(); // sad panda
  }
  
  // So, now a good, healthy default template to make this work just fine.
  
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
<?php });
  
  // With that template ready, hell yeah, that's it, Porygon can have his revenge on Tokyo just about fine. Good job there, crew!
  
?>
