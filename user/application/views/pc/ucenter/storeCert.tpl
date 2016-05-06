
<script type="text/javascript" src="{root:js/area/Area.js}" ></script>
<script type="text/javascript" src="{root:js/area/AreaData_min.js}" ></script>
<script type="text/javascript" src="{root:js/ajaxfileupload.js}"></script>
<script type="text/javascript" src="{views:js/upload.js}"></script>
<script type="text/javascript" src="{views:js/cert/cert.js}"></script>
<input type="hidden" name="uploadUrl"  value="{url:/ucenter/upload}" />
			<div class="user_c">
				<div class="user_zhxi">

					<div class="zhxi_tit">
						<p><a>账号管理</a>><a>身份认证</a>><a>仓库管理员认证</a></p>
					</div>
					<div class="rz_title">
						<ul class="rz_ul">
							<li class="rz_start"></li>
							<li class="rz_li cur"><a class="rz">选择仓库</a></li>
							<li class="rz_li"><a class="yz">认证信息</a></li>
							<li class="rz_li"><a class="shjg">审核结果</a></li>
							<li class="rz_end"></li>
						</ul>

					</div>
					<form method="post" action="{url:/ucenter/doStoreCert}">
						<div class="re_xx">
								<div class="zhxi_con">
									<span class="con_tit"><i></i>选择仓库：</span>
									<span><select name="store_id" >
											<option value="0" >请选择</option>
											{foreach:items=$store}
												<option value="{$item['id']}" {if:isset($store_id) && $store_id==$item['id']}selected{/if}>{$item['name']}</option>
											{/foreach}
										</select>
									</span>


								</div>
							<div class="zhxi_con">
								<span><input class="submit" type="button" onclick="nextTab()" value="下一步"/></span>
							</div>

						</div>

					<div class="yz_img">

						<!--公司信息-->
						{if:$userType==1}
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>公司名：</span>
								<span>
									<input class="text" type="text" name="company_name" value="{$certData['company_name']}"/>
								</span>
							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>法定代表人：</span>
							<span>
								<input class="text" type="text" name="legal_person" value="{$certData['legal_person']}"/>
							</span>
							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>联系人：</span>
							<span>
								<input class="text" type="text" name="contact" value="{$certData['contact']}"/>
							</span>
							</div>

							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>联系电话：</span>
							<span>
								<input class="text" type="text" name="phone" value="{$certData['contact_phone']}"/>
							</span>
							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>地区：</span>
							<span>
								{area:data=$certData['area']}
							</span>
							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>详细地址：</span>
							<span>
								<input class="text" type="text" name="address" value="{$certData['address']}"/>
							</span>
							</div>



						{else:}
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>真实姓名：</span>
								<span>
									<input class="text" type="text" name="company_name" value="{$certData['true_name']}"/>
								</span>
							</div>


							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>手机号：</span>
							<span>
								<input class="text" type="text" value="{$certData['mobile']}"/>
							</span>
							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>地区：</span>
							<span>
								{area:data=$certData['area']}
							</span>
							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>详细地址：</span>
							<span>
								<input class="text" type="text" value="{$certData['address']}"/>
							</span>
							</div>
							<div class="zhxi_con">
								<span class="con_tit"><i>*</i>主营品种：</span>
							<span>
								<input class="text" type="text" />
							</span>
							</div>

						{/if}

						<div class="zhxi_con">
							<span><input class="submit" onclick="toCertApply()" type="button" value="提交审核"></span>
						</div>

					</div>


					</form>
					<div class="sh_jg">
						<div class="success_text">
							<p><b class="b_size">认证状态：{$certShow['status_text']}</b></p>
							<p>{$certData['message']}</p>
							{if:$certShow['button_show']===true}
							<p>您还可以进行以下操作:</p>
							<p><a class="look" href="javascript:void(0)" onclick="nextTab(1)">{$certShow['button_text']}</a>
							{/if}
						</div>
					</div>
				</form>
				</div>
			</div>
<script type="text/javascript">
	$(function(){
		nextTab({$certShow['step']});
	})
</script>