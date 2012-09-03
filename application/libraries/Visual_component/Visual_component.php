<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Visual_component extends CI_Driver_Library {

    /**
     * Codeigniter instance
     * 
     * @var mixed
     */
    protected $ci;

    /**
     * The driver to use for rendering
     * 
     * @var mixed
     */
    protected $_current_driver;
    protected $valid_drivers = array(
        'visual_component_img',
        'visual_component_link',
        'visual_component_action',
        'visual_component_note',
        'visual_component_video',
        'visual_component_audio',
        'visual_component_text',
        'visual_component_pazzle',
        'Visual_component_qa',
        'Visual_component_slider2',
        'Visual_component_lianliankan',
        'Visual_component_gravity',
        'Visual_component_diypuzzle',
        'Visual_component_spotlight',
        'Visual_component_axismove',
		'Visual_component_rotate360',
    	'Visual_component_vocabulary',
    	'Visual_component_text2'
    );

    /**
     * Constructor
     * 
     */
    public function __construct() {
        $this->ci = & get_instance();

        $this->ci->load->driver('plenty_parser');
        // Call the init function
        $this->_init();
    }

    /**
     * Init
     * Populates variables and other things
     * @returns void
     */
    private function _init() {
        
    }

    public function parseHTML($type, $data, $param) {

        return $this->{$type}->parseHTML($data, $param);
    }

    public function parse($tpl, $data, $flag = true) {

        return $this->ci->plenty_parser->parse($tpl, $data, $flag);
    }

    public function getAllUsersFiles($type, $array) {
        return $this->{$type}->getAllUsersFiles($array);
    }

    public function getLibrary($type) {
        return $this->{$type}->getLibrary();
    }

}
