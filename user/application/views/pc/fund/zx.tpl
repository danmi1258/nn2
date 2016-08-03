	
			<!--start中间内容-->	
			<div class="user_c">
				<div class="user_zhxi">
				<form action="" method="get">
					<div class="zhxi_tit">
						<p><a>资金管理</a>><a>中信银行签约账户管理</a></p>
					</div>
					<div>
						<div class="zj_gl">
							<div class="zj_l">
								<a href="{url:/Fund/zxpage}" class="zj_a cz">{if:isset($balance['SJAMT'])}账户信息{else:}开通{/if}</a>
								{if:isset($balance['SJAMT'])}<a href="{url:/Fund/tx}" class="zj_a tx">提现</a>
								<p class="re_t">结算账号资金总额</p>
								<h1 class="rental">￥{echo:$balance['SJAMT']}</h1>
								{/if}
								<p class="state"></p>
							</div>
							<div class="zj_r">
								<div class="zj_price"></div>
								<div class="zj_column">
									<span class="column_yes" style="width:{echo:$balance['DJAMT']/($balance['SJAMT'])*300}px;" title="{$balance['DJAMT']}"></span>
									<span class="column_no" style="width:{echo:$balance['KYAMT']/($balance['SJAMT'])*300}px;" title="{$balance['KYAMT']}"></span>
									<div class="clear"></div>
								</div>
								<div class="price">
									<span class="price_l">
										<i class="pr_l"></i>
										<span>可用资金</span>
									</span>
									<span class="price_r">
										<i class="pr_r"></i>
										<span>冻结资金</span>
									</span>
								</div>
							</div>
							<div style="clear:both;"></div>
						</div>
						
					</div>
                    <div class="zj_mx">
                    	<div class="mx_l">结算账户资金明细</div>
						<form action="{url:/Fund/index}" method="GET" name="">
                        <div class="mx_r">
							 交易时间：<input class="Wdate" name="begin" type="text" value="{$cond['begin']}" onClick="WdatePicker()">
							<span class="js_span1">-</span>
							<input class="Wdate" type="text" name="end" value="{$cond['end']}" onClick="WdatePicker()">
							<span class="js_span2">交易号：</span><input type="text" value="{$cond['no']}" name="Sn">
							<select name="day" >
								<option value="7" {if:$cond['day']==7}selected{/if}>一周内</option>
								<option value="30" {if:$cond['day']==30}selected{/if}>一个月内</option>
								<option value="365" {if:$cond['day']==365}selected{/if}>一年内</option>
							</select>
							<button type="submit">搜索</button> 					
						</div>
							</form>
                    </div>
					<div class="jy_xq">
                    <table cellpadding="0" cellspacing="0">
				        <tr>
				            <th>柜员交易号</th>
				            <th>交易时间</th>
				            <th>交易类别</th>
				            <th>交易金额</th>
							<th>账户余额</th>
				            <th>对方账号</th>
				            <th>对方账户名</th>
				        </tr>
						{foreach:items=$flow }
						<tr>

							<td>{$item['HOSTFLW']}</td>
							<td>{$item['TRANDATE']}{$item['TRANTIME']}</td>
							<td>{$item['TRANTYPE_TEXT']}</td>
							<td>{$item['TRANAMT']}</td>
							<td>{$item['ACCBAL']}</td>
							<td>{$item['OPPACCNO']}</td>
							<td>{$item['OPPACCNAME']}</td>

						</tr>
						{/foreach}
                    </table>
					</div>
				</form>
				</div>
			</div>
			
	<!--end中间内容-->		