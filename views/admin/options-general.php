<div class="wrap">
    <h2>Admin Ajax.php No Thank You!</h2>
    <form action="options.php" method="POST">
        <?php
        settings_fields('admin_ajax_no_thank_you');
        do_settings_sections('admin_ajax_no_thank_you');
        submit_button();
        ?>
    </form>
</div>

<style>
    form a {
        cursor: pointer;
    }
</style>