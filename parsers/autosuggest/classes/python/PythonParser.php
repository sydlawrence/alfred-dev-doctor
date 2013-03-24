<?php

Class PythonParser extends AutoSuggestParser {

    public $display_name = "python";

    public $short_name = "python";

    public $icon = "icon.png";

    public function filter_url($url) {
        $params = explode("#", $url);
        if (count($params) < 2) return $url;
        $end = explode(".",$params[1]);

        $meh = explode("_",$end[0]);
        if (count($meh) == 2) {
            if ($meh[0] == $meh[1]) {
                unset($meh[1]);
            }
        }
        $end[0] = implode("_", $meh);
        $params[1] = implode(".",$end);
        $url = implode("#",$params);
        return str_replace("#_","#",$url);
    }

    protected function addResults($arr) {
        foreach ($arr as $key => $val) {
            $title = $val->title;
            $url = $val->url;
            $description = $val->html;
            $this->addResult($url, $title, $description);

            foreach ($val->searchableItems as $res) {

                $url2 = $this->filter_url($url."#".$res->domId);
                $this->addResult($url2, $res->name, "");
            }
        }
    }

    public function update() {

        $data = file_get_contents("http://dochub.io/data/python.json");

        $data = json_decode($data);
        $this->addResults($data);

        $this->save();
    }
}