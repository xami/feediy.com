<?php $this->pageTitle=Yii::app()->name;
$cs=Yii::app()->clientScript;
$cs->registerCoreScript('jquery');

?>
<style type="text/css">
#msg {
    background: none repeat scroll 0 0 #E6E6E6;
    color: red;
    height: 20px;
    line-height: 20px;
    text-align: center;
    margin: 20px 0;
}
.one {
	background: url(/images/circular-1.gif) top left no-repeat;
	padding-left: 30px;
	padding-bottom: 5px;
}
.two {
	background: url(/images/circular-2.gif) top left no-repeat;
	padding-left: 30px;
	padding-bottom: 5px;
}
.three {
	background: url(/images/circular-3.gif) top left no-repeat;
	padding-left: 30px;
	padding-bottom: 5px;
}
.four {
	background: url(/images/circular-4.gif) top left no-repeat;
	padding-left: 30px;
	padding-bottom: 5px;
}

#box{
    float: left;
}
.ibox {
    background: none repeat scroll 0 0 #E5ECF9;
    border: 2px solid #CCCCCC;
    font: 14px "Trebuchet MS","Helvetica",sans-serif;
    padding: 4px;
    height: 19px;
}
.but {
    background: url("/images/but.gif") repeat-x scroll 50% top #CDE4F2;
    border: 1px solid #C5E2F2;
    cursor: pointer;
    height: 30px;
    margin-left: 5px;
    width: 60px;
}

#info{
    font-size: 14px;
    font-weight: bold;
    line-height: 33px;
    float: right;
}
    #info .ih{
        float: left;
        width: 180px;
    }
    #info .ib{
        float: left;
        width: 180px;
    }

#deep{
    clear: both;
}
    #deep .up{
        border-bottom: 1px solid #AAC1DE;
        background-color: #C1D9F3;
        padding: 6px 7px 4px;
    }
    #deep .down{
        background-color: #F2F4F6;
        border-bottom: 1px solid #C1C8D2;
        padding: 6px 7px 4px;
    }

#setting{
    margin: 5px;
}
    #setting .msbox {
    background: none repeat scroll 0 0 #E5ECF9;
    border: 2px solid #CCCCCC;
    font: 14px "Trebuchet MS","Helvetica",sans-serif;
    height: 19px;
}
</style>

<h1>网站地图自动生成V0.1(免费)</h1>
<div id="msg">请知晓下面的事项</div>
<div class="one">可以自由分发整理的结果,请保留本站的链接以及保证内容的完整性</div>
<div class="two">程序只识别正常的html链接,忽略js生成的跳转代码</div>
<div class="three">程序采用单线程取得内容,不会对目标服务器造成很大压力</div>
<div class="four">程序会自动分析目标网站的内容并生成网站地图,不限页数,当前版本只支持两层逻辑深度</div>
<div id="msg">整理出的网站地图内容系FeeDiy根据您的指令自动整理的结果,不代表FeeDiy赞成被整理网站的内容或立场</div>

<div id="setting">
    爬行延时:&nbsp;&nbsp;<input class="msbox" type="text" value="1000" size="6" name="ms" id="ms">毫秒
</div>
<div id="box">
    <input class="ibox" type="text" value="http://www.mtianya.com" size="63" name="initurl" id="initurl">
    <input class="but" type="button" value="分析" id="st1">
</div>
<div id="info"></div>
    
<br />

<div id="deep"></div>

<script type="text/javascript">
//<![CDATA[
/*
Array.prototype.distinct1 = function(){
    //需要考虑数组内容中包含boolean,string类型数据。
    var newArray=[] , provisionalTable = {};
    for (var i = 0, item; (item= this[i]) != null; i++) {
        if (!provisionalTable[item] && item != "") {
             newArray.push(item);
             provisionalTable[item] = true;
         }
     }
    return newArray;
};

Array.prototype.distinct2 = function(){
var b=[];
var obj={};
for(var i=0;i<this.length;i++){
    obj[this[i]]=this[i];
}
for(var a in obj){
    if(obj[a]!=false){
        b.push(obj[a]);
    }
}
return b;
};
*/

function in_array(stringToSearch, arrayToSearch) {
        for (s = 0; s < arrayToSearch.length; s++) {
                thisEntry = arrayToSearch[s].toString();
                if (thisEntry == stringToSearch) {
                        return true;
                }
        }
        return false;
}

function distinct_r(sr, r) {
    //需要考虑数组内容中包含boolean,string类型数据。
    var newArray=[] , provisionalTable = {};
    for (var i = 0, item; (item= r[i]) != null; i++) {
        if (!provisionalTable[item] && item != "") {
            if(!in_array(item,sr)){
                newArray.push(item);
            }
            provisionalTable[item] = true;
         }
     }
    return newArray;
}
/*
Array.prototype.distinct3 = function(sr){
    //需要考虑数组内容中包含boolean,string类型数据。
    var newArray=[] , provisionalTable = {};
    for (var i = 0, item; (item= this[i]) != null; i++) {
        if (!provisionalTable[item] && item != "") {
            if(!in_array(item,sr)){
                newArray.push(item);
            }
            provisionalTable[item] = true;
         }
     }
    return newArray;
};
*/


(function($) {
    $.fn.siteMap = function(settings) {
        var url_data=[];
        var coll_url=[];
        var info={};
        var os_mp=[];


        var _start_run = function(){
            $("#st1").attr({"disabled":"disabled"});
        }

        var _stop_run = function(){
            $("#st1").removeAttr("disabled");
        }
        _stop_run();

        var _init = function(){
            url_data = new Array(3);
            coll_url=[];
            info={};
            info.the_url='';
            info.url_depth=0;
        }

        settings = jQuery.extend({
            max_depth: 3, 
            api_url: '/tool/getlinks'
        },settings || {});
        
        this.click(function (){
//            var a = [1,323,'ada','3',3,'4','bb',''];
//            var b = ['323','3','bb','','ss','5t'];
//            alert(b.distinct3(a));
//            document.write(a, ' <br/> ');
//            document.write(a.unquie(), ' <br/> ');
//            _trace(info.the_url, 'alert');

            _init();
            _start_run();
            _run();
        });

        var show_links=[];
        var style='up';
        var show_info = function(){
            var m = Math.round((info.count/coll_url.length)*10000)/100;
            $("#info").html('').html('<div class="ih">发现链接:'+coll_url.length+'</div><div class="ib">已经爬行:'+info.count+'页('+m+'%)</div>');
            
            if(info.url_depth>1){
                show_links.unshift(info.the_url);
                show_links=show_links.slice(0,14);
                style=(style=='up') ? 'down' : 'up';
                var show_html='';
                for(var i=0;i<show_links.length;i++){
                    show_html+='<div class="'+style+'">[深度' + info.url_depth + ':序号'+ (info.count-i) +']&nbsp&nbsp;'+show_links[i].link(show_links[i]) + '</div>';
                    style=(style=='up') ? 'down' : 'up';
                }
                $('#deep').html('').html(show_html);
            }
        }
        
        var get_the_url = function(){
            if(info.url_depth==0){
                info.url_depth++;
                info.the_url = $("#initurl").val();
                info.count=1;
            }else{
                if(url_data[info.url_depth]!='' && url_data[info.url_depth]!=undefined){
                    info.the_url = url_data[info.url_depth].shift();
                }else{
                    info.url_depth++;
                    if(url_data[info.url_depth]!='' && url_data[info.url_depth]!=undefined){
                        info.the_url = url_data[info.url_depth].shift();
                    }else{
                        info.the_url = true;
                    }
                }
            }
//            alert(info.the_url+info.url_depth);
//            coll_url.push(info.the_url);
            return info.the_url;
        }

        var _run = function(){
            get_the_url();
            if(info.the_url==true){
                alert('谢谢,爬行完成,接下来你可以导出整理的网站地图');
                _stop_run();
                alert(os_mp);
                return true;
            }
            if(info.the_url!=''){
                _get_url_list();
            }else{
                alert('输入需要整理地图的网址');
            }
            show_info();
        }

        var _get_url_list = function (){
            jQuery.ajax({
                'url':settings.api_url,
                'success':_save_url_list,
                'dataType':'json',
                'data':{'src':info.the_url, 'ms':$("#ms").val()},
                'cache':false
            });
        }

        
        var _save_url_list = function (list){
            if(list==null || list.status==null || list.status!=200){
                if(list.data!=''){
                    alert(list.data);
                    _init();
                    return false;
                }
                _run();
                return false;
            }
            if(info.url_depth<settings.max_depth){
                var url_depth_top=info.url_depth+1;
                if(url_data[url_depth_top]==undefined){
                    url_data[url_depth_top]=[];
                }

                var obj_coll_cur={};
                for(var i=0;i<list.count;i++){
                    if(!in_array(list.data[i],coll_url)){
                        url_data[url_depth_top].push(list.data[i]);
                        coll_url.push(list.data[i]);
                        obj_coll_cur["list.data[i]"]=info.url_depth;
                        os_mp.push(obj_coll_cur);
                    }
                }
            }
            _run();
            info.count++;
            return true;
        };

        var _trace = function (x, traceType) {
            var type = typeof(x), message = '';

            switch (type) {
                case 'object':
                    message = traceObj(x, traceType);
                    break;
                default:
                    message = typeof(x) + ': ' + x + (traceType && traceType == 'alert' ? '\n' : '<br>');
                    break;
            }

            if (traceType && traceType == 'alert') {
                alert(message)
            } else {
                document.write(message)
            }

            function traceObj(x, traceType) {
                // 初始化对象属性
                if (traceObj.tabNum === undefined) {
                    traceObj.tabNum = 0;
                }

                var notice = '';
                if (traceType && traceType == 'alert') {
                    var tab = '\t', br = '\n';
                } else {
                    var tab = '&nbsp;&nbsp;&nbsp;&nbsp;', br = '<br>';
                }

                notice += typeof(x) + br;
                for (var t = 0; t <traceObj.tabNum; t++) {
                    notice += tab;
                }
                notice += '(' + br;
                for (var i in x) {
                    for (var t = 0; t <= traceObj.tabNum; t++) {
                        notice += tab;
                    }
                    if (typeof(x[i]) == 'object') {
                        notice += '[' + i + '] => ';
                        traceObj.tabNum++; // 增加缩进
                        notice += traceObj(x[i], traceType);
                        traceObj.tabNum--; // 减少缩进
                    } else {
                        notice += '[' + i + ']' + ' => ' + typeof(x[i]) + ': ' + x[i] + br;
                    }
                }
                for (var t = 0; t <traceObj.tabNum; t++) {
                    notice += tab;
                }
                notice += ')' + br;
                return notice;
            }
        }

    }
})(jQuery);
$('#st1').siteMap();
//]]>
</script>