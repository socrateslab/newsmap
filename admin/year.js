function setTag(year){
    for(var i=2010;i<2016;i++){
        document.getElementById("tag"+i).className="";
    }
    document.getElementById("tag"+year).className="active";
}
function setYear(year){
    $.ajax({
        //提交数据的类型 POST GET
        type:"GET",
        //提交的网址
        url:"admin/yearchoose.php",
        //提交的数据
        data:{year:year,type:'set'},
        //返回数据的格式
        datatype: "text",//"xml", "html", "script", "json", "jsonp", "text".
        success:function(data){
            ReDraw();
        }
    });
    
}