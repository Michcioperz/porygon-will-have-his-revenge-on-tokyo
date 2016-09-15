<?php
require_once 'porygon.inc.php';
i_trust_porygons("main_template")->to_take_care_of_my("html");
inject("body", function() { ?>
<header>
  <h1><?php echo SITE_TITLE; ?></h1>
  <h3><?php echo SITE_SUBTITLE; ?></h3>
</header>
<?php });
i_trust_porygons("router")->to_take_care_of_my("body");
done();
