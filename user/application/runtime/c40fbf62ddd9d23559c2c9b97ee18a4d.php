<!DOCTYPE html>
<html>
<head>
  <title>注册</title>
  <meta name="keywords"/>
  <meta name="description"/>
  <meta charset="utf-8">
  <link href="http://localhost/nn2/user/public/views/pc/css/reg.css" rel="stylesheet" type="text/css" />
  <link href="http://localhost/nn2/user/public/views/pc/css/city.css" rel="stylesheet" type="text/css">
  <script type="text/javascript" src="http://localhost/nn2/user/public/js/jquery/jquery-1.7.2.min.js"></script>
  <script type="text/javascript" src="http://localhost/nn2/user/public/views/pc/js/reg.js"></script>
  <script type="text/javascript" src="http://localhost/nn2/user/public/js/area/Area.js" ></script>
  <script type="text/javascript" src="http://localhost/nn2/user/public/js/area/AreaData_min.js" ></script>
  <script type="text/javascript" src="http://localhost/nn2/user/public/js/autovalidate/validate.js" ></script>
  <link href="http://localhost/nn2/user/public/js/autovalidate/style.css" rel="stylesheet" type="text/css">
</head>
<body>


<div class="wrap">
<img src="http://localhost/nn2/user/public/views/pc/images/mid_banner/banner_01.png" style="position: fixed;
    width: 100%;"/>
  <!-- <div class="banner-show" id="js_ban_content">
    <div class="cell bns-01">
      <div class="con"> </div>
    </div>
  </div> -->
  <div>
    http://localhost/nn2/user/public/index.php//index/doreg
    <div class="register">
      <div class="reg_top">
      <div class="register_top">
          <div class="reg_zc register_l border_bom">个人注册</div>
          <span class="jg">|</span>
          <div class="reg_zc register_r">企业注册</div>
      </div>
      </div>
      <!--个人注册-->
      <div class="reg_cot gr_reg">
        <input name="checkUrl" value="http://localhost/nn2/user/public/index.php//index/checkisone" type="hidden"/>
        <form action="http://localhost/nn2/user/public/index.php//index/doreg" method="post">
          <input type="hidden" name="type" value="0"/>
          <div class="cot">
            <span class="cot_tit"><i>*</i>用户名：</span>
            <span><input class="text" type="text" name="username" callback="checkUser" pattern="/^[a-zA-Z0-9_]{3,30}$/" alt="请填写3-30位英文字母、数字"/></span>
          </div>
          <div class="cot">
            <span class="cot_tit"><i>*</i>密码：</span>
            <span><input class="text" type="password" name="password" pattern="/^\S{6,20}$/" alt="6-20位非空字符" bind="repassword"/></span>

          </div>
          <div class="cot">
            <span class="cot_tit"><i>*</i>确认密码：</span>
            <span><input class="text" type="password" name="repassword" pattern="/^\S{6,20}$/" alt="6-20位非空字符" bind="password" /></span>

          </div>
          <div class="cot">
            <span class="cot_tit"><i>*</i>手机号：</span>
            <span><input class="text" type="text" name="mobile" callback="checkUser" pattern="mobile" alt="请正确填写手机号"/></span>
          </div>
          <div class="cot">
            <span class="cot_tit"><i></i>邮箱：</span>
            <span><input class="text" type="text" name="email" empty pattern="email" alt="请正确填写邮箱"/></span>
          </div>

           <div class="cot">
            <span class="zc"><input class="but" type="submit"value="完成注册"/></span>
          </div>
        </form>
      </div>
       <!--个人注册结束-->
        <!--企业注册-->
      <div class="reg_cot qy_reg">
        <form action="http://localhost/nn2/user/public/index.php//index/doreg" method="post">
          <input type="hidden" name="type" value="1"/>
         <div class="cot">
            <span class="cot_tit"><i>*</i>用户名：</span>
            <span><input class="text" type="text" name="username" callback="checkUser"  pattern="/^[a-zA-Z0-9_]{3,30}$/" alt="请填写3-30位英文字母、数字" /></span>
          </div>
          <div class="cot">
            <span class="cot_tit"><i>*</i>密码：</span>
            <span><input class="text" type="password" name="password" pattern="/^\S{6,20}$/" alt="6-20位非空字符" bind="repassword" /></span>
          </div>
          <div class="cot">
            <span class="cot_tit"><i>*</i>确认密码：</span>
            <span><input class="text" type="password" name="repassword" pattern="/^\S{6,20}$/" alt="6-20位非空字符" bind="password"/></span>

          </div>
          <div class="cot">
            <span class="cot_tit"><i>*</i>手机号：</span>
            <span><input class="text" type="text" name="mobile" callback="checkUser" pattern="mobile" alt="请正确填写手机号" /></span>
          </div>
          <div class="cot">
            <span class="cot_tit"><i></i>邮箱：</span>
            <span><input class="text" type="text" name="email" empty pattern="email" alt="请正确填写邮箱" /></span>
          </div>
          <div class="cot">
            <span class="cot_tit"><i>*</i>公司名称：</span>
            <span><input class="text" type="text" name="company_name" pattern="required" alt="该字段必填"/></span>
          </div>
          <div class="cot">
            <span class="cot_tit"><i>*</i>公司地址：</span>
            <div >
                              <script type="text/javascript">
                 areaObj = new Area();

                  $(function () {
                     areaObj.initComplexArea('seachprov', 'seachcity', 'seachdistrict', '000000','area');
                  });
                </script>
			 <select  id="seachprov"  onchange=" areaObj.changeComplexProvince(this.value, 'seachcity', 'seachdistrict');">
              </select>&nbsp;&nbsp;
              <select  id="seachcity"  onchange=" areaObj.changeCity(this.value,'seachdistrict','seachdistrict');">
              </select>&nbsp;&nbsp;<span id='seachdistrict_div' >
               <select   id="seachdistrict"  onchange=" areaObj.changeDistrict(this.value);">
               </select></span>
               <input type="hidden" name="area" pattern="area" alt="请选择地区" value='000000' />


            </div>
          </div>

          <div class="cot">
            <span class="cot_tit"><i>*</i>法人：</span>
            <span><input class="text" type="text" name="legal_person" pattern="required" alt="该字段不得为空"/></span>
          </div>
          <div class="cot">
            <span class="cot_tit"><i>*</i>注册资金：</span>
            <span>
              <input class="text" type="text" name="reg_fund" pattern="float" alt="请正确填写注册资金"/>万
           </span>
          </div>
          <div class="cot">
            <span class="cot_tit"><i>*</i>企业类型：</span>
            <span> 
              <select class="select sel_d" name="category" pattern="/^[1-9]\d{0,}$/" alt="选择企业类型">
              <option value="0">请选择...</option>
              <option value="1">建筑</option>
             </select>
           </span>
          </div>
          <div class="cot">
            <span class="cot_tit"><i>*</i>企业性质：</span>
            <span> 
              <select class="select sel_d" name="nature" pattern="/^[1-9]\d{0,}$/" alt="选择企业性质">
              <option value="0">请选择...</option>
              <option value="1">国有企业</option>
               <option value="2">私企</option>
             </select>
           </span>
          </div>
          <div class="cot">
            <span class="cot_tit"><i>*</i>联系人姓名：</span>
            <span><input class="text" type="text" name="contact" pattern="required" alt="请填写联系人姓名"/></span>
          </div>
          <div class="cot">
            <span class="cot_tit"><i>*</i>电话：</span>
            <span><input class="text" type="text" name="contact_phone" pattern="mobile" alt="请填写联系人电话"/></span>
          </div>
          <div class="cot">
            <span class="cot_tit"><i>*</i>职务：</span>
            <span>
              <input name="contact_duty" type="radio" value="1" checked/>
              <span class="tit_zw">负责人</span>
              <input name="contact_duty" type="radio" value="2" />
              <span class="tit_zw">高级管理</span>
              <input name="contact_duty" type="radio" value="3" />
              <span class="tit_zw">员工 </span>
            </span>
          </div>
          <div class="cot">
            <span class="cot_tit"><i>*</i>选择代理商：</span>
            <span><input class="text" type="text" name="agent"/></span>
          </div>
          <div class="cot">
            <span class="cot_tit"><i>*</i>代理商密码：</span>
            <span><input class="text" type="text" name="agent_pass"/></span>
          </div>

           <div class="cot">
            <span class="zc"><input class="but" type="submit" value="完成注册"/></span>
          </div>
        </form>
      </div>
       <!--企业注册结束-->
    </div>
  </div>
  <div style=" clear:both"></div>
</div>
</body>
</html>
