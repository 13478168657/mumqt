@if(!empty($newlists))
<p class="interest_title">
  <span class="title_l">您可能感兴趣的新房</span>
  <a href="/new/area">更多新房&gt;&gt;</a>
</p>
<div class="interest">
  @foreach($newlists as $build)
    <?php
      if(!empty($build->_source->type2)){
        foreach(explode('|',$build->_source->type2) as $tp2){
          if(substr($tp2,0,1) == 3){
            $type2 = $tp2;
            break;
          }
        }
      }
      if(!empty($type2)){
        $typeInfo = 'type'.$type2.'Info';
        if(!empty($build->_source->$typeInfo)){
          $typeInfo = json_decode($build->_source->$typeInfo);
        }else{
          $typeInfo = '';
        }
      }else{
        $type2 = '301';
        $typeInfo = '';
      }
    ?>
    <dl>
      <dt>
        <a  href="/xinfindex/{{$build->_source->id}}/{{$type2}}.html"><img src="@if(!empty($build->_source->titleImage)){{get_img_url('commPhoto',$build->_source->titleImage)}}@else{{$defaultImage}}@endif"></a>
      </dt>
      <dd class="build_name"><a href="/xinfindex/{{$build->_source->id}}/{{$type2}}.html">{{$build->_source->name}}</a></dd>
      @if(!empty($build->_source->priceSaleAvg3))
        @if(isset($build->_source->priceSaleAvg3Unit) && $build->_source->priceSaleAvg3Unit == 2)
          <dd class="build_price">{{$build->_source->priceSaleAvg3}}万元/套</dd>
        @else
          <dd class="build_price">{{$build->_source->priceSaleAvg3}}元/平米</dd>
        @endif
      @else
        <dd class="build_price">待定</dd>
      @endif
      <dd class="build_tag">
        @if(!empty($typeInfo->tagIds))
          @foreach(explode('|',$typeInfo->tagIds) as $k=>$tagid)
            @if(!empty($buildtags[$tagid]))
              <span class="tag{{$tagid}}">{{$buildtags[$tagid]}}</span>
              <?php if($k >0) break;?>
            @endif
          @endforeach
        @endif
      </dd>
    </dl>
  @endforeach
</div>
@endif
<div class="web_map">
  <?php
  if(empty($sr))$sr = '';
  if($sr == 's'){
    $turl = str_replace('sale','rent',$type);
  }
  if($sr == 'r'){
    $turl = str_replace('rent','sale',$type);
  }
  if(empty($type))$type = '';
  switch ($type) {
    case 'esfsale':
      $saleText = '二手房';
      $saleText1 = '租房';
      break;
    case 'esfrent':
      $saleText = '租房';
      $saleText1 = '二手房';
      break;
    case 'spsale':
      $saleText = '商铺出售';
      $saleText1 = '商铺出租';
      break;
    case 'sprent':
      $saleText = '商铺出租';
      $saleText1 = '商铺出售';
      break;
    case 'xzlsale':
      $saleText = '写字楼出售';
      $saleText1 = '写字楼出租';
      break;
    case 'xzlrent':
      $saleText = '写字楼出租';
      $saleText1 = '写字楼出售';
      break;
    case 'bsrent':
      $saleText = '豪宅别墅出租';
      $saleText1 = '豪宅别墅出售';
      break;
    case 'bssale':
      $saleText = '豪宅别墅出售';
      $saleText1 = '豪宅别墅出租';
      break;
    default:
      //$xiaoqu = true;
      $saleText = '二手房';
      $saleText1 = '租房';
  }
  $cityObjectAll = \Illuminate\Support\Facades\Cache::store(CACHE_TYPE)->get(CITY);
  ?>
  @if(isset($xiaoqu))
      <dl>
        <dt>城市小区</dt>
        <dd class="color8d">
          @if(!empty($cityObjectAll))
            @foreach($cityObjectAll as $cv)
              @if($cv['isHot'] == 1)
                <a href="http://{{$cv['py']}}.{{config('session.domain')}}/{{$xiaoqu}}/area">{{$cv['name']}}楼盘</a>
              @endif
            @endforeach
          @endif
        </dd>
      </dl>
  @else
      <dl class="no_border">
        <dt>{{$saleText}}直达</dt>
        <dd class="dd">
          @if(!empty($cityArea))
            @foreach($cityArea as $k=>$v)
              <a onclick="webMpe('webMpe',{{$k+1}})" @if($k==0) class="up" @endif id="webMpe{{$k+1}}">{{$v->name}}</a>
            @endforeach
          @endif
        </dd>
      </dl>
      @if(!empty($businessAreaH5))
        <?php $i=0;?>
        @foreach($businessAreaH5 as $k=>$bvv)
          <dl id="con_webMpe_{{$i+1}}" @if($i++ != 0)style="display:none;"@endif >
            <dt>&nbsp;</dt>
            <dd class="color8d">
              @foreach($bvv as $bv)
                <a href="http://{{CURRENT_CITYPY}}.{{config('session.domain')}}/{{$type}}/area/aa{{$k}}-ab{{$bv->id}}">{{$bv->name}}{{$saleText}}</a>
              @endforeach
            </dd>
          </dl>
        @endforeach
      @endif
  @endif

  <dl>
    <dt>热门城市{{$saleText}}</dt>
    <dd>
      @if(!empty($cityObjectAll))
        @foreach($cityObjectAll as $cv)
          @if($cv['isHot'] == 1)
            <a href="http://{{$cv['py']}}.{{config('session.domain')}}/{{$type}}/area">{{$cv['name']}}{{$saleText}}</a>
          @endif
        @endforeach
      @endif
    </dd>
  </dl>
  <dl>
    <dt>热门城市房价</dt>
    <dd>
      @if(!empty($cityObjectAll))
        @foreach($cityObjectAll as $cv)
          @if($cv['isHot'] == 1)
            <a href="http://{{$cv['py']}}.{{config('session.domain')}}/checkpricelist/sale">{{$cv['name']}}房价</a>
          @endif
        @endforeach
      @endif
    </dd>
  </dl>
  <dl>
    <dt>热门城市{{$saleText1}}</dt>
    <dd>
      @if(!empty($cityObjectAll))
        @foreach($cityObjectAll as $cv)
          @if($cv['isHot'] == 1)
            <a href="http://{{$cv['py']}}.{{config('session.domain')}}/{{$turl}}/area">{{$cv['name']}}{{$saleText1}}</a>
          @endif
        @endforeach
      @endif
    </dd>
  </dl>
  <dl>
    <dt>热门城市新房</dt>
    <dd>
      @if(!empty($cityObjectAll))
        @foreach($cityObjectAll as $cv)
          @if(($cv['isHot'] == 1)&&(in_array($cv['py'],config('openCity'))))
            <a href="http://{{$cv['py']}}.{{config('session.domain')}}/new/area">{{$cv['name']}}新房</a>
          @endif
        @endforeach
      @endif
    </dd>
  </dl>
</div>

@if(!empty($priceMovement))
  <script type="text/javascript" src="http://cdn.hcharts.cn/highcharts/highcharts.js"></script>
  <script>
    //城市城区商圈价格趋势
    $(function(){
      var data = <?=$priceMovement?>;
      var punit = "{{$priceUnit}}";
      console.log(data[0]);
      $("#price_chart").highcharts({
        credits: enabled = false,
        xAxis: {
          tickInterval: 1,
          categories: data[0],
          labels: {
            formatter: function () {
              return this.value.toString().substr(4, 2) + "月";
            }
          }
        },
        title: {
          text: '',
          x: 0,
          //align:'left'
        },
        yAxis: {
          title: {
            text: null
          },
          plotLines: [{
            value: 0,
            width: 1,
            color: '#808080'
          }],
          lineWidth: 1,
          labels: {
            formatter: function () {
              return Highcharts.numberFormat(this.value, 0, '.', ',');
            }
          }
        },
        tooltip: {
          valueSuffix: punit
        },
        legend: {
          enabled: false,
          layout: 'horizontal',
          align: 'right',
          verticalAlign: 'top',
          borderWidth: 0
        },
        series: [{
          name: '价格',
          data: data[1]
        }]
      });
    });
  </script>
@endif

<script>
  //底部切换
  function webMpe(name, curr) {
    var num=$(".dd a").length;
    for (i = 1; i <= num; i++) {
      var menu = document.getElementById(name + i);
      var cont = document.getElementById("con_" + name + "_" + i);
      menu.className = i == curr ? "up" : "";
      if (i == curr) {
        cont.style.display = "block";
      } else {
        cont.style.display = "none";
      }
    }
  }
</script>
