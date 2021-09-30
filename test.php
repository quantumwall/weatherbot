#!/usr/bin/env php
<?php
    define("IPA", "amargo");
    class Detect {
        public function __construct() {
            $this->ipa = IPA;
        }
    }
    function showDefine() {
        print IPA;
    }
    //showDefine();
    $a = new Detect();
    print $a->ipa;
