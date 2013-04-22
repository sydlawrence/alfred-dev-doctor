<?php

Class ManParser extends AutoSuggestParser {

    public $display_name = "Man";

    public $short_name = "man";

    public $icon = "icon.png";

    protected function addResults($cmds) {
        foreach ($cmds as $cmd) {
            $title = $cmd['title'];
            $url = $cmd['url'];
            $description = null;
            $this->addResult($url, $title, $description);
        }
    }

    public function update() {
        for ($i = 1; $i <= 9; ++$i) {
            $url = "https://developer.apple.com/library/mac/documentation/darwin/reference/manpages/index-$i.html";
            $content = $this->get_page($url);
            $cmds = $this->parse_cmds($content);
            $this->addResults($cmds);
        }

        $this->save();
    }

    private function get_page($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_ENCODING, 'gzip');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($curl);
        curl_close($curl);

        return $content;
    }

    private function parse_cmds($content) {
        $cmds = array();
        preg_match('#<blockquote class="groupindent">(.+)</blockquote>#s', $content, $result);
        $content = $result[1];
        $regex = '#<a[^>]+href="([^"]+)"[^>]*>([^<>]+\([1-9]\))</a>#';
        preg_match_all($regex, $content, $results, PREG_SET_ORDER);
        foreach ($results as $result) {
            $cmds[] = array(
                'url' => 'https://developer.apple.com/library/mac/documentation/darwin/reference/manpages/' . $result[1],
                'title' => $result[2],
            );
        }

        return $cmds;
    }
}
