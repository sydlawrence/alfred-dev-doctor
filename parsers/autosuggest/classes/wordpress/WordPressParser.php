<?php

Class WordPressParser extends AutoSuggestParser {

    public $display_name = "WordPress";

    public $short_name = "wordpress";

    public $icon = "icon.png";

    protected function addResults($cmds) {
        foreach ($cmds as $cmd) {
            $title = $cmd['title'];
            $url = $cmd['url'];
            $description = $cmd['description'];;
            $this->addResult($url, $title, $description);
        }
    }

    public function update() {


        // this code is from Search the WordPress function reference
        // http://www.alfredforum.com/topic/2153-search-the-wordpress-function-reference/?p=12072
        // by keesiemeijer: http://www.alfredforum.com/user/4274-keesiemeijer/
        $base_url = 'http://codex.wordpress.org';

        $url = $base_url . '/Function_Reference/';

        // Create a new DOM Document to hold our webpage structure
        $xml = new DOMDocument();

        // Load the url's contents into the DOM (the @ supresses any errors from invalid XML)
        @$xml->loadHTMLFile( $url );

        $links = array();
        $string = '';
        $tables = $xml->getElementsByTagName( 'table' );

        //Loop through each <a> and </a> tag in the dom and add it to the link array
        foreach ( $tables as $table ) {

            if ( $table->getAttribute( 'class' ) == 'widefat' ) {
                foreach ( $table->getElementsByTagName( 'a' ) as $link ) {
                    if ( $link->getAttribute( 'href' ) )
                        $links[] = array( 'url' => $base_url . $link->getAttribute( 'href' ), 'title' => $link->nodeValue, 'description' => null );
                }
            }
        }

        $this->addResults($links);

        $this->save();
    }

}
