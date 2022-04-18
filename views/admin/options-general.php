<div class="wrap">
    <h2>Admin Ajax.php No Thank You!</h2>
    <form action="options.php" method="POST">
        <?php
        settings_fields('admin_ajax_no_thank_you');
        do_settings_sections('admin_ajax_no_thank_you');
        submit_button();
        ?>
    </form>
    
    <div>
        Admin Ajax dot php? No Thank You! version <?php echo $version; ?>
        &nbsp;by <a href="https://rack.and.pinecone.website/">Rack and Pinecone</a> &middot;
        <a href="https://wordpress.org/support/plugin/admin-ajax-php-no-thank-you">Support</a> &middot;
        <a href="https://cash.me/$EricEaglstun">Donate</a>
    </div>
</div>

<style>
    form a {
        cursor: pointer;
    }
</style>