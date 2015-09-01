<?php ?>

<div class="wrap">
    <h2>Post Editor Keyboard Shortcuts</h2>
    <form action="options.php" method="post">
        <?php settings_fields( 'itp' ); ?>
        <?php do_settings_sections( 'itp' ); ?>
         
        <input name="Submit" type="submit" value="Save Changes" class="button button-primary" />
    </form>
</div>