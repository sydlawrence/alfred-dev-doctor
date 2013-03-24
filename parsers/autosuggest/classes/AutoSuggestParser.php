<?php

class AutoSuggestParser {
    public $data_filename = "";

    protected $results = array();

    public function __construct() {
        $this->data_filename = "data.".$this->short_name.".json";
    }

    protected function addResult($url, $title, $description) {
        $this->results[] = array(
            "url" => $url ,
            "title" => $title,
            "description" =>$description
        );
    }

    public function save() {
        file_put_contents(PARSER_URL."data/".$this->data_filename, json_encode($this->results));
        echo strtoupper($this->display_name)." DONE\n";
    }

    protected function addResults() {

    }

    public function update() {

    }
}