<?php

Class RailsParser extends AutoSuggestParser {

    public $display_name = "rails";

    public $short_name = "rails";

    public $icon = "icon.png";

    protected $done = array();

    protected function addResults($arr) {
        $info = $arr["index"]["info"];
        foreach ($info as $key => $val) {
            $title = $string.$val[0];
            $args = $string.$val[3];
            if (strlen($args) > 0) {
                $title .= $args;
            }
            $url = "http://api.rubyonrails.org/".$val[2];
            $description = $string.$val[1];
            if (strlen($title) > 0) {
                if (!isset($this->done[$title])) {
                    $this->addResult($url, $title, $description);
                    $this->done[$url] = $url;
                }
            }
        }
    }

    public function update() {
        $data = file_get_contents("http://api.rubyonrails.org/js/search_index.js");
        $data = str_replace("var search_data =", "", $data);
        $data = utf8_encode($data);
        $data = json_decode($data, true);
        $this->addResults($data);

        $this->save();
    }
}
