<div class="wrap">
    <h1>Auto Schedule</h1>
    <form method="post" action="options.php">
    <?php
        // This prints out all hidden setting fields
        settings_fields( 'auto_schedule_group' );
        do_settings_sections( 'auto-schedule' );
        submit_button();
    ?>
    </form>
</div>