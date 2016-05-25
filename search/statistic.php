<?php
require_once('vendor/autoload.php');  

$keyword = $_GET['word'];
$source_type = $_GET['source_type'];
$type = $_GET['type'];


if($source_type=="cn")
    $search_result=search($keyword);
if($source_type=="hk")
    $search_result=searchhk($keyword);

if($type=="source_percent"){
    getPercent($search_result);
}

function getPercent($search){
    $sum=0;
    $urlnum = [];
    foreach ( $search as $key => $value ) {  
        $url=$search[$key]["url"];
        $arr = explode("%2F",$url);
        $main_url = str_replace("www.","",$arr[2]);
        if (array_key_exists($main_url,$urlnum)){
            $urlnum[$main_url] = $urlnum[$main_url]+1;
        }
        else
            $urlnum[$main_url] = 1;
        $sum = $sum+1;
    }
    arsort($urlnum);
    $urlnum=array_slice($urlnum,0,6);
    $topurl = array();
    $i=0;
    foreach ( $urlnum as $key => $value ) {
        $item["source"] = $key;
        $item["num"] = $urlnum[$key];
        $topurl[$i] = $item;
        $i = $i+1;
    }
    $topurl["sum"] = $sum;
    echo urldecode(json_encode($topurl));
}

function searchhk($word){  
    //Elastic search php client  
    $client = new Elasticsearch\Client();  
    $params = array();  
    $params['index'] = 'news_hk';  
    $params['type'] = 'news_info';  
    $params['from'] = 0;
    $params['size'] = 3000;
    $params['body']['query']['match']['title'] = $word;  
  
    $rtn = $client->search($params);  
    $list=$rtn["hits"]["hits"];
    
    $output = [];
    $i=0;
    foreach ( $list as $key => $value ) {  
        $info=$list[$key]["_source"];
        unset($info["content"]); 
        foreach ( $info as $key => $value ) {  
            $info[$key] = urlencode ( str_replace(array("\r\n", "\r", "\n"), "", $value) ); 
        } 
        
        $output[$i] = $info;
        $i = $i+1;
    }
    return $output;
    
} 

function search($word){  
    //Elastic search php client  
    $client = new Elasticsearch\Client();  
    $params = array();  
    $params['index'] = 'news';  
    $params['type'] = 'news_info';  
    $params['from'] = 0;
    $params['size'] = 3000;
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
    return $output;
    
} 

?>