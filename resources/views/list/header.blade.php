@section('title')
    @if(empty($detailBool)) <!-- 列表页 -->
        @if(!empty($fenlei))
            <title>【@if(!empty($viewShowInfo['communityName'])){{$viewShowInfo['communityName']}}|@endif{{$cityName}}新楼盘】-搜房网</title>
            <meta name="Keywords" content="@if(!empty($viewShowInfo['communityName'])){{$viewShowInfo['communityName']}},@endif{{$cityName}}新盘，{{$cityName}}新楼盘,搜房网，搜房" />
            <meta name="Description" content="搜房网，{{$cityName}}新房为您提供@if(!empty($viewShowInfo['communityName'])){{$viewShowInfo['communityName']}}@endif详情、@if(!empty($viewShowInfo['communityName'])){{$viewShowInfo['communityName']}}@endif相册、@if(!empty($viewShowInfo['communityName'])){{$viewShowInfo['communityName']}}@endif户型、@if(!empty($viewShowInfo['communityName'])){{$viewShowInfo['communityName']}}@endif价格，让您更全面的了解新楼盘，为您创造最佳新房购房体验！" />
        @else
            @if($type == 'esfsale')
                <title>【{{$cityName}}二手房|出售】-搜房网</title>
                <meta name="keywords" content="{{$cityName}}二手房，买房，搜房网，搜房，学区房，出售房源"/>
                <meta name="description" content="搜房网-{{$cityName}}二手房为您提供海量{{$cityName}}二手房房源及城市，区域，商圈，楼盘出售价格信息，还为您提供房源对比，明确您的需求，给您更好的体验！"/>
            @elseif($type == 'esfrent')
                <title>【{{$cityName}}租房|出租】-搜房网</title>
                <meta name="keywords" content="{{$cityName}}租房，出租房源，搜房网，搜房"/>
                <meta name="description" content="搜房网-{{$cityName}}租房为您提供更多租房信息及个人租房信息，为您提供城市、区域、商圈与楼盘租房价格信息，让您更快了解{{$cityName}}租房信息，更快租到满意房！"/>
            @elseif($type == 'sprent')
                <title>【{{$cityName}}商铺，{{$cityName}}门面出租】-搜房网</title>
                <meta name="keywords" content="{{$cityName}}商铺房源，{{$cityName}}商铺出租"/>
                <meta name="description" content="搜房网-{{$cityName}}商铺出租，海量商铺房，门面房源为您提供，实施房源对比，为您更快找到房源提供帮助！"/>
            @elseif($type == 'spsale')
                <title>【{{$cityName}}商铺，{{$cityName}}门面出售】-搜房网</title>
                <meta name="keywords" content="{{$cityName}}商铺房源，{{$cityName}}商铺出售"/>
                <meta name="description" content="搜房网-{{$cityName}}商铺出售，丰富房源供您浏览，供您选，随时对比，随时了解新信息，买商铺房上搜房！"/>
            @elseif($type == 'xzlrent')
                <title>【{{$cityName}}办公楼，{{$cityName}}商务楼，{{$cityName}}写字楼出租】-搜房网</title>
                <meta name="keywords" content="{{$cityName}}写字楼出租，{{$cityName}}商务楼出租，{{$cityName}}办公楼出租"/>
                <meta name="description" content="搜房网-为您提供海量写字楼，商务楼，办公楼出租房源，以楼盘为媒介，明确需求，让您更快找到满意办公地址！"/>
            @elseif($type == 'xzlsale')
                <title>【{{$cityName}}办公楼，{{$cityName}}商务楼，{{$cityName}}写字楼出售】-搜房网</title>
                <meta name="keywords" content="{{$cityName}}写字楼出售，{{$cityName}}商务楼出售，{{$cityName}}办公楼出售"/>
                <meta name="description" content="搜房网-{{$cityName}}写字楼出售，为您提供大量写字楼，商务楼，办公楼出售房源信息，帮您快速找到您心中理想的写字楼！"/>
            @elseif($type == 'bsrent')
                <title>【{{$cityName}}豪宅出租，{{$cityName}}别墅出租】-搜房网</title>
                <meta name="keywords" content="{{$cityName}}豪宅出租，{{$cityName}}别墅出租"/>
                <meta name="description" content="搜房网-北京豪宅别墅出租，为您提供大量豪宅别墅出租房源，供您浏览，供您挑选，要租房，上搜房！"/>
            @elseif($type == 'bssale')
                <title>【{{$cityName}}豪宅出售，{{$cityName}}别墅出售】-搜房网</title>
                <meta name="keywords" content="{{$cityName}}豪宅出售，{{$cityName}}别墅出售"/>
                <meta name="description" content="搜房网-{{$cityName}}豪宅别墅出售，为您提供大量豪宅别墅出租房源，供您浏览，供您挑选，要买房，上搜房！"/>
            @elseif($type == 'new')
                <title>【{{$cityName}}新房|新楼盘】-搜房网</title>
                <meta name="keywords" content="{{$cityName}}新房，{{$cityName}}新楼盘，搜房网，搜房"/>
                <meta name="description" content="搜房网-{{$cityName}}新楼盘，为您提供楼盘信息，房价信息，大量优惠新盘，为您打造更多新房体验，要买房上搜房！"/>
            @elseif($type == 'office')
                <title>【{{$cityName}}写字楼新盘，{{$cityName}}写字楼新楼盘】-搜房网</title>
                <meta name="keywords" content="{{$cityName}}写字楼新盘，{{$cityName}}写字楼新楼盘"/>
                <meta name="description" content="搜房网-{{$cityName}}写字楼新楼盘，为您提供写字楼新楼盘信息，房价信息，大量优惠新盘，为您打造更多新房体验，要买房上搜房！"/>
            @elseif($type == 'shops')
                <title>【{{$cityName}}商铺新盘，{{$cityName}}商铺新楼盘】-搜房网</title>
                <meta name="keywords" content="{{$cityName}}商铺新盘，{{$cityName}}商铺新楼盘"/>
                <meta name="description" content="搜房网-{{$cityName}}商铺新楼盘，为您提供商铺新楼盘信息，房价信息，大量优惠新盘，为您打造更多新房体验，要买房上搜房！"/>
            @elseif($type == 'rentesb')
                <title>【{{$cityName}}小区，{{$cityName}}二手楼盘】-搜房网</title>
                <meta name="keywords" content="{{$cityName}}小区，{{$cityName}}二手楼盘"/>
                <meta name="description" content="搜房网-为您提供海量小区信息，小区出租价格，小区周边配套，小区详情，小区图片，通过对比小区，更便捷的更新您的需求！"/>
            @elseif($type == 'saleesb')
                <title>【{{$cityName}}小区，{{$cityName}}二手楼盘】-搜房网</title>
                <meta name="keywords" content="{{$cityName}}小区，{{$cityName}}二手楼盘"/>
                <meta name="description" content="搜房网-为您提供海量小区信息，小区出售价格，小区周边配套，小区详情，小区图片，通过对比小区，更便捷的更新您的需求！"/>
            @elseif($type == 'villa')
                <title>【{{$cityName}}别墅新盘，{{$cityName}}豪宅新盘，{{$cityName}}别墅新楼盘，{{$cityName}}豪宅新楼盘】-搜房网</title>
                <meta name="keywords" content="{{$cityName}}别墅新盘，{{$cityName}}豪宅新盘，{{$cityName}}别墅新楼盘，{{$cityName}}豪宅新楼盘"/>
                <meta name="description" content="搜房网-{{$cityName}}别墅新楼盘，{{$cityName}}豪宅新楼盘，为您提供豪宅别墅新楼盘信息，房价信息，大量优惠新盘，为您打造更多新房体验，要买房上搜房！"/>
            @endif
            <link rel="stylesheet" type="text/css" href="/css/list.css?v={{Config::get('app.version')}}">
        @endif
    @else <!-- 内容详情页 -->
        @if($type == 'esfsale')
            <title>{{mb_substr($title,0,35)}}-搜房网</title>
            <meta name="keywords" content="{{$cityName}}二手房，@if(!empty($communityName)){{$communityName}}，@endif买房，搜房网，搜房" />
            <meta name="Description" content="{{$cityName}}二手房-搜房网提供{{$cityName}}{{$communityName}}二手房出售信息，{{$house->address}}，{{$communityName}}二手房出售，四室两厅三卫一厨。找更多{{$cityName}}{{$communityName}}二手房信息就到{{$cityName}}二手房-搜房网。" />
        @elseif($type == 'esfrent')
            <title>{{mb_substr($title,0,35)}}-搜房网</title>
            <meta name="keywords" content="{{$cityName}}租房,@if(!empty($communityName)){{$communityName}},租房,@endif搜房网，搜房" />
            <meta name="Description" content="{{$cityName}}二手房出租-搜房网提供{{$cityName}}{{$communityName}}二手房出租信息，{{$house->address}}，{{$communityName}}二手房出租，四室两厅三卫一厨。找更多{{$cityName}}{{$communityName}}二手房出租信息就到{{$cityName}}二手房出租-搜房网。" />
        @elseif($type == 'sprent')
            <title>{{$title}}</title>
            <meta name="keywords" content="{{$cityName}}商铺出租,{{$communityName}}出租" />
            <meta name="Description" content="{{$cityName}}商铺出租-搜房网提供{{$cityName}}{{$communityName}}商铺出租信息，{{$house->address}}，{{$communityName}}商铺出租。找更多{{$cityName}}{{$communityName}}商铺出租信息就到{{$cityName}}商铺出租-搜房网。" />
        @elseif($type == 'spsale')
            <title>{{$title}}</title>
            <meta name="keywords" content="{{$cityName}}商铺出售,{{$communityName}}出售" />
            <meta name="Description" content="{{$cityName}}商铺出售-搜房网提供{{$cityName}}{{$communityName}}商铺出售信息，{{$house->address}}，{{$communityName}}商铺出售。找更多{{$cityName}}{{$communityName}}商铺出售信息就到{{$cityName}}商铺出售-搜房网。" />
        @elseif($type == 'xzlrent')
            <title>{{$title}}</title>
            <meta name="keywords" content="{{$cityName}}写字楼出租,{{$communityName}}出租" />
            <meta name="Description" content="{{$cityName}}写字楼出租-搜房网提供{{$cityName}}{{$communityName}}写字楼出租信息，{{$house->address}}，{{$communityName}}写字楼出租。找更多{{$cityName}}{{$communityName}}写字楼出租信息就到{{$cityName}}写字楼出租-搜房网。" />
        @elseif($type == 'xzlsale')
            <title>{{$title}}</title>
            <meta name="keywords" content="{{$cityName}}写字楼出售,{{$communityName}}出售" />
            <meta name="Description" content="{{$cityName}}商铺出售-搜房网提供{{$cityName}}{{$communityName}}商铺出售信息，{{$house->address}}，{{$communityName}}商铺出售。找更多{{$cityName}}{{$communityName}}商铺出售信息就到{{$cityName}}商铺出售-搜房网。" />
        @elseif($type == 'bsrent')
            <title>{{$title}}</title>
            <meta name="keywords" content="{{$cityName}}别墅出租,{{$communityName}}出租" />
            <meta name="Description" content="{{$cityName}}别墅出租-搜房网提供{{$cityName}}{{$communityName}}别墅出租信息，{{$house->address}}，{{$communityName}}别墅出租。找更多{{$cityName}}{{$communityName}}别墅出租信息就到{{$cityName}}别墅出租-搜房网。" />
        @elseif($type == 'bssale')
            <title>{{$title}}</title>
            <meta name="keywords" content="{{$cityName}}别墅出售,{{$communityName}}出售" />
            <meta name="Description" content="{{$cityName}}别墅出售-搜房网提供{{$cityName}}{{$communityName}}商铺出售信息，{{$house->address}}，{{$communityName}}别墅出售。找更多{{$cityName}}{{$communityName}}别墅出售信息就到{{$cityName}}别墅出售-搜房网。" />
        @endif
    @endif
@endsection
@section('xcssjs')
    <script src="/js/housecompare.js?v={{Config::get('app.version')}}"></script>
    <script src="/js/point_interest.js?v={{Config::get('app.version')}}"></script>
    <script src="/js/list.js?v={{Config::get('app.version')}}"></script>
@endsection
@section('xsearch')
    <div class="catalog_nav no_float">
        <div class="margin_auto clearfix">
            <div class="list_sub">
                <div class="list_search">
                    <input type="text" class="txt border_blue" tp="{{!empty($type)?$type:(!empty($fenlei)?$fenlei:'new')}}" AutoComplete="off" placeholder="请输入关键字（楼盘名/地名等）" value="{{!empty($keyword)?$keyword:''}}" id="keyword">
                   <div class="mai mai1"></div>
                    <input type="button" class="btn back_color keybtn" value="搜房">
                </div>
                
            </div>
        </div>
    </div>
@endsection