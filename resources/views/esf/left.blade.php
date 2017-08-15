<div class="village_name">
  <dl>
    <dt>
      <span class="house_name color_blue">@if(!empty($viewShowInfo['commName'])) {{$viewShowInfo['commName']}} @endif</span>
        <span class="subway bq">@if(!empty($viewShowInfo['type2Name'])) {{$viewShowInfo['type2Name']}} @endif</span>
    </dt>
    <dd class="buy_price">
      <p>
        <span class="color2d">本月租金均价：</span>
        <span><span class="colorfe font_size1">@if(!empty($viewShowInfo['statusRentPrice'])) {{$viewShowInfo['statusRentPrice']}} 元/月@else 暂无资料 @endif</span>，</span>
          <span>
              <span>环比上月</span>
            @if($viewShowInfo['statusRentIncre'] > 0 )
              <span class="colorfe">↑{{$viewShowInfo['statusRentIncre']}}% </span>，
            @elseif($viewShowInfo['statusRentIncre'] === 0)
              <span class="colorfe">{{$viewShowInfo['statusRentIncre']}}% </span>，
            @elseif($viewShowInfo['statusRentIncre'] < 0)
              <span class="color096">↓{{$viewShowInfo['statusRentIncre']}}% </span>，
            @else
              <span class="colorfe">暂无资料</span>，
            @endif
          </span>
          <span>
              <span>同比去年</span>
            @if($viewShowInfo['statusRentIncreLastYears'] > 0 )
              <span class="colorfe">↑{{$viewShowInfo['statusRentIncreLastYears']}}% </span>，
            @elseif($viewShowInfo['statusRentIncreLastYears'] === 0)
              <span class="colorfe">{{$viewShowInfo['statusRentIncreLastYears']}}% </span>，
            @elseif($viewShowInfo['statusRentIncreLastYears'] < 0)
              <span class="color096">↓{{$viewShowInfo['statusRentIncreLastYears']}}% </span>，
            @else
              <span class="colorfe">暂无资料</span>，
            @endif
          </span>
      </p>
      <p>
        <span class="color2d">本月出售均价：</span>
        <span><span class="colorfe font_size1">@if(!empty($viewShowInfo['statusSalePrice'])) {{$viewShowInfo['statusSalePrice']}} 元/平米@else 暂无资料  @endif</span>，</span>
          <span>
              <span>环比上月</span>
            @if($viewShowInfo['statusSaleIncre'] > 0 )
              <span class="colorfe">↑{{$viewShowInfo['statusSaleIncre']}}% </span>，
            @elseif($viewShowInfo['statusSaleIncre'] === 0)
              <span class="colorfe">{{$viewShowInfo['statusSaleIncre']}}% </span>，
            @elseif($viewShowInfo['statusSaleIncre'] < 0)
              <span class="color096">↓{{$viewShowInfo['statusSaleIncre']}}% </span>，
            @else
              <span class="colorfe">暂无资料</span>，
            @endif
          </span>
          <span>
              <span>同比去年</span>
            @if($viewShowInfo['statusSaleIncreLastYears'] > 0 )
              <span class="colorfe">↑{{$viewShowInfo['statusSaleIncreLastYears']}}% </span>，
            @elseif($viewShowInfo['statusSaleIncreLastYears'] === 0)
              <span class="colorfe">{{$viewShowInfo['statusSaleIncreLastYears']}}% </span>，
            @elseif($viewShowInfo['statusSaleIncreLastYears'] < 0)
              <span class="color096">↓{{$viewShowInfo['statusSaleIncreLastYears']}}% </span>，
            @else
              <span class="colorfe">暂无资料</span>，
            @endif
          </span>
      </p>
      </dd>
    </dl>
    <p class="color2d msg">
      @if(substr($type2, 0,1) == 3)
        二手房
      @else
        出售
      @endif
      <a class="color_blue" href="/{{$viewShowInfo['saleUrl']}}/area/an{{$type2}}-ba{{$communityId}}" target="_blank">
        {{(!empty($houseSaleData->total)) ? $houseSaleData->total : 0 }}
      </a>
      套&nbsp;&nbsp;
        @if(substr($type2, 0,1) == 3)
          租房
        @else
          出租
        @endif
      <a class="color_blue" href="/{{$viewShowInfo['rentUrl']}}/area/an{{$type2}}-ba{{$communityId}}" target="_blank">
        {{(!empty($houseRentData->total)) ? $houseRentData->total : 0 }}
      </a>
      套&nbsp;&nbsp;
    </p>
    <span class="online"><img src="/image/esfBuild.jpg" alt="买房，租房，上搜房！"><a href="/new/area"><span class="newHouse"></span></a></span>
  </div>
  <div class="build">
    @include('esf.esfTypeNav')
  </div>