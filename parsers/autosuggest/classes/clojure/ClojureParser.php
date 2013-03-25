<?php

Class ClojureParser extends AutoSuggestParser {

    public $display_name = "Clojure";

    public $short_name = "clojure";

    public $icon = "icon.png";

    protected function addResults($arr) {
        foreach ($arr as $key => $val) {
            $title = $val->content;
            $url = "http://www.haskell.org/ghc/docs/7.6.2/html/libraries/".$val->href;
            //$description = strip_tags($val->html);
            $description = "";
            $this->addResult($url, $title, $description);

        }
    }

    public function update() {
      $this->save();
    }

    public function save() {
      echo strtoupper($this->display_name)." DONE\n";
    }
}
