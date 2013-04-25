<?php

Class GitParser extends AutoSuggestParser {

    public $display_name = "Git";

    public $short_name = "git";

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
        $url = "http://git-scm.com/docs";
        $content = $this->get_page($url);
        $cmds = $this->parse_cmds($content);
        $this->addResults($cmds);

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
        $regex = '#<a[^>]+href="/docs/git-([^"]+)"[^>]*>\1</a>#';
        preg_match_all($regex, $content, $results, PREG_SET_ORDER);
        foreach ($results as $result) {
            $cmd = $result[1];
            $cmds[] = array(
                'url' => "http://git-scm.com/docs/git-$cmd",
                'title' => $cmd,
            );
        }

        return $cmds;
    }
}
