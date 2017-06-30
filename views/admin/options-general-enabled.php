<table>
    <thead>
        <tr>
            <th>Enabled</th>
            <th>Default</th>
            <th></th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td><input type="checkbox" <?php checked( in_array('rewrite', $settings['enabled']) ); ?>name="admin_ajax_no_thank_you[enabled][]" value="rewrite"/></td>
            <td><input type="radio" <?php checked( $settings['default'] == 'rewrite' ); ?> name="admin_ajax_no_thank_you[default]" value="rewrite"/></td>
            <td>
                <label>Rewrite endpoint</label>
                <input type="text" value="<?php echo esc_attr($settings['endpoint']['rewrite']); ?>" name="admin_ajax_no_thank_you[endpoint][rewrite]" placeholder="/ajax/">
            </td>
            <td data-url="<?php echo esc_attr($endpoints['rewrite']); ?>"></td>
        </tr>

        <tr>
            <td><input type="checkbox" <?php checked( in_array('rest-api', $settings['enabled']) ); ?>name="admin_ajax_no_thank_you[enabled][]" value="rest-api"/></td>
            <td><input type="radio" <?php checked( $settings['default'] == 'rest-api' ); ?> name="admin_ajax_no_thank_you[default]" value="rest-api"/></td>
            <td>
                <label>REST API endpoint</label>
                <input type="text" value="<?php echo esc_attr($settings['endpoint']['rest-api']); ?>" name="admin_ajax_no_thank_you[endpoint][rest-api]" placeholder="/wp/v2/admin-ajax">
            </td>
            <td data-url="<?php echo esc_attr($endpoints['rest']); ?>"></td>
        </tr>
    </tbody>
</table>

<h3>Debug output:</h3>
<pre id="debugger"></pre>