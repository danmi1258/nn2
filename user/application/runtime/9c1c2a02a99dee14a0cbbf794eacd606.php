<!DOCTYPE html>
<html>
<head>
  <title>个人中心</title>
  <meta name="keywords"/>
  <meta name="description"/>
  <meta charset="utf-8">
  <link href="http://localhost/nn2/user/public/views/pc/css/user_index.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="http://localhost/nn2/user/public/js/jquery/jquery-1.7.2.min.js"></script>



  <script language="javascript" type="text/javascript" src="http://localhost/nn2/user/public/views/pc/js/My97DatePicker/WdatePicker.js"></script>
  <script type="text/javascript" src="http://localhost/nn2/user/public/views/pc/js/regular.js"></script>
   <script src="http://localhost/nn2/user/public/views/pc/js/center.js" type="text/javascript"></script>
  <link href="http://localhost/nn2/user/public/views/pc/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
   <!-- 头部控制 -->
  <link href="http://localhost/nn2/user/public/views/pc/css/topnav20141027.css" rel="stylesheet" type="text/css">
  <script src="http://localhost/nn2/user/public/views/pc/js/topnav20141027.js" type="text/javascript"></script>
    <!-- 头部控制 -->

    <script type="text/javascript" src="http://localhost/nn2/user/public/js/form/validform.js" ></script>
    <script type="text/javascript" src="http://localhost/nn2/user/public/js/form/formacc.js" ></script>
    <script type="text/javascript" src="http://localhost/nn2/user/public/js/layer/layer.js"></script>
</head>
<body>
<!--    公用头部控件 -->
    <div class="bg_topnav">
    <div class="topnav_width">
        <div class="topnav_left">
            <div class="login_link" id="toploginbox">
                <?php if($login==0){?>
                <a rel="external nofollow" href="http://localhost/nn2/user/public/index/login" target="_blank" class="topnav_login">登录</a>
                <div class="login_box" id="login_boxMain" style="display: none;">
                    <input name="gtxh_LoginMobile" type="text" id="gtxh_LoginMobile" class="txt_topnav" value="手机号码" maxlength="11">
                    <br>
                    <input type="text" id="gtxh_importpwd" class="txt_topnav" value="登录密码" maxlength="11">
                    <input name="gtxh_LoginPwd" type="password" id="gtxh_LoginPwd" maxlength="20" style=" display:none;">
                    <br>
                    <input type="button" value="登录" id="gtxh_btnLogin" class="btn_topnav_login" onclick="javascript:_utaq.push(['trackEvent','btn-log']);">
                    &nbsp;
                    <input name="gtxh_autoLogin" type="checkbox" id="gtxh_autoLogin" style="vertical-align: middle" checked="checked">
                    <label for="checkbox">两周内自动登录</label>
                    <br>
                    <a href="PasswordReset.html" target="_blank">忘记密码</a> <a href="http://localhost/nn2/user/public/index/register" target="_blank">立即注册</a>
                </div>
                <div class="topnav_regsiter" style=" float:right;">
                    <a rel="external nofollow" href="register.html" target="_blank">免费注册</a>
                </div>
                <?php }else{?>
                    您好，<?php echo isset($username)?$username:"";?>
                    <a rel="external nofollow" href="http://localhost/nn2/user/public/index/logout" >退出</a>
                <?php }?>
            </div>
            <div class="topnav_login_in" id="userCenterbox" style="display: none;">
                您好，<label class="icon_topnav_loginin" id="gtxh_uame"></label>
                <a id="userCenter" href="centre/user_index.html" target="_blank">会员中心</a>
                <a id="loginOut" href="javascript:">退出</a>
                <iframe id="iframe_loginOut" frameborder="0" height="1" width="1" scrolling="no"></iframe>
            </div>
        </div>
        <div class="topnav_right">
            <ul>
                <li>
                    <div class="top_app" id="topPhone">
                        <a href="javascript:;"><em class="icons iphone"></em><span>手机APP</span></a>
                        <a rel="external nofollow" href="http://app.nainaiwang.com/" class="top_a" target="_blank" style="display:none !important;visibility: hidden"><!--<em class="icons zz"></em>--><i style="font-size:14px;">▪</i><span>掌中耐耐APP</span></a>
                    </div>
                </li>
                <li>
                    <div class="popueButton">
                        <a href="javascript:window.external.AddFavorite('http://www.nainaiwang.com', '耐耐网——大宗商品交易中心')">加入收藏</a>
                    </div>
                </li>
                <li>
                    <div class="popueButton">
                        <div id="popue_quick">
                            网站导航<b> </b></div>
                    </div>
                    <div class="popuePanel" id="quickPanel" style="display: none;">
                        <div class="quick_market">
                            <b>产品分类</b><br>
                            <span>耐火市场 </span>&nbsp; 
                            <a href="http://market.nainaiwang.com/#sortId=2394&amp;nsortId=2411" target="_blank">低合金板</a>
                            <a href="http://market.nainaiwang.com/#sortId=2394&amp;nsortId=2414" target="_blank">容器板</a>
                            <a href="http://market.nainaiwang.com/#sortId=2394&amp;nsortId=2406" target="_blank">热轧开平板</a>
                            <a href="http://market.nainaiwang.com/#sortId=2394&amp;nsortId=2410" target="_blank">中厚板</a><br>
                            <span>建材市场 </span>&nbsp; 
                            <a href="http://market.nainaiwang.com/#sortId=2403&amp;nsortId=2405" target="_blank">热轧卷板</a>
                            <a href="http://market.nainaiwang.com/#sortId=2403&amp;nsortId=2592" target="_blank">镀锌带钢</a>
                            <a href="http://market.nainaiwang.com/#sortId=2403&amp;nsortId=2415" target="_blank">冷轧卷板</a>
                            <a href="http://market.nainaiwang.com/#sortId=2403&amp;nsortId=2603" target="_blank">低合金卷</a><br>
                            <span>钢铁市场 </span>&nbsp; 
                            <a href="http://market.nainaiwang.com/#sortId=2395&amp;nsortId=2475" target="_blank">等边角钢</a>
                            <a href="http://market.nainaiwang.com/#sortId=2395&amp;nsortId=2423" target="_blank">H型钢</a>
                            <a href="http://market.nainaiwang.com/#sortId=2395&amp;nsortId=2421" target="_blank">槽钢</a>
                            <a href="http://market.nainaiwang.com/#sortId=2395&amp;nsortId=2422" target="_blank">工字钢</a><br>
                            <span>冶金化工 </span>&nbsp; 
                            <a href="http://market.nainaiwang.com/#sortId=2397&amp;nsortId=2434" target="_blank">无缝管</a>
                            <a href="http://market.nainaiwang.com/#sortId=2397&amp;nsortId=2435" target="_blank">方管</a>
                            <a href="http://market.nainaiwang.com/#sortId=2397&amp;nsortId=2433" target="_blank">镀锌管</a>
                            <a href="http://market.nainaiwang.com/#sortId=2397&amp;nsortId=2432" target="_blank">焊管</a><br>
                            <span>其他市场 </span>&nbsp; 
                            <a href="http://market.nainaiwang.com/#sortId=2396&amp;nsortId=2427" target="_blank">螺纹钢</a>
                            <a href="http://market.nainaiwang.com/#sortId=2396&amp;nsortId=2429" target="_blank">圆钢</a>
                            <a href="http://market.nainaiwang.com/#sortId=2396&amp;nsortId=2430" target="_blank">高线</a>
                            <a href="http://market.nainaiwang.com/#sortId=2396&amp;nsortId=2522" target="_blank">盘螺</a><br>
                            <span>核心企业 </span>&nbsp; 
                            <a href="http://market.nainaiwang.com/#sortId=2398&amp;nsortId=2440" target="_blank">合结圆</a>
                            <a href="http://market.nainaiwang.com/#sortId=2398&amp;nsortId=2439" target="_blank">碳结圆</a>
                            <a href="http://market.nainaiwang.com/#sortId=2398&amp;nsortId=2631" target="_blank">合金钢</a>
                            <a href="http://market.nainaiwang.com/#sortId=2398&amp;nsortId=2458" target="_blank">轴承钢</a><br>
                            <span>仓储专区 </span>&nbsp; 
                            <a href="http://market.nainaiwang.com/#sortId=2398&amp;nsortId=2440" target="_blank">合结圆</a>
                            <a href="http://market.nainaiwang.com/#sortId=2398&amp;nsortId=2439" target="_blank">碳结圆</a>
                            <a href="http://market.nainaiwang.com/#sortId=2398&amp;nsortId=2631" target="_blank">合金钢</a>
                            <a href="http://market.nainaiwang.com/#sortId=2398&amp;nsortId=2458" target="_blank">轴承钢</a>
                        </div>
                        <div class="quick_info">
                            <div class="quick_city">
                                <b>地区分站</b><br>
                                <a href="http://news.nainaiwang.com/xianhuojiage.html#areaName=%E4%B8%8A%E6%B5%B7" target="_blank">上海</a>
                                <a href="http://news.nainaiwang.com/xianhuojiage.html#areaName=%E6%9D%AD%E5%B7%9E" target="_blank">杭州</a>
                                <a href="http://news.nainaiwang.com/xianhuojiage.html#areaName=%E6%97%A0%E9%94%A1" target="_blank">无锡</a>
                                <a href="http://news.nainaiwang.com/xianhuojiage.html#areaName=%E9%83%91%E5%B7%9E" target="_blank">郑州</a>
                                <a href="http://news.nainaiwang.com/xianhuojiage.html#areaName=%E6%AD%A6%E6%B1%89" target="_blank">武汉</a>
                                <a href="http://news.nainaiwang.com/xianhuojiage.html#areaName=%E9%95%BF%E6%B2%99" target="_blank">长沙</a><br>
                                <a href="http://news.nainaiwang.com/xianhuojiage.html#areaName=%E5%B9%BF%E5%B7%9E" target="_blank">广州</a>
                                <a href="http://news.nainaiwang.com/xianhuojiage.html#areaName=%E5%94%90%E5%B1%B1" target="_blank">唐山</a>
                                <a href="http://news.nainaiwang.com/xianhuojiage.html#areaName=%E6%88%90%E9%83%BD" target="_blank">成都</a>
                                <a href="http://news.nainaiwang.com/xianhuojiage.html#areaName=%E9%82%AF%E9%83%B8" target="_blank">邯郸</a>
                                <a href="http://news.nainaiwang.com/xianhuojiage.html#areaName=%E9%87%8D%E5%BA%86" target="_blank">重庆</a>
                                <a href="http://news.nainaiwang.com/xianhuojiage.html#areaName=%E5%A4%A9%E6%B4%A5" target="_blank">天津</a>
                            </div>
                            <b>信息行情</b><br>
                            <a href="http://news.nainaiwang.com/xianhuojiage.html" target="_blank">现货价格</a>
                            <a href="http://news.nainaiwang.com/gangweizixun.html" target="_blank">钢为资讯</a>
                            <a href="http://news.nainaiwang.com/hangyefenxi.html" target="_blank">行业分析</a><br>
                            <a href="http://news.nainaiwang.com/jiageyuce.html" target="_blank">价格预测</a>
                            <a href="http://news.nainaiwang.com/gangchangtiaojia.html" target="_blank">钢厂调价</a>
                            <a href="http://news.nainaiwang.com/yuancailiao.html" target="_blank">原材料</a>
                            <div class="quick_info_bottom">
                                <span><a href="http://market.nainaiwang.com/brand.html" target="_blank">品牌店</a></span>
                                <span><a href="http://bbs.nainaiwang.com/" target="_blank">耐耐朋友圈</a></span>
                                <span class="red"> <a href="http://app.nainaiwang.com/" target="_blank">掌中耐耐APP</a></span>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<!-- 公用头部控件 -->
<div class="header">
		<div class="nav">
            <div class="logo-box zn-l">
                <a href="../index.html" alt="返回耐耐首页"><img src="http://localhost/nn2/user/public/views/pc/images/icon/nainaiwang.png"/></a></dd>
            </div>
			<div class="nav-tit">
                <ul class="nav-list">
                    <?php foreach($topArray as $key => $topList){?>
                        <li>
                            <a href="<?php echo isset($topList['url'])?$topList['url']:"";?>" <?php if( $topList['isSelect']){?> class="cur" <?php }?>><?php echo isset($topList['title'])?$topList['title']:"";?></a>
                        </li>
                    <?php }?>

                </ul>
			</div>
		</div>
	</div>
	<div class="user_body">
		<div class="user_b">
			<!--start左侧导航--> 
            <div class="user_l">
                <?php if(!empty($leftArray)){?>
                <div class="left_navigation">
                    <ul>

                    	<?php foreach($leftArray as $k => $leftList){?>

                    		<?php if( $k == 0){?>
                    		<li class="let_nav_tit"><h3><?php echo isset($leftList['name'])?$leftList['name']:"";?></h3></li>
                    		<?php }else{?>
                            <li class="btn1" id="btn<?php echo isset($k)?$k:"";?>">
                                <a class="nav-first <?php if(isset($leftList['action']) && in_array($action,$leftList['action'])){?>cur<?php }?>" <?php if(isset($leftList['url'])){?> href="<?php echo isset($leftList['url'])?$leftList['url']:"";?>"<?php }?> >
                                    <?php echo isset($leftList['name'])?$leftList['name']:"";?>
                                    <i class="icon-caret-down"></i>
                                </a>
                                <?php if( !empty($leftList['list'])){?>
                                    <ul class="zj_zh" >
                                        <?php foreach($leftList['list'] as $key => $list){?>
                                            <li><a  href="<?php echo isset($list['url'])?$list['url']:"";?>" <?php if(in_array($action,$list['action'])){?>class="cur"<?php }?> ><?php echo isset($list['title'])?$list['title']:"";?></a></li>
                                        <?php }?>
                                    </ul>
                                <?php }?>
                            </li>

                    		<?php }?>



                    	<?php }?>
                        
                      
                    </ul>
                </div>
                <?php }else{?>
                    <div class="wrap_con">
                        <div class="personal_data">
                            <div class="head_portrait">
                                <a href="#">
                                    <img src="http://localhost/nn2/user/public/views/pc/images/icon/head_portrait.jpg">
                                </a>
                            </div>
                            <div class="per_username">
                                <p class="username_p"><b>上午好，<?php echo isset($username)?$username:"";?></b></p>
                                <p class="username_p"><img src="<?php echo isset($group['icon'])?$group['icon']:"";?>"><?php echo isset($group['group_name'])?$group['group_name']:"";?></p>
                                <p class="username_p">消息提醒：<b class="colaa0707">24</b></p>
                                <p class="username_p"><a class="padding_right" href="">去认证</a><a class="col1734b1" href="">仓储管理</a></p>
                            </div>
                            <div class="per_function">
                                <a href="user_zh.html">基本信息设置</a>
                                <a href="zh_mm.html">修改密码</a>
                            </div>
                            <div class="per_collection">
                                <p class="collection_padding col1734b1">信誉保证金有什么好处</p>
                                <p class="collection_padding colaa0707">已缴纳信誉保证金</p>
                            </div>
                        </div>
                    </div>
                <?php }?>
            </div>
            <!--end左侧导航-->
            <div id="cont">
                		<form method="post" action="http://localhost/nn2/user/public/delivery/genedelivery">
			<!--start中间内容-->	
			<div class="user_c_list">
				<div class="user_zhxi">
					<div class="zhxi_tit">
						<p><a>交易管理</a>><a>合同详情</a></p>
					</div>
					<div class="chp_xx">
						
						<div class="xx_center">
							<table border="0" cellpadding="" cellspacing="">
								<tbody>
								<tr class="title">
									<td align="left" colspan="7">&nbsp;商品清单</td>
								</tr>
								<tr class="title_head">
									<th>图片</th>
									<th>商品名称</th>
									<th>商品数量</th>
									<th>可提数量</th>
									<th>提货数量</th>
									<th>仓库</th>
								</tr>
								<tr>
									<td><img src="../images/banner/551b861eNe1c401dc.jpg"/></td>
									<td><?php echo isset($data['name'])?$data['name']:"";?></td>
									<td><?php echo isset($data['num'])?$data['num']:"";?><?php echo isset($data['unit'])?$data['unit']:"";?></td>
									<td><?php echo isset($data['left'])?$data['left']:"";?><?php echo isset($data['unit'])?$data['unit']:"";?></td>
									<!-- 判断系统参数是否支持多次开单 如果单次开单则不能修改开单数量-->
									<td>
										<input type="text" class="thjs_input" name='num'>

									</td>
									<td><?php echo isset($data['store_name'])?$data['store_name']:"";?></td>

								</tr>
							</tbody></table>
						</div>
						<ul class="methed">
							<li class="clearfix">
				                        		<label>预计提货日期：</label>
					                        <div>
					                        
					                        
					                        <input name="expect_time" id="date_start" type="text" class="Wdate gyctht_input" value="2016-04-01">
						                        	
						                        	记重方式：过磅  
						                             <input type="hidden" id="weight_type" value="A">
						                        	
						                        	
					                        
					                        </div>
				                        	</li>
				                        	<li class="clearfix">
				                        		<label>提货人：</label>
				                        		<div>
				                        			<p>
				                        				<b> ● </b>
				                        				提货人：<span id="man"><input type="text" name="delivery_man"></span>
				                        			</p>
				                        			<p>
				                        				<b> ● </b>
				                        				联系电话：<span id="tel"><input type="text" name="phone"></span>
				                        			</p>
				                        			<p>
				                        				<b> ● </b>
				                        				身份证号码：<span id="code"><input type="text" name="idcard"/></span>
				                        			</p>
				                        			<p>
				                        				<b> ● </b>
				                        				车牌号：<input type="text" name="plate_number" placeholder="多个以逗号分隔"/>
				                        			</p>
				                        		</div>
				                        	</li>
				                        	<li class="clearfix">
				                        		<label>备注：</label>
				                        		<div>
								         <textarea name="remark" cols="" rows="" id="REMARK" class="bz" maxlength="200">gaegag</textarea>最多输入200个字符
								     
								</div>
				                        	</li>

						</ul>
						<div class="zhxi_con">	
							<input type="hidden" name="order_id" value="<?php echo isset($data['id'])?$data['id']:"";?>" />
							<span><input class="submit_zz" type="submit" value="提交"></span>
							<span><input class="submit_zz reset_zz" type="reset" value="返回"></span>
						</div>
						<!-- <div class="sjxx">
							<p>支付配送</p>
							<div class="sj_detal">
								<b class="sj_de_tit">收货人：</b>
								<span>&nbsp;laijjj</span>
							</div>
							<div class="sj_detal">
								<b class="sj_de_tit">地址：</b>
								<span>&nbsp;山西省晋中市xxx县</span>
							</div>
							<div class="sj_detal">
								<b class="sj_de_tit">邮编：</b>
								<span>&nbsp;045000</span>
							</div>
						</div> -->
					</div>
				</div>
			</div>
			<!--end中间内容-->	
			</form>
			<script type="text/javascript">
				$(function(){

				});

			</script>


		<!-- 弹出层 -->
	<!-- 	<div id="bgblock" style="width: 100%; height: 100%; position: fixed; top: 0px; left: 0px; z-index: 999; background-color: rgb(0, 0, 0); opacity: 0.6; display:none; background-position: initial initial; background-repeat: initial initial;"></div>

		<div id="ermblock" style="position: fixed; left: 427.5px; top: 10%; width: 1000px; height: 320px; z-index: 1000; display:none;">
			<div class="ermblock_main">
				<p><h2>添加提货人</h2></p>
				<form>
					<table cellspacing="0" align="center" class="table_form">
					<tbody><tr>
						<td class="tr fb" width="35%">提货人姓名：</td>
						<td class="four-content" colspan="3"><input type="text" name="pickman_name" maxlength="12" id="pickman_name" value=""> <span style="color:red;">*</span></td>
					</tr>
					<tr>
						<td class="tr fb">联系电话：</td>
						<td class="four-content" colspan="3"><input type="text" name="mobile" id="mobile" maxlength="14" value=""> <span style="color:red;">*</span></td>
					</tr>
						<tr>
						<td class="tr fb">身份证号码：</td>
						<td class="four-content" colspan="3"><input type="text" name="IDENTITY_NUM" id="IDENTITY_NUM" maxlength="18" value=""> <span style="color:red;">*</span></td>
					</tr>
					<tr>
						<td class="tr fb">车牌号码：</td>< <input type="text" name="truck_num" id="truck_num" value="" /> 
						<td class="four-content" colspan="3"><textarea id="truck_num" name="truck_num" maxlength="500" style="width: 153px; height: 50px;"></textarea> <span style="color:red;">* 多个以逗号分隔</span></td>
					</tr>
					</tbody></table>

						<div class="zhxi_con">	
							<span><input class="submit_zz" type="submit" value="提交"></span>
							<span><input class="submit_zz reset_zz" type="reset" value="返回" id="close"></span>
						</div>
				</form>
			</div>
		</div>
		
		<script type="text/javascript">
			 $(document).ready(function(){
			  $("#clickdd").click(function(){
			   $("#ermblock").show();
			   $("#bgblock").show();
			     });
			  $(document).click(function(e){
			   var target = $(e.target);
			   if(target.closest("#clickdd").length == 0){
			    $("#ermblock").hide();
			    $("#bgblock").hide();
			   }
			      }); 
			 }); 
		</script> -->
		<!-- 弹出层 -->
            </div>

				<!--end中间内容-->	
			<!--start右侧广告-->			
			<div class="user_r">
				<div class="wrap_con">
					<div class="tit clearfix">
						<h3>公告</h3>
					</div>
					<div class="con">
						<div class="con_medal clearfix">
							<ul>
								<li><a>暂无勋章</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<!--end右侧广告-->
		</div>
	</div>
<script type="text/javascript">
    $(function() {
        $('.left_navigation ').find('.cur').parents('.btn1').find('.nav-first').trigger('click');
    })
</script>
</body>
</html>