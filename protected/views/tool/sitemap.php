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

</style>

<h1>网站地图自动生成V0.1(免费)</h1>
<div id="msg">请知晓下面的事项</div>
<div class="one">可以自由分发整理的结果,请保留本站的链接以及保证内容的完整性</div>
<div class="two">程序只识别正常的html链接,忽略js生成的跳转代码</div>
<div class="three">程序采用单线程取得内容,不会对目标服务器造成很大压力</div>
<div class="four">程序会自动分析目标网站的内容并生成网站地图,不限页数,当前版本只支持两层逻辑深度</div>
<div id="msg">整理出的网站地图内容系FeeDiy根据您的指令自动整理的结果,不代表FeeDiy赞成被整理网站的内容或立场</div>

<input class="ibox" type="text" value="http://www.mtianya.com" size="63" name="initurl" id="initurl">
<input class="but" type="button" value="分析" id="st1">
<br />
    <table>
<tr>
<td id="deep_0"></td>
<td id="deep_1"></td>
<td id="deep_2"></td>
</tr>
    </table>
<script type="text/javascript">
//<![CDATA[
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

(function($) {
    $.fn.siteMap = function(settings) {
        var the_url = '';
        var url_data = new Array(3);
        var url_depth = 0;

        settings = jQuery.extend({
            api_url: '/tool/getlinks'
        },settings || {});
        
        this.click(function (){
//            var a = [1,323,'ada','3',3,'4','bb','','bb'];
//            document.write(a, ' <br/> ');
//            document.write(a.unquie(), ' <br/> ');
//            _trace(the_url, 'alert');
            _run();
        });

        var get_the_url = function(){
            if(url_depth==0){
                url_depth++;
                the_url = $("#initurl").val();
            }else{
                if(url_data[url_depth]!='' && url_data[url_depth]!=undefined){
//                    _trace(url_data[url_depth], 'alert');
                    the_url = url_data[url_depth].shift();
                }else{
                    url_depth++;
                    if(url_data[url_depth]!='' && url_data[url_depth]!=undefined){
                        the_url = url_data[url_depth].shift();
                    }else{
                        return '';
                    }
                }
            }

            $('#deep_'+url_depth).append('<p>', the_url.link(the_url), '</p>');
        }

        var _run = function(){
            get_the_url();
            if(the_url!=''){
                _get_url_list();
            }
        }

        var _get_url_list = function (){
            jQuery.ajax({
                'url':settings.api_url,
                'success':_save_url_list,
                'dataType':'json',
                'data':{'src':the_url},
                'cache':false
            });
        }

        var _save_url_list = function (list){
            if(list==null || list.status==null || list.status!=200 || list.data==null){
                _run();
                return false;
            }
            if(url_depth<3){
                var url_depth_top=url_depth+1;
                if(url_data[url_depth_top]==undefined){
                    url_data[url_depth_top]=[];
                }
                for(var i=0;i<list.count;i++){
                    var one_url=list.data[i];
                    url_data[url_depth_top].push(one_url);
                }
            }
//            document.write(url_data);
            _run();
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