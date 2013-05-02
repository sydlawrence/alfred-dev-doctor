<?php

Class UnderscoreParser extends AutoSuggestParser {

    public $display_name = "underscore";

    public $short_name = "_ud";

    public $icon = "icon.png";

    protected function addResults($html) {
        $doc = new DOMDocument();
        $doc->loadHTML($html);

        $xpath = new DOMXPath($doc);

//        $elems = $xpath->query("/html/body/div[@id='sidebar']/ul[@class='toc_section']/li/a");
        $elems = $xpath->query("/html/body/div[@class='container']/div[@id='documentation']/p[@id]");

        if (!is_null($elems)) {
          foreach ($elems as $el) {

            $title = $el->getAttribute("id");

            $code = $el->getElementsByTagName("code")->item(0)->nodeValue;

            $url = "http://underscores.org/#" . $title;
            $this->addResult($url, $title, $code);
          }
        }
//            $description = strip_tags(implode($val->sectionHTMLs, ""));
//            $description = str_replace("Summary\n", "", $description);

    }

    public function update() {

        $data = file_get_contents("https://github.com/documentcloud/underscore/raw/master/index.html");
        $this->addResults($data);

        $this->save();
    }
}