# -*- coding: utf-8 -*-
import urllib2
import json
import sys
import csv
import threading
from threading import Timer
import time
reload(sys)
sys.setdefaultencoding('utf8')
sys.setrecursionlimit(1000000)
timer_interval=1

class Download():
    global allProvince
    allProvince = {"北京":0,
                       "天津":0,
                       "重庆":0,
                       "河北":0,
                       "山西":0,
                       "辽宁":0,
                       "吉林":0,
                       "黑龙江":0,
                       "江苏":0,
                       "上海":0,
                       "浙江":0,
                       "安徽":0,
                       "福建":0,
                       "江西":0,
                       "山东":0,
                       "河南":0,
                       "湖北":0,
                       "湖南":0,
                       "广东":0,
                       "海南":0,
                       "四川":0,
                       "贵州":0,
                       "云南":0,
                       "陕西":0,
                       "甘肃":0,
                       "青海":0,
                       "台湾":0,
                       "内蒙古":0,
                       "广西":0,
                       "西藏":0,
                       "宁夏":0,
                       "新疆":0,
                       "香港":0,
                       "澳门":0}


    def getToday(self):
        now = int(time.time())
        #转换为其他日期格式,如:"%Y-%m-%d %H:%M:%S"
        timeArray = time.localtime(now)
        return  timeArray

    def fileOut(self,list):
        timeArray = Download.getToday(self)
        today = time.strftime("%y%m%d", timeArray)
        otherStyleTime = time.strftime("%m.%d", timeArray)
        writetime = time.strftime("%Y-%m-%d %H:%M:%S",timeArray)
        txtfile = file("writeTime.txt",'w')
        txtfile.write(writetime)

        csvfile = file(today+'.csv', 'wb')
        writer = csv.writer(csvfile)
        writer.writerow(['NAME','NEWS'+otherStyleTime])
        data = [
            ("北京", list["北京"]),
            ("天津",list["天津"]),
            ("重庆",list["重庆"]),
            ("河北",list["河北"]),
            ("山西", list["山西"]),
            ("辽宁",list["辽宁"]),
            ("吉林",list["吉林"]),
            ("黑龙江",list["黑龙江"]),
            ("江苏", list["江苏"]),
            ("上海",list["上海"]),
            ("安徽",list["安徽"]),
            ("浙江",list["浙江"]),
            ("福建", list["福建"]),
            ("江西",list["江西"]),
            ("山东",list["山东"]),
            ("河南",list["河南"]),
            ("湖北", list["湖北"]),
            ("湖南",list["湖南"]),
            ("广东",list["广东"]),
            ("海南",list["海南"]),
            ("四川", list["四川"]),
            ("贵州",list["贵州"]),
            ("云南",list["云南"]),
            ("陕西",list["陕西"]),
            ("甘肃", list["甘肃"]),
            ("青海",list["青海"]),
            ("内蒙古",list["内蒙古"]),
            ("宁夏",list["宁夏"]),
            ("广西",list["广西"]),
            ("西藏",list["西藏"]),
            ("新疆",list["新疆"]),
            ("香港",list["香港"]),
            ("澳门",list["澳门"]),
            ("台湾",list["台湾"])
        ]
        writer.writerows(data)
        csvfile.close()

    def judge(self,beginday):
        timeArray = Download.getToday(self)
        today = time.strftime("%Y%m%d", timeArray)
        if beginday!=today:
            global allProvince
            allProvince = {"北京":0,
                       "天津":0,
                       "重庆":0,
                       "河北":0,
                       "山西":0,
                       "辽宁":0,
                       "吉林":0,
                       "黑龙江":0,
                       "江苏":0,
                       "上海":0,
                       "浙江":0,
                       "安徽":0,
                       "福建":0,
                       "江西":0,
                       "山东":0,
                       "河南":0,
                       "湖北":0,
                       "湖南":0,
                       "广东":0,
                       "海南":0,
                       "四川":0,
                       "贵州":0,
                       "云南":0,
                       "陕西":0,
                       "甘肃":0,
                       "青海":0,
                       "台湾":0,
                       "内蒙古":0,
                       "广西":0,
                       "西藏":0,
                       "宁夏":0,
                       "新疆":0,
                       "香港":0,
                       "澳门":0}
            return today
        return beginday

    def count(self,newslist):
        n = len(newslist)
        for i in range(n):
            pro = newslist[i]["Country"]
            if len(pro)!=0:
                if pro.find("Beijing")>=0:
                    allProvince["北京"]+=1
                    continue;
                if pro.find("Shanghai")>=0:
                    allProvince["上海"]+=1
                    continue;
                if pro.find("Tianjin")>=0:
                    allProvince["天津"]+=1
                    continue;
                if pro.find("Chongqing")>=0:
                    allProvince["重庆"]+=1
                    continue;
                if pro.find("Hebei")>=0:
                    allProvince["河北"]+=1
                    continue;
                if pro.find("Shanxi")>=0:
                    allProvince["山西"]+=1
                    continue;
                if pro.find("Shannxi")>=0:
                    allProvince["陕西"]+=1
                    continue
                if pro.find("Liaoning")>=0:
                    allProvince["辽宁"]+=1
                    continue;
                if pro.find("Jilin")>=0:
                    allProvince["吉林"]+=1
                    continue;
                if pro.find("Heilongjiang")>=0:
                    allProvince["黑龙江"]+=1
                    continue;
                if pro.find("Jiangsu")>=0:
                    allProvince["江苏"]+=1
                    continue;
                if pro.find("Zhejiang")>=0:
                    allProvince["浙江"]+=1
                    continue;
                if pro.find("Anhui")>=0:
                    allProvince["安徽"]+=1
                    continue;
                if pro.find("Fujian")>=0:
                    allProvince["福建"]+=1
                    continue;
                if pro.find("Jiangxi")>=0:
                    allProvince["江西"]+=1
                    continue;
                if pro.find("Shandong")>=0:
                    allProvince["山东"]+=1
                    continue;
                if pro.find("Henan")>=0:
                    allProvince["河南"]+=1
                    continue;
                if pro.find("Hubei")>=0:
                    allProvince["湖北"]+=1
                    continue;
                if pro.find("Hunan")>=0:
                    allProvince["湖南"]+=1
                    continue;
                if pro.find("Guangdong")>=0:
                    allProvince["广东"]+=1
                    continue;
                if pro.find("Hainan")>=0:
                    allProvince["海南"]+=1
                    continue;
                if pro.find("Sichuan")>=0:
                    allProvince["四川"]+=1
                    continue;
                if pro.find("Guizhou")>=0:
                    allProvince["贵州"]+=1
                    continue;
                if pro.find("Yunnan")>=0:
                    allProvince["云南"]+=1
                    continue;
                if pro.find("Gansu")>=0:
                    allProvince["甘肃"]+=1
                    continue;
                if pro.find("Qinghai")>=0:
                    allProvince["青海"]+=1
                    continue;
                if pro.find("Inner Mongolia")>=0:
                    allProvince["内蒙古"]+=1
                    continue;
                if pro.find("Guangxi")>=0:
                    allProvince["广西"]+=1
                    continue;
                if pro.find("Xizang")>=0:
                    allProvince["西藏"]+=1
                    continue;
                if pro.find("Ningxia")>=0:
                    allProvince["宁夏"]+=1
                    continue;
                if pro.find("Xinjiang")>=0:
                    allProvince["新疆"]+=1
                    continue;
                if pro.find("Hong Kong")>=0:
                    allProvince["香港"]+=1
                    continue;
                if pro.find("Macao")>=0:
                    allProvince["澳门"]+=1
                    continue;
                if pro.find("Taiwan")>=0:
                    allProvince["台湾"]+=1
                    continue;
        return allProvince

    def getList(self):
        url = 'http://api.gdeltproject.org/api/v1/gkg_geojson?QUERY=geoname:China&TIMESPAN=15'
        page = urllib2.urlopen(url)
        data = json.loads(page.read())["features"]
        n = len(data)
        newslist = [0.0 for i in range(n)]
        for i in range(n):
            b = data[i]
            newslist[i] = {'position':b["geometry"]["coordinates"],'Country':b["properties"]["name"],'Date':b["properties"]["urlpubtimedate"]}
        return newslist

    def calProvince(self,latitude,longitude):
        url = 'http://apis.baidu.com/3023/geo/address?l='+str(latitude)+'%2C'+str(longitude)
        req = urllib2.Request(url)
        req.add_header("apikey", "019de2607b5d17aa64edce975c649ebd")
        resp = urllib2.urlopen(req)
        content = resp.read()
        d=json.JSONDecoder().decode(content)
        province = d["addrList"][1]["admName"]
        print(province)
        return province


if __name__ == '__main__':
    s = Download()
    timeArray = s.getToday()
    beginday = time.strftime("%Y%m%d", timeArray)
    def delayrun():
        print 'running'
    t=Timer(timer_interval,delayrun)
    t.start()
    while True:
        print 'main running'
        c = s.getList()
        beginday = s.judge(beginday)
        a = s.count(c)
        s.fileOut(a)
        time.sleep(900)

