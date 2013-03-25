<?php

Class RubyParser extends AutoSuggestParser {

    public $display_name = "ruby";
    public $short_name = "ruby";
    public $icon = "icon.png";


    protected function addResults($arr) {
        foreach ($arr as $a) {
            $title = $a["title"];
            $url = $a["url"];
            $description = $a["description"];

            $this->addResult($url, $title, $description);
        }
    }


    public function update() {

        $data = file_get_contents("http://apidock.com/javascripts/searchdata/ruby.js");

        // Get everything from the last document.searchData onwards
        $data = substr($data, strrpos($data, "document.searchData"));
        // Remove 'document.searchData'
        $data = substr($data, strpos($data, "["));
        // Remove trailing semicolon
        $data = substr($data, 0, strlen($data)-1);

        $json = json_decode($data);

        $ruby = array();
        foreach ($json as $construct) {
            $ruby[] = array(
                "title" => $construct->name,
                "description" => ($construct->path == "-") ? $construct->name : $construct->path . "#" . $construct->name,
                "url" => "http://apidock.com/ruby/search/quick?query=" . $construct->name,
                "score" => $construct->score
            );
        }

        // Sort by score (i.e. more relevant results will appear first)
        usort($ruby, array("RubyParser", "scoreSort"));

        $this->addResults($ruby);

        $this->save();
    }

    private static function scoreSort($a, $b) {
        return ((float)$a["score"] == (float)$b["score"]) ? 0 : ((float)$a["score"] > (float)$b["score"]) ? -1 : 1;
    }
}