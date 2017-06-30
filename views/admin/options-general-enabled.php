<table>
    <thead>
        <tr>
            <th>Enabled</th>
            <th>Default</th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td><input type="checkbox" <?php checked( in_array('rewrite', $settings['enabled']) ); ?>name="admin_ajax_no_thank_you[enabled][]" value="rewrite"/></td>
            <td><input type="radio" <?php checked( $settings['default'] == 'rewrite' ); ?> name="admin_ajax_no_thank_you[default]" value="rewrite"/></td>
            <td><input type="text" value="<?php echo esc_attr($settings['endpoint']['rewrite']); ?>" name="admin_ajax_no_thank_you[endpoint][rewrite]" placeholder="/ajax/"</td>
        </tr>

        <tr>
            <td><input type="checkbox" <?php checked( in_array('rest-api', $settings['enabled']) ); ?>name="admin_ajax_no_thank_you[enabled][]" value="rest-api"/></td>
            <td><input type="radio" <?php checked( $settings['default'] == 'rest-api' ); ?> name="admin_ajax_no_thank_you[default]" value="rest-api"/></td>
            <td><input type="text" value="<?php echo esc_attr($settings['endpoint']['rest-api']); ?>" name="admin_ajax_no_thank_you[endpoint][rest-api]" placeholder="/wp/v2/admin-ajax"</td>
        </tr>
    </tbody>
</table>