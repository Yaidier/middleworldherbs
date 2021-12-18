<?php

namespace App;

class App {

    public static function init() {

        WC::init();
        AjaxHandler::init();

    }

}