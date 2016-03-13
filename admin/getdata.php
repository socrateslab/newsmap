<?php
    require('constants.php');
    $type = $_GET['type'];
    if($type=='monthpie')
        setLastMonthChina();
    function setLastMonthChina(){
        if(($con=mysql_connect(dbServer,dbUserName,dbPassword))===FALSE)
            die("could not connect to database");
        //验证服务器连接
        if(mysql_select_db(database)===FALSE)
            die("could not connect to database");
        $data="";
        $province="";
        $i=0;
        $sum=0;
        $year = date('Y',time());
        $month = date('m',time());
        if($month=='01'){
            $month='12';
            $year = $year-1;
        }
        else
            $month = $month-1;
        if($month<10)
            $month = '0'.$month;
        $monthyear= $year.$month;
        $sql="Select ActionGeo_ADM1Code as province,count(*) as newsnum from chinadata where ActionGeo_CountryCode='CH' and MonthYear = '$monthyear' group by ActionGeo_ADM1Code union Select ActionGeo_CountryCode as province,count(*) as newsnum from chinadata where (ActionGeo_CountryCode='MC' or ActionGeo_CountryCode='HK' or ActionGeo_CountryCode='TW') and MonthYear>='$monthyear' group by ActionGeo_CountryCode order by newsnum desc";
        $result = mysql_query($sql);
        if($result===FALSE)
            die("could not query database");
        while($row = mysql_fetch_array($result)){
            $sum = $sum+$row['newsnum'];
            if($i<5){
                if($row['province']=="CH"||$row['province']=="CH00")
                    continue;
                else{
                    $pro="";
                    switch($row['province']){
                        case 'CH01':
                            $pro="安徽";
                            break;
                        case 'CH02':
                            $pro="浙江";
                            break;
                        case 'CH03':
                            $pro="江西";
                            break;
                        case 'CH04':
                            $pro="江苏";
                            break;
                        case 'CH05':
                            $pro="吉林";
                            break;
                        case 'CH06':
                            $pro="青海";
                            break;
                        case 'CH07':
                            $pro="福建";
                            break;
                        case 'CH08':
                            $pro="黑龙江";
                            break;
                        case 'CH09':
                            $pro="河南";
                            break;
                        case 'CH10':
                            $pro="河北";
                            break;
                        case 'CH11':
                            $pro="湖南";
                            break;
                        case 'CH12':
                            $pro="湖北";
                            break;
                        case 'CH13':
                            $pro="新疆";
                            break;
                        case 'CH14':
                            $pro="西藏";
                            break;
                        case 'CH15':
                            $pro="甘肃";
                            break;
                        case 'CH16':
                            $pro="广西";
                            break;
                        case 'CH18':
                            $pro="贵州";
                            $guizhou=$guizhou.$row['newsnum'];
                            break;
                        case 'CH19':
                            $pro="辽宁";
                            break;
                        case 'CH20':
                            $pro="内蒙古";
                            break;
                        case 'CH21':
                            $pro="宁夏";
                            break;
                        case 'CH22':
                            $pro="北京";
                            break;
                        case 'CH23':
                            $pro="上海";
                            break;
                        case 'CH24':
                            $pro="山西";
                            break;
                        case 'CH25':
                            $pro="山东";
                            break;
                        case 'CH26':
                            $pro="陕西";
                            break;
                        case 'CH28':
                            $pro="天津";
                            break;
                        case 'CH29':
                            $pro="云南";
                            break;
                        case 'CH30':
                            $pro="广东";
                            break;
                        case 'CH31':
                            $pro="海南";
                            break;
                        case 'CH32':
                            $pro="四川";
                            break;
                        case 'CH33':
                            $pro="重庆";
                            break;
                        case 'HK':
                            $pro="香港";
                            break;
                        case 'MC':
                            $pro="澳门";
                            break;
                        case 'TW':
                            $pro="台湾";
                            break;
                    }
                    $province=$province.$pro;
                    $data=$data.$row['newsnum'];
                    $i=$i+1;
                    if($i<5){
                        $data=$data.",";
                        $province=$province.",";
                    }
                }
            }
        }
        $return=array("sum"=>$sum,"data"=>$data,"province"=>$province);
        
        foreach ( $return as $key => $value ) {  
            $return[$key] = urlencode ( $value );  
        }
        echo urldecode(json_encode($return));
        
        
    }

?>