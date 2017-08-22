@extends('mainlayout')
@section('title')
    <title>搜房隐私协议</title>
    <meta name="keywords" content="搜房网，搜房网介绍，搜房网联系方式，搜房地址，搜房招聘"/>
    <meta name="description" content="关于搜房，搜房电话，搜房招聘，搜房服务声明，搜房协议"/>
@endsection
@section('content')
<link rel="stylesheet" type="text/css" href="/css/aboutOurs.css?v={{Config::get('app.version')}}">
<div class="about">
  @include('about.publicview')
  <div class="about_r">
    <h2><span>隐私协议</span></h2>
    <p class="present words">搜房网站保护隐私权之声明</p>
    <p class="present no_index">搜房网站（http://www.sofang.com，以下称"本网站"）隐私权保护声明系本网站保护用户个人隐私的承诺。鉴于网络的特性，本网站将无可避免地与您产生直接或间接的互动关系，故特此说明本网站对用户个人信息所采取的收集、使用和保护政策，请您务必仔细阅读：</p>
    <p class="present no_index">1.使用者非个人化信息</p>
    <p class="present">我们将通过您的IP地址来收集非个人化的信息，例如您的浏览器性质、操作系统种类、给您提供接入服务的ISP的域名等，以优化在您计算机屏幕上显示的页面。通过收集上述信息，我们亦进行客流量统计，从而改进网站的管理和服务。 </p>
    <p class="present no_index">2.个人资料</p>
    <p class="present">2.1 当您在搜房网站进行用户注册登记、参加网上或公共论坛等各种活动时，在您的同意及确认下，本网站将通过注册表格等形式要求您提供一些个人资料。这些个人资料包括： </p>
    <p class="present">2.1.1 个人识别资料：如姓名、性别、年龄、出生日期、身份证号码（或护照号码）、电话、通信地址、住址、电子邮件地址、等情况。 </p>
    <p class="present">2.1.2 个人背景： 职业、教育程度、收入状况、婚姻、家庭状况。</p>
    <p class="present">2.2 请了解，在未经您同意及确认之前，本网站不会将您为参加本网站之特定活动所提供的资料利用于其它目的。惟按下列第6条规定应政府及法律要求披露时不在此限。 </p>
    <p class="present no_index">3、 信息安全</p>
    <p class="present">3.1 本网站将对您所提供的资料进行严格的管理及保护，本网站将使用相应的技术，防止您的个人资料丢失、被盗用或遭篡改。</p>
    <p class="present">3.2 本网站得在必要时委托专业技术人员代为对该类资料进行电脑处理，以符合专业分工时代的需求。如本网站将电脑处理之通知送达予您，而您未在通知规定的时间内主动明示反对，本网站将推定您已同意。惟在其后您仍然有权如下述第4.1.4条之规定，请求停止电脑处理。 </p>
    <p class="present no_index">4.用户权利 </p>
    <p class="present">4.1 您对于自己的个人资料享有以下权利：</p>
    <p class="present">4.1.1 随时查询及请求阅览</p>
    <p class="present">4.1.2 随时请求补充或更正；</p>
    <p class="present">4.1.3 随时请求删除</p>
    <p class="present">4.1.4 请求停止电脑处理及利用。</p>
    <p class="present">4.2 针对以上权利，本网站为您提供相关服务，您可以发送电子邮件至：webmaster@contact.sofang.com</p>
    <p class="present no_index">5.限制利用原则全</p>
    <p class="present">本网站惟在符合下列条件之一，方对收集之个人资料进行必要范围以外之利用： </p>
    <p class="present">5.1 已取得您的书面同意；</p>
    <p class="present">5.2 为免除您在生命、身体或财产方面之急迫危险；</p>
    <p class="present">5.3 为防止他人权益之重大危害</p>
    <p class="present">5.4 为增进公共利益，且无害于您的重大利益。</p>
    <p class="present no_index">6.个人资料之披露</p>
    <p class="present">当政府机关依照法定程序要求本网站披露个人资料时，本网站将根据执法单位之要求或为公共安全之目的提供个人资料。在此情况下之任何披露，本网站均不承担任何责任。</p>
    <p class="present no_index">7.未成年人隐私权的保护</p>
    <p class="present">7.1 本网站将建立和维持一合理的程序，以保护未成年人个人资料的保密性及安全性。本网站郑重声明：任何18岁以下的未成年人参加网上活动应事先得到家长或其法定监护人（以下统称为"监护人"）的可经查证的同意。</p>
    <p class="present">7.2 监护人应承担保护未成年人在网络环境下的隐私权的首要责任。</p>
    <p class="present">7.3 本网站收集未成年人的个人资料，仅为回覆未成人特定要求的目的，一俟回复完毕即从记录中删除，而不会保留这些资料做进一步的利用。</p>
    <p class="present">7.4 未经监护人之同意，本网站将不会使用未成年人之个人资料，亦不会向任何第三方披露或传送可识别该未成人的个人资料。本网站如收集监护人或未成年人的姓名或 其它网络通讯资料之目的仅是为获得监护人同意，则在经过一段合理时间仍未获得同意时，将主动从记录中删除此类资料。</p>
    <p class="present">7.5 若经未成人之监护人同意，本网站可对未成年人之个人资料进行收集，本网站将向监护人提供：</p>
    <p class="present">7.5.1 审视自其子女或被监护人收集之资料的机会</p>
    <p class="present">7.5.2 拒绝其子女或被监护人的个人资料被进一步的收集或利用的机会；</p>
    <p class="present">7.5.3 变更或删除其子女或被监护人个人资料的方式。</p>
    <p class="present">7.6 监护人有权拒绝本网站与其子女或被监护人做进一步的联络。</p>
    <p class="present">7.7 本网站收集未成年人的个人资料，这些资料只是单纯作为保护未成年人参与网络活动时的安全，而非作为其它目的之利用。本网站保证不会要求未成年人提供额外的个人资料，以作为允许其参与网上活动的条件。</p>
    <p class="present no_index">8.Cookies</p>
    <p class="present">8.1 Cookies是指一种技术，当使用者访问设有Cookies装置的本网站时，本网站之服务器会自动发送Cookies至阁下浏览器内，并储存到您的电脑 硬盘内，此Cookies便负责记录日后您到访本网站的种种活动、个人资料、浏览习惯、消费习惯甚至信用记录。</p>
    <p class="present">8.2 运用Cookies技术，本网站能够为您提供更加周到的个性化服务。本网站将会运用Cookies追访您的购物喜好，从而向您提供感兴趣的信息资料或储存密码，以便您造访本网站时不必每次重复输入密码。</p>
    <p class="present no_index">9.免责</p>
    <p class="present">除上述第6条规定属免责外，下列情况时本网站亦毋需承担任何责任：</p>
    <p class="present">9.1 由于您将用户密码告知他人或与他人共享注册帐户，由此导致的任何个人资料泄露。</p>
    <p class="present">9.2 任何由于黑客政击、计算机病毒侵入或发作、因政府管制而造成的暂时性关闭等影响网络正常经营之不可抗力而造成的个人资料泄露、丢失、被盗用或被篡改等。</p>
    <p class="present">9.3 由于与本网站链接的其它网站所造成之个人资料泄露及由此而导致的任何法律争议和后果。</p>
    <p class="present">本网站之保护隐私声明的修改及更新权均属于搜房网</p>
  </div>
</div>
@endsection
