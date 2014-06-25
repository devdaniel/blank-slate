<?php
function smarty_function_session_userdata($params, $template) {
    $CI =& get_instance();
    return $CI->session->userdata($params['key']);
}
