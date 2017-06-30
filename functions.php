<?php

/**
*   render a page into wherever
*   @param string
*   @param object|array
*/
function render($_template, $vars = array())
{
    $_template_file = sprintf( '%s/views/%s.php', __DIR__, $_template );
    
    if (!file_exists($_template_file)) {
        return "<div>template missing: $_template</div>";
    }
        
    extract( (array) $vars, EXTR_SKIP );
    
    ob_start();
    require $_template_file;
    $html = ob_get_contents();
    ob_end_clean();
    
    return $html;
}
