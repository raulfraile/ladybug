<?php








//include_once __DIR__.'/../../../vendor/autoload.php';
//$oCssParser = new Sabberworm\CSS\Parser(file_get_contents(__DIR__ . '/dependencies/bootstrap.css'));
//$oCssDocument = $oCssParser->parse();
//
//$selectors = $oCssDocument->getAllDeclarationBlocks();
//
//$css = '';
//foreach ($selectors as $item) {
//    /** @var $item Sabberworm\CSS\RuleSet\DeclarationBlock */
//    $css .= '.ladybug ' . $item;
//}




$css = file_get_contents('tree.css');

// comments
$css = preg_replace('!/\*.*?\*/!s','', $css);
$css = preg_replace('/\n\s*\n/',"\n", $css);

// minify
$css = preg_replace('/[\n\r \t]/',' ', $css);
$css = preg_replace('/ +/',' ', $css);
$css = preg_replace('/ ?([,:;{}]) ?/','$1',$css);

// trailing semicolon
$css = preg_replace('/;}/','}',$css);

// replace images with data:uri
$urls = array();
preg_match_all('/url\(([^\)]+)\)/', $css, $urls);

foreach ($urls[1] as $url) {
    $data_uri = 'data:image/png;base64,' . base64_encode(file_get_contents(__DIR__.'/images/'.$url));
    $css = str_replace($url, $data_uri, $css);
}

$css = trim($css);


// save file
file_put_contents('tree.min.css', $css);