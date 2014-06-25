<?php
function smarty_function_country_select_options($params, $template) {
    $CI =& get_instance();
    $iso = isset($params['iso']) ? $params['iso'] : 2;
    $return_options = isset($params['return_options']) ? $params['return_options'] : false;
    $current = isset($params['current']) ? $params['current'] : null ;

    $cache_id = 'country_select_list_'.$iso;
    $country_list = $CI->cache->get($cache_id);
    if(!$country_list) {
        $country_list = $CI->db->query(sprintf("SELECT `iso%d` as 'code', `name` FROM `lkup_country`", intval($iso)));
        $country_list = $country_list->result_array();
        $CI->cache->save($cache_id, $country_list, 86400*30);
    }

    if($country_list) {
        if($return_options == false) {
            $output = '';
            foreach($country_list as $country) {
                if($current == $country['code']) {
                    $output .= "<option value=\"".$country['code']."\" selected>".$country['name']."</option>\n";
                } else {
                    $output .= "<option value=\"".$country['code']."\">".$country['name']."</option>\n";
                }
            }
            return $output;
        } else {
            return $country_list->result_array();
        }
    }
    return false;
}
