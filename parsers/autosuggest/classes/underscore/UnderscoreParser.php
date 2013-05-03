<?php

Class UnderscoreParser extends AutoSuggestParser {

    public $display_name = "underscore";

    public $short_name = "_ud";

    public $icon = "icon.png";

    protected function addResults($html) {
        $doc = new DOMDocument();
        $doc->loadHTML($html);

        $xpath = new DOMXPath($doc);

        $elems = $xpath->query("/html/body/div[@class='container']/div[@id='documentation']/p[@id]");

        if (!is_null($elems)) {
          foreach ($elems as $el) {

            $title = $xpath->query("@id", $el)->item(0)->nodeValue;
            $code = $xpath->query("code", $el)->item(0)->nodeValue;
            $alias = "";
            $text = "";

            $alias_nodes = $xpath->query("span", $el);
            if(!is_null($alias_nodes) && $alias_nodes->length > 0) {
                $alias = $alias_nodes->item(0)->nodeValue;
            }
            
            // get text and <b> node only
            foreach($el->childNodes as $node) {
                if ($node->hasAttributes() || ($node->nodeType != XML_TEXT_NODE && $node->nodeName != "b")) {
                    continue;
                }

                $text = $text . $node->nodeValue;
            }

            $url = "http://underscores.org/#" . $title;
            $this->addResult($url, $title, $code . " " . $alias .  " " . strip_tags($text));
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