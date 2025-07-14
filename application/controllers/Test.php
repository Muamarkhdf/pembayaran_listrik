<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        echo "Test controller is working!";
        echo "<br>Current URL: " . current_url();
        echo "<br>Base URL: " . base_url();
        echo "<br>Available controllers:";
        
        $controllers = glob(APPPATH . 'controllers/*.php');
        foreach ($controllers as $controller) {
            echo "<br>- " . basename($controller);
        }
    }

    public function pelanggan() {
        echo "Testing pelanggan route...";
        echo "<br>Session data: ";
        print_r($this->session->userdata());
    }
} 