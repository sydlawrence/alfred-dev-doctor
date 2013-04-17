<?php

Class Sf2Parser extends AutoSuggestParser {

    public $display_name = "SF2";

    public $short_name = "sf2";

    public $icon = "icon.png";

    private $docVer = "2.2";

    protected function addResults($arr) {
        foreach ($arr as $key => $val) {
            $baseUrl = 'api.symfony.com';

            $this->results[] = array(
                "url" => sprintf("http://%s/%s/%s", $baseUrl, $this->docVer, $val[2]),
                "title" => $val[0],
                "description" => sprintf("%s\n%s\n%s", $val[1], $val[3], $val[4])
            );
        }
    }

    public function update() {

        $data = file_get_contents("http://api.symfony.com/2.2/search_index.js");

        // Get everything from the last 'info' onwards
        $data = substr($data, strrpos($data, "'info': "));
        // Remove 'info'
        $data = substr($data, strpos($data, "["));
        // Cut off the trailing bits
        $data = substr($data, 0, strpos($data, "]]")+2);

        $data = json_decode($data);
        $this->addResults($data);
        $this->save();
    }
}