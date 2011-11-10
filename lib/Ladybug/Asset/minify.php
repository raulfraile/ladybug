<?php

$css = file_get_contents('tree.css');

/* Strips Comments */
	$css = preg_replace('!/\*.*?\*/!s','', $css);
	$css = preg_replace('/\n\s*\n/',"\n", $css);

	/* Minifies */
	$css = preg_replace('/[\n\r \t]/',' ', $css);
	$css = preg_replace('/ +/',' ', $css);
	$css = preg_replace('/ ?([,:;{}]) ?/','$1',$css);

	/* Kill Trailing Semicolon, Contributed by Oliver */
	$css = preg_replace('/;}/','}',$css);

        // Replace images with data:uri
        $urls = array();
        preg_match_all('/url\(([^\)]+)\)/', $css, $urls);
        
        foreach ($urls[1] as $url) {
            $data_uri = 'data:image/png;base64,' . base64_encode(file_get_contents($url));
            $css = str_replace($url, $data_uri, $css);
        }
        
        file_put_contents('tree.min.css', $css);
	