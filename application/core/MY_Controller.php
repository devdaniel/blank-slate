<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    protected $debug;
    protected $use_cache;
    protected $vars;
    protected $template_data;
    protected $json;

    public function __construct() {
        parent::__construct();

        $this->json = false;
        $this->load->driver('cache', array('adapter' => 'file'));

        $nocache = $this->input->get('nocache');
        $output = $this->input->get('output');

        if (isset($nocache) &&
            $nocache !== FALSE) {
            if ($nocache == 1) {
                $this->session->userdata['nocache'] = TRUE;
            } else if ($nocache == 0) {
                $this->session->unset_userdata('nocache');
            }
        }

        $this->debug = false;
        $this->use_cache = !$this->session->userdata('nocache');
        $this->vars = array();
        $this->template_data = array();

        if ($output) {
            $this->session->userdata['output'] = $output;
        }
        if ($output != 'tv') {
            $this->session->userdata['show_intro'] = TRUE;
        }
        $this->session->userdata['page'] = 'default';
        $this->template_data['client_list'] = $this->session->userdata('client_list');

        if ($this->config->item('csrf_protection') === TRUE) {
            $this->vars['csrf_token'] = array(
                'token_name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()
            );
        }

    }

    public function _remap($method, $params = array()) {
        if (method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $params);
        }
        $this->show404();
    }

    public function render($template = '') {
        if ($this->debug && $this->db->queries) {
            $this->vars['queries'] = $this->db->queries;
        }
        if ($this->input->get('output') == 'json' || $this->json) {
            header('Content-type: application/json; charset=utf-8');
            print(json_encode($this->vars));
        } else {
            $this->parser->parse($template, array_merge($this->template_data, $this->vars));
        }
    }

    public function show404() {
        header("HTTP/1.1 404 Not Found");
        $this->session->userdata['page'] = 'default';
        $this->vars = array();
        if ($this->debug && $this->db->queries) {
            $this->vars['queries'] = $this->db->queries;
        }
        if($this->session->userdata('logged_in')) $this->vars['logged_in'] = 1;
        echo $this->parser->parse('errors/404.htm', $this->vars, true);
        die();
    }
}
