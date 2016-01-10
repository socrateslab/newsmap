<?php
    require('constants.php');

    $type = $_GET['type'];
    if($type=='yearbar')
        setYearChina();
    if($type=='weekline')
        setRecentWeekChina();
    if($type=='monthpie')
        setLastMonthChina();
    if($type=='dot')
        setAllChina();
    if($type=='month')
        setRecentMonthChina();
    
    function setRecentMonthChina(){
        if(($con=mysql_connect(dbServer,dbUserName,dbPassword))===FALSE)
            die("could not connect to database");

        //验证服务器连接
        if(mysql_select_db(database)===FALSE)
            die("could not connect to database");
        $beijing="";$jiangsu="";$shanghai="";$zhejiang="";$guangdong="";
        for($i=1;$i<4;$i++){
            $month = date('m',time());
            $year = date('Y',time());
            $month = $month-$i;
            if($month==0){
                $month=12;
                $year=$year-1;
            }
            if($month<0){
                $month=11;
                $year=$year-1;
            }
            $day="01";
            $beginDate=$_date = date("Ymd",mktime(0,0,0,$month,$day,$year));
            $endDate = date('Ymd', strtotime("$beginDate +1 month"));
            
            $sql="Select ActionGeo_ADM1Code,count(*) as newsnum,DATEADDED from chinadata where (ActionGeo_ADM1Code='CH22' or ActionGeo_ADM1Code='CH23' or ActionGeo_ADM1Code='CH04' or ActionGeo_ADM1Code='CH02' or ActionGeo_ADM1Code='CH30') and DATEADDED>='$beginDate' and DATEADDED<'$endDate' group by ActionGeo_ADM1Code";
            $result = mysql_query($sql);
            if($result===FALSE)
                die("could not query database");
            while($row = mysql_fetch_array($result)){
                //echo $row['newsnum']." ";
                switch($row['ActionGeo_ADM1Code']){
                    case 'CH02':
                        $zhejiang=$zhejiang.$row['newsnum'];
                        break;
                    case 'CH04':
                        $jiangsu=$jiangsu.$row['newsnum'];
                        break;
                    case 'CH22':
                        $beijing=$beijing.$row['newsnum'];
                        break;
                    case 'CH23':
                        $shanghai=$shanghai.$row['newsnum'];
                        break;
                    case 'CH30':
                        $guangdong=$guangdong.$row['newsnum'];
                        break;
                }
            }
            if($i<3){
                $zhejiang=$zhejiang.",";
                $jiangsu=$jiangsu.",";
                $beijing=$beijing.",";
                $shanghai=$shanghai.",";
                $guangdong=$guangdong.",";
            }
        }
        $return=array("beijing"=>$beijing,"shanghai"=>$shanghai,"jiangsu"=>$jiangsu,"zhejiang"=>$zhejiang,"guangdong"=>$guangdong);
        
        foreach ( $return as $key => $value ) {  
            $return[$key] = urlencode ( $value );  
        }
        echo urldecode(json_encode($return));
        
    }

    function setAllChina(){
        if(($con=mysql_connect(dbServer,dbUserName,dbPassword))===FALSE)
            die("could not connect to database");
        //验证服务器连接
        if(mysql_select_db(database)===FALSE)
            die("could not connect to database");
        
        $sql="Select ActionGeo_ADM1Code as province,count(*) as newsnum from chinadata where ActionGeo_CountryCode='CH' group by ActionGeo_ADM1Code union Select ActionGeo_CountryCode as province,count(*) as newsnum from chinadata where (ActionGeo_CountryCode='MC' or ActionGeo_CountryCode='HK' or ActionGeo_CountryCode='TW') group by ActionGeo_CountryCode
";
        $result = mysql_query($sql);
        if($result===FALSE)
            die("could not query database");
        while($row = mysql_fetch_array($result)){
            switch($row['province']){
                case 'CH01':
                    $anhui=$row['newsnum'];
                    break;
                case 'CH02':
                    $zhejiang=$row['newsnum'];
                    break;
                case 'CH03':
                    $jiangxi=$row['newsnum'];
                    break;
                case 'CH04':
                    $jiangsu=$row['newsnum'];
                    break;
                case 'CH05':
                    $jilin=$row['newsnum'];
                    break;
                case 'CH06':
                    $qinghai=$row['newsnum'];
                    break;
                case 'CH07':
                    $fujian=$row['newsnum'];
                    break;
                case 'CH08':
                    $heilongjiang=$row['newsnum'];
                    break;
                case 'CH09':
                    $henan=$row['newsnum'];
                    break;
                case 'CH10':
                    $hebei=$row['newsnum'];
                    break;
                case 'CH11':
                    $hunan=$row['newsnum'];
                    break;
                case 'CH12':
                    $hubei=$row['newsnum'];
                    break;
                case 'CH13':
                    $xinjiang=$row['newsnum'];
                    break;
                case 'CH14':
                    $xizang=$row['newsnum'];
                    break;
                case 'CH15':
                    $gansu=$row['newsnum'];
                    break;
                case 'CH16':
                    $guangxi=$row['newsnum'];
                    break;
                case 'CH18':
                    $guizhou=$row['newsnum'];
                    break;
                case 'CH19':
                    $liaoning=$row['newsnum'];
                    break;
                case 'CH20':
                    $neimeng=$row['newsnum'];
                    break;
                case 'CH21':
                    $ningxia=$row['newsnum'];
                    break;
                case 'CH22':
                    $beijing=$row['newsnum'];
                    break;
                case 'CH23':
                    $shanghai=$row['newsnum'];
                    break;
                case 'CH24':
                    $shanxi=$row['newsnum'];
                    break;
                case 'CH25':
                    $shandong=$row['newsnum'];
                    break;
                case 'CH26':
                    $shaanxi=$row['newsnum'];
                    break;
                case 'CH28':
                    $tianjin=$row['newsnum'];
                    break;
                case 'CH29':
                    $yunnan=$row['newsnum'];
                    break;
                case 'CH30':
                    $guangdong=$row['newsnum'];
                    break;
                case 'CH31':
                    $hainan=$row['newsnum'];
                    break;
                case 'CH32':
                    $sichuan=$row['newsnum'];
                    break;
                case 'CH33':
                    $chongqing=$row['newsnum'];
                    break;
                case 'HK':
                    $hongkong=$row['newsnum'];
                    break;
                case 'MC':
                    $macau=$row['newsnum'];
                    break;
                case 'TW':
                    $taiwan=$row['newsnum'];
                    break;
            }
        }
        $return=array("beijing"=>$beijing,"tianjin"=>$tianjin,"chongqing"=>$chongqing,"shanghai"=>$shanghai,"hebei"=>$hebei,"shanxi"=>$shanxi,"liaoning"=>$liaoning,"jilin"=>$jilin,"heilongjiang"=>$heilongjiang,"jiangsu"=>$jiangsu,"zhejiang"=>$zhejiang,"anhui"=>$anhui,"fujian"=>$fujian,"jiangxi"=>$jiangxi,"shandong"=>$shandong,"henan"=>$henan,"hubei"=>$hubei,"hunan"=>$hunan,"guangdong"=>$guangdong,"hainan"=>$hainan,"sichuan"=>$sichuan,"guizhou"=>$guizhou,"yunnan"=>$yunnan,"shaanxi"=>$shaanxi,"gansu"=>$gansu,"qinghai"=>$qinghai,"taiwan"=>$taiwan,"neimeng"=>$neimeng,"guangxi"=>$guangxi,"xizang"=>$xizang,"ningxia"=>$ningxia,"xinjiang"=>$xinjiang,"hongkong"=>$hongkong,"macau"=>$macau);
        
        foreach ( $return as $key => $value ) {  
            $return[$key] = urlencode ( $value );  
        }
        echo urldecode(json_encode($return));
    }

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
        $day="01";
        $beginDate=$_date = date("Ymd",mktime(0,0,0,$month,$day,$year));
        $endDate = date('Ymd', strtotime("$beginDate +1 month"));
        $sql="Select ActionGeo_ADM1Code as province,count(*) as newsnum from chinadata where ActionGeo_CountryCode='CH' and DATEADDED>='$beginDate' and DATEADDED<'$endDate' group by ActionGeo_ADM1Code union Select ActionGeo_CountryCode as province,count(*) as newsnum from chinadata where (ActionGeo_CountryCode='MC' or ActionGeo_CountryCode='HK' or ActionGeo_CountryCode='TW') and DATEADDED>='$beginDate' and DATEADDED<'$endDate' group by ActionGeo_CountryCode order by newsnum desc
";
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


    function setRecentWeekChina(){
         if(($con=mysql_connect(dbServer,dbUserName,dbPassword))===FALSE)
            die("could not connect to database");

        //验证服务器连接
        if(mysql_select_db(database)===FALSE)
            die("could not connect to database");
        $beijing="";$jiangsu="";$shanghai="";$zhejiang="";$date="";
        $endDate = date('Ymd');
        $beginDate=date("Ymd",strtotime("$endDate -2 week"));
        $sql="Select ActionGeo_ADM1Code,count(*) as newsnum,DATEADDED from chinadata where (ActionGeo_ADM1Code='CH22' or ActionGeo_ADM1Code='CH23' or ActionGeo_ADM1Code='CH04' or ActionGeo_ADM1Code='CH02') and DATEADDED>='$beginDate' and DATEADDED<'$endDate' group by ActionGeo_ADM1Code,DATEADDED order by DATEADDED desc";
        $result = mysql_query($sql);
        if($result===FALSE)
            die("could not query database");
        $i=0;
        while($row = mysql_fetch_array($result)){
            switch($row['ActionGeo_ADM1Code']){
                case 'CH02':
                    $zhejiang=$zhejiang.$row['newsnum'];
                    //if($i<24)
                        $zhejiang=$zhejiang.",";
                    //break;
                case 'CH04':
                    $jiangsu=$jiangsu.$row['newsnum'];
                    //if($i<24)
                        $jiangsu=$jiangsu.",";
                    //break;
                case 'CH22':
                    $beijing=$beijing.$row['newsnum'];
                    //if($i<24)
                        $beijing=$beijing.",";
                    //break;
                case 'CH23':
                    $shanghai=$shanghai.$row['newsnum'];
                    //if($i<24)
                        $shanghai=$shanghai.",";
                    //break;
            }
            if($i%4==0){
                $str = $row['DATEADDED'];
                $str1 = substr($str,4,2);
                $str2 = substr($str,6,2);
                $date=$date.$str1."-".$str2;
            }
            if($i%4==0)
                $date=$date.",";
            $i=$i+1;
        }
        $return=array("beijing"=>$beijing,"shanghai"=>$shanghai,"jiangsu"=>$jiangsu,"zhejiang"=>$zhejiang,"date"=>$date);
        
        foreach ( $return as $key => $value ) {  
            $return[$key] = urlencode ( $value );  
        }
        echo urldecode(json_encode($return));
    }

    function setYearChina(){
        //验证数据库服务器连接
        if(($con=mysql_connect(dbServer,dbUserName,dbPassword))===FALSE)
            die("could not connect to database");

        //验证服务器连接
        if(mysql_select_db(database)===FALSE)
            die("could not connect to database");
        
        //循环查询每月新闻数
        $beijing="";$tianjin="";$chongqing="";$shanghai="";$hebei="";$shanxi="";$liaoning="";$jilin="";$heilongjiang="";$jiangsu = "";$zhejiang="";$anhui="";$fujian="";$jiangxi="";$shandong="";$henan="";$hubei="";$hunan="";$guangdong="";$hainan="";$sichuan="";$guizhou="";$yunnan="";$shaanxi="";$gansu="";$qinghai="";$taiwan="";$neimeng="";$guangxi="";$xizang="";$ningxia="";$xinjiang="";$hongkong="";$macau="";
        for($i=1;$i<13;$i++){
            $year = '2015';
            if($i>1){
                $beijing=$beijing.",";
                $tianjin=$tianjin.",";
                $chongqing=$chongqing.",";
                $shanghai=$shanghai.",";
                $hebei=$hebei.",";
                $shanxi=$shanxi.",";
                $liaoning=$liaoning.",";
                $jilin=$jilin.",";
                $heilongjiang=$heilongjiang.",";
                $jiangsu = $jiangsu.",";
                $zhejiang=$zhejiang.",";
                $anhui=$anhui.",";
                $fujian=$fujian.",";
                $jiangxi=$jiangxi.",";
                $shandong=$shandong.",";
                $henan=$henan.",";
                $hubei=$hubei.",";
                $hunan=$hunan.",";
                $guangdong=$guangdong.",";
                $hainan=$hainan.",";
                $sichuan=$sichuan.",";
                $guizhou=$guizhou.",";
                $yunnan=$yunnan.",";
                $shaanxi=$shaanxi.",";
                $gansu=$gansu.",";
                $qinghai=$qinghai.",";
                $taiwan=$taiwan.",";
                $neimeng=$neimeng.",";
                $guangxi=$guangxi.",";
                $xizang=$xizang.",";
                $ningxia=$ningxia.",";
                $xinjiang=$xinjiang.",";
                $hongkong=$hongkong.",";
                $macau=$macau.",";
            }
            if($i<10)
                $month = "0".$i;
            else
                $month = $i;
            $day="01";
            $beginDate=$_date = date("Ymd",mktime(0,0,0,$month,$day,$year));
            $endDate = date('Ymd', strtotime("$beginDate +1 month"));
            $sql1 = "Select ActionGeo_ADM1Code,count(*) as newsnum from chinadata where ActionGeo_CountryCode='CH' and DATEADDED>='$beginDate' and DATEADDED<'$endDate' group by ActionGeo_ADM1Code";
            $result1 = mysql_query($sql1);
            $sql2 = "Select ActionGeo_CountryCode,count(*) as newsnum from chinadata where (ActionGeo_CountryCode='MC' or ActionGeo_CountryCode='HK' or ActionGeo_CountryCode='TW') and DATEADDED>='$beginDate' and DATEADDED<'$endDate' group by ActionGeo_CountryCode";
            $result2 = mysql_query($sql2);
            //验证数据库操作是否成功
            if($result1===FALSE||$result2===FALSE)
                die("could not query database");
            while($row = mysql_fetch_array($result1)){
                switch($row['ActionGeo_ADM1Code']){
                    case 'CH01':
                        $anhui=$anhui.$row['newsnum'];
                        break;
                    case 'CH02':
                        $zhejiang=$zhejiang.$row['newsnum'];
                        break;
                    case 'CH03':
                        $jiangxi=$jiangxi.$row['newsnum'];
                        break;
                    case 'CH04':
                        $jiangsu=$jiangsu.$row['newsnum'];
                        break;
                    case 'CH05':
                        $jilin=$jilin.$row['newsnum'];
                        break;
                    case 'CH06':
                        $qinghai=$qinghai.$row['newsnum'];
                        break;
                    case 'CH07':
                        $fujian=$fujian.$row['newsnum'];
                        break;
                    case 'CH08':
                        $heilongjiang=$heilongjiang.$row['newsnum'];
                        break;
                    case 'CH09':
                        $henan=$henan.$row['newsnum'];
                        break;
                    case 'CH10':
                        $hebei=$hebei.$row['newsnum'];
                        break;
                    case 'CH11':
                        $hunan=$hunan.$row['newsnum'];
                        break;
                    case 'CH12':
                        $hubei=$hubei.$row['newsnum'];
                        break;
                    case 'CH13':
                        $xinjiang=$xinjiang.$row['newsnum'];
                        break;
                    case 'CH14':
                        $xizang=$xizang.$row['newsnum'];
                        break;
                    case 'CH15':
                        $gansu=$gansu.$row['newsnum'];
                        break;
                    case 'CH16':
                        $guangxi=$guangxi.$row['newsnum'];
                        break;
                    case 'CH18':
                        $guizhou=$guizhou.$row['newsnum'];
                        break;
                    case 'CH19':
                        $liaoning=$liaoning.$row['newsnum'];
                        break;
                    case 'CH20':
                        $neimeng=$neimeng.$row['newsnum'];
                        break;
                    case 'CH21':
                        $ningxia=$ningxia.$row['newsnum'];
                        break;
                    case 'CH22':
                        $beijing=$beijing.$row['newsnum'];
                        break;
                    case 'CH23':
                        $shanghai=$shanghai.$row['newsnum'];
                        break;
                    case 'CH24':
                        $shanxi=$shanxi.$row['newsnum'];
                        break;
                    case 'CH25':
                        $shandong=$shandong.$row['newsnum'];
                        break;
                    case 'CH26':
                        $shaanxi=$shaanxi.$row['newsnum'];
                        break;
                    case 'CH28':
                        $tianjin=$tianjin.$row['newsnum'];
                        break;
                    case 'CH29':
                        $yunnan=$yunnan.$row['newsnum'];
                        break;
                    case 'CH30':
                        $guangdong=$guangdong.$row['newsnum'];
                        break;
                    case 'CH31':
                        $hainan=$hainan.$row['newsnum'];
                        break;
                    case 'CH32':
                        $sichuan=$sichuan.$row['newsnum'];
                        break;
                    case 'CH33':
                        $chongqing=$chongqing.$row['newsnum'];
                        break;
                }
                
            }
            
            while($row = mysql_fetch_array($result2)){
                switch($row['ActionGeo_CountryCode']){
                    case 'HK':
                        $hongkong=$hongkong.$row['newsnum'];
                        break;
                    case 'MC':
                        $macau=$macau.$row['newsnum'];
                        break;
                    case 'TW':
                        $taiwan=$taiwan.$row['newsnum'];
                        break;
                }
            }
        }
        $return=array("beijing"=>$beijing,"tianjin"=>$tianjin,"chongqing"=>$chongqing,"shanghai"=>$shanghai,"hebei"=>$hebei,"shanxi"=>$shanxi,"liaoning"=>$liaoning,"jilin"=>$jilin,"heilongjiang"=>$heilongjiang,"jiangsu"=>$jiangsu,"zhejiang"=>$zhejiang,"anhui"=>$anhui,"fujian"=>$fujian,"jiangxi"=>$jiangxi,"shandong"=>$shandong,"henan"=>$henan,"hubei"=>$hubei,"hunan"=>$hunan,"guangdong"=>$guangdong,"hainan"=>$hainan,"sichuan"=>$sichuan,"guizhou"=>$guizhou,"yunnan"=>$yunnan,"shaanxi"=>$shaanxi,"gansu"=>$gansu,"qinghai"=>$qinghai,"taiwan"=>$taiwan,"neimeng"=>$neimeng,"guangxi"=>$guangxi,"xizang"=>$xizang,"ningxia"=>$ningxia,"xinjiang"=>$xinjiang,"hongkong"=>$hongkong,"macau"=>$macau);
        
        foreach ( $return as $key => $value ) {  
            $return[$key] = urlencode ( $value );  
        }
        echo urldecode(json_encode($return));

    }
?>
