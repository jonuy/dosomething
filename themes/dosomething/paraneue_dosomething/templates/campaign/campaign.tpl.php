<div class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
  <h1>Action page</h1>
  <div class="content"<?php print $content_attributes; ?>>
    <?php
      print render($content);
    ?>
  </div>
</div>
