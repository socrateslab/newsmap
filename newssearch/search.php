<?php
require_once('vendor/autoload.php');  

$keyword = $_GET['word'];
$page = $_GET['page'];
//echo $keyword;

search($keyword,$page);

function search($word,$page){  
    //Elastic search php client  
    $client = new Elasticsearch\Client();  
    $params = array();  
    $params['index'] = 'news';  
    $params['type'] = 'news_info';  
    $params['from'] = $page*30;
    $params['size'] = 30;
    $params['body']['query']['match']['title'] = $word;  
  
    $rtn = $client->search($params);  
    $list=$rtn["hits"]["hits"];
    
    $output = [];
    $i=0;
    foreach ( $list as $key => $value ) {  
        $info=$list[$key]["_source"];
        foreach ( $info as $key => $value ) {  
            $info[$key] = urlencode ( str_replace(array("\r\n", "\r", "\n"), "", $value) );  
        } 
        
        $output[$i] = $info;
        $i = $i+1;
    }
    echo urldecode(json_encode($output));
    
} 

?>