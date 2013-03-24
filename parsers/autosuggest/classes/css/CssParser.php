<?php


Class CssParser {

    public $display_name = "CSS";

    public $short_name = "css";

    public $icon = "icon.png";

    protected $results = array();

    protected function addResult($url, $title, $description) {
        $results[] = array(
            "url" => $url ,
            "title" => $title,
            "description" =>$description
        );
    }

    protected function addResults($data) {
        foreach ($arr as $key => $val) {
            $title = $val->title;
            $url = $val->url;
            $description = strip_tags(implode($val->sectionHTMLs, ""));

            $this->addResult($url, $title, $description);
        }
    }

    public function update() {

        $data = file_get_contents("http://dochub.io/data/css-mdn.json");
        $data = json_decode($data);
        addResultsCSS($data);

        $this->save();
    }

    public function save() {
        $output = "data.".$this->short_name.".json";
        file_put_contents($output, json_encode($this->results));

    }
}