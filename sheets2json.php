<?php
//BY ZuGeTOr IT
//https://www.facebook.com/zugetor
$id = @$_GET['id'];
header("content-type:application/json");
$opts = array('http' =>
    array(
        'method'  => 'GET',
        'header'  => 'Content-type: application/x-www-form-urlencoded \nUser-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36',
    )
);
$context  = stream_context_create($opts);
$text =  json_decode(@file_get_contents('https://spreadsheets.google.com/feeds/list/'.$id.'/od6/public/values?alt=json', false, $context),true);
$data = array();
$ex = array();
if($text == null){
	$data['result'] = "ERROR";
	echo(json_encode($data));
	die();
}
$data['result'] = "OK";
foreach (explode(", ",$text['feed']['entry'][0]['content']['$t']) as &$value) {
	$ex[] = explode(": ", $value)[0];
}
$data['header'] = $ex;
foreach ($text['feed']['entry'] as &$value) {
	$arr = array();
    $value = explode(", ", $value['content']['$t']);	
	foreach ($value as &$value1) {
		$value1 = explode(": ", $value1);
		$arr[$value1[0]] = $value1[1];
	}
	$data['content'][] = $arr;
}

echo(json_encode($data));
?>