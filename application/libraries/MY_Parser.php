<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Parser extends CI_Parser {
    protected $CI;
    protected $theme_location;

    public function __construct() {
        $this->CI = get_instance();
        $this->load->library('smarty');
        $this->smarty->error_reporting = E_ALL & ~E_NOTICE;
    }

    /**
    * This function lets us access Codeigniter instance objects like;
    * helpers, libraries and core functions without having to prefix
    * our faux Codeigniter instance variable 'CI' we can load Codeigniter
    * libraries and other goodness like we would normally within controllers
    * and other things.
    *
    * @param mixed $bleh
    */
    public function __get($bleh) {
        return $this->CI->$bleh;
    }

    /**
    * Parse a template using Smarty. Hows this for a Codeigniter
    * core extension? Nice and simple.
    *
    * @param mixed $template
    * @param array $data
    * @param mixed $return
    */
    public function parse($template, $data = '', $return = FALSE, $use_theme = FALSE) {
        // Make sure we have a template, yo.
        if ($template == '') {
            return FALSE;
        }

        // If we want to get a certain template from another location
        if ($use_theme != FALSE) {
            $this->load->library('template');
            $template = "file:/".$this->template->get_theme_path().$template."";
        }

        // If no file extension dot has been found default to .php for view extensions
        if ( !stripos($template, '.') ) {
            $template = $template.".".$this->smarty->template_ext;
        }

        // JavaScript/CSS paths
        $this->load->config('scripts');
        $data['js'] = $this->config->item('js_paths');
        $data['css'] = $this->config->item('css_paths');
        $data['cdn'] = $this->config->item('cdn_path');

        // If we have variables to assign, lets assign them
        if ($data) {
            foreach ($data as $key => $val) {
                $this->smarty->assign($key, $val);
            }
        }

        // Get our template data as a string
        $template_string = $this->smarty->fetch($template);

        // If we're returning the templates contents, we're displaying the template
        if ($return == FALSE) {
            $this->output->append_output($template_string);
        }

        // We're returning the contents, fo'' shizzle
        return $template_string;
    }

    public function parse_string($template, $data = '', $return = FALSE, $use_theme = FALSE) {
        return $this->parse($template, $data, $return, $use_theme);
    }

    public function parse_raw($template_string, $data = '') {
        if ($data) {
            foreach ($data as $key => $val) {
                $this->smarty->assign($key, $val);
            }
        }

        return $this->smarty->fetch($template_string);
    }

    public function parse_raw_safe($template_string, $data = array(), $replacement = '') {
        preg_match_all('/\{\$(.*?)\}/', $template_string, $template_vars, PREG_PATTERN_ORDER);

        // Check to make sure we have a value for all template variables
        foreach($template_vars[1] as $varname) {
            // Replace undefined variables with some safe value
            if(!isset($data[$varname])) {
                $data[$varname] = $replacement;
            }
        }

        return $this->parse_raw($template_string, $data);
    }

}
