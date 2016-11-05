@extends('frontend.layouts.two')

@section('content')
    <div class="container">
        <div class="ui breadcrumb">
            <div class="section"> 当前位置：</div>
            <a class="section" href="{{url('')}}">首页</a>
            <i class="right angle icon divider"></i>
            <div class="section">搜索</div>
        </div>
    </div>

    <div id="jd">
        <script type="text/javascript">var jd_union_pid="524905187";var jd_union_euid="";</script><script type="text/javascript" src="http://ads.union.jd.com/static/js/union.js"></script>
    </div>
    <div id="suning">
        <style type="text/css">
            .box-body{position:relative;padding:22px 0;}
            .logo{float:left;margin-left:48px;}
            .union-o-search{float:left;width:auto;margin:20px  0 0 32px;}
            .union-o-search .search-keyword{width:361px;}
            .union-o-search .input-short{width:55px;}
            .union-o-search .input-long{width:290px;}
            .union-o-search .from_input ul li select{width:142px;}
            .union-o-search .tip a{margin-left:10px;}
            .union-o-search .union-btn{margin:10px 0 0 192px;}
            .union-search{position: relative;width: 600px;margin-left:134px;}
            .search-keyword, .search  .search-btn{float:left;color:#a9a9a9}
            .search-keyword{margin-top:0;width:458px;height:36px;padding:8px 10px 8px 10px;border:2px solid #FFAA00;border-right:0;font-size:14px;line-height:16px;}
            .search-btn{width:100px;height:36px;margin-top:0;padding: 0 30px;border:0;cursor:pointer;background:#FFAA00;letter-spacing: 7px;font-weight:bold;font-family:'MicroSoft YaHei';font-size:16px;color:#FFF;}
            .search-btn-hover{background:#347BE4;}
            .search-book{margin-right:50px;}
            .search-focus{background:none;}
            .search-focus .left-sidebar{background-position:-8px -18px;}
            .search-focus .right-sidebar{background-position:-12px -18px;}
            .search-focus .search-keyword{border-color:#538CF5;color:#333;}
            .search .adv-search{margin:0;position:absolute;right:-34px;top:5px;display:inline-block;width:24px;line-height:1.2em;}
            .search-hotwords{float:left;width:100%;height:18px;margin-top:5px;overflow:hidden;_float:none;}
            .search-hotwords, .search-hotwords a{font-size:12px;color:#999;text-decoration:none;}
            .search-hotwords a{margin-right:12px;white-space:nowrap;color:#999;}
            .search-hotwords a:hover{color:#F60;}
        </style>
        <div class="box-body">
            <img class="logo" src="http://image.suning.cn/public/v3/images/logo/snlogo.png" width="152px" height="80px" alt="苏宁易购">
            <div class="union-o-search clearfix" style="width: 482px;">
                <form method="get">
                    <input tabindex="0" type="text" id="searchKeyword" class="search-keyword" value="零食" autocomplete="off" style="width: 360px;">
                    <input type="button" class="search-btn" onclick="suningSearch()" value="搜索">
                    <div id="keywords" class="search-hotwords" style="width: 482px;">
                        <a href="https://sucs.suning.com/visitor.htm?userId=16017695&amp;webSiteId=503699&amp;adInfoId=0&amp;adBookId=101917&amp;channel=16&amp;vistURL=http://search.suning.com/%E8%8B%B9%E6%9E%9C/cityId=9173" name="YT_RSC_112_1">苹果</a>
                        <a href="https://sucs.suning.com/visitor.htm?userId=16017695&amp;webSiteId=503699&amp;adInfoId=0&amp;adBookId=101917&amp;channel=16&amp;vistURL=http://search.suning.com/iPhone/cityId=9173" name="YT_RSC_112_1">iPhone</a>
                        <a href="https://sucs.suning.com/visitor.htm?userId=16017695&amp;webSiteId=503699&amp;adInfoId=0&amp;adBookId=101917&amp;channel=16&amp;vistURL=http://search.suning.com/%E6%B5%B7%E5%B0%94/cityId=9173" name="YT_RSC_112_1">海尔</a>
                        <a href="https://sucs.suning.com/visitor.htm?userId=16017695&amp;webSiteId=503699&amp;adInfoId=0&amp;adBookId=101917&amp;channel=16&amp;vistURL=http://search.suning.com/%E7%BE%8E%E7%9A%84/cityId=9173" name="YT_RSC_112_1">美的</a>
                        <a href="https://sucs.suning.com/visitor.htm?userId=16017695&amp;webSiteId=503699&amp;adInfoId=0&amp;adBookId=101917&amp;channel=16&amp;vistURL=http://search.suning.com/%E5%B0%8F%E7%B1%B3/cityId=9173" name="YT_RSC_112_1">小米</a>
                        <a href="https://sucs.suning.com/visitor.htm?userId=16017695&amp;webSiteId=503699&amp;adInfoId=0&amp;adBookId=101917&amp;channel=16&amp;vistURL=http://search.suning.com/%E9%AD%85%E6%97%8F/cityId=9173" name="YT_RSC_112_1">魅族</a>
                        <a href="https://sucs.suning.com/visitor.htm?userId=16017695&amp;webSiteId=503699&amp;adInfoId=0&amp;adBookId=101917&amp;channel=16&amp;vistURL=http://search.suning.com/%E5%8D%8E%E4%B8%BA/cityId=9173" name="YT_RSC_112_1">华为</a>
                        <a href="https://sucs.suning.com/visitor.htm?userId=16017695&amp;webSiteId=503699&amp;adInfoId=0&amp;adBookId=101917&amp;channel=16&amp;vistURL=http://search.suning.com/%E4%B8%89%E6%98%9F/cityId=9173" name="YT_RSC_112_1">三星</a>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
            function suningSearch(){
                var key = document.getElementById("searchKeyword").value;
                key = encodeURI(key);
                location.href ='https://sucs.suning.com/visitor.htm?userId=16017695&webSiteId=503699&adInfoId=0&adBookId=101917&channel=16&vistURL=http://search.suning.com/'+key+'/cityId=9173';
            }
        </script>
    </div>
    <div id="tmall">

    </div>
@endsection
