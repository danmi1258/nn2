
			<!--end左侧导航-->	
			<!--start中间内容-->	
			<div class="user_c">
				<div class="user_zhxi">
					<div class="zhxi_tit">
						<p><a>提单管理</a>><a>提单详情</a></p>
					</div>
					<div class="center_tabl">
                    <div class="lx_gg">
                        <b>提货详细信息</b>
                    </div>
                    <div class="list_names">
                        <span>订单号:</span>
                        <span>{$info['order_no']}</span>
                    </div>

						<table border="0">
                            <tr>
                                <td nowrap="nowrap"><span></span>提货数量：</td>
                                <td colspan="2">
                                   {$info['num']}
                                </td>
                            </tr>
                            <tr>
              					<td nowrap="nowrap"><span></span>预计提货时间：</td>
                				<td colspan="2">
                                    {$info['expect_time']}
                                </td>
           				 	</tr>
                            <tr>
                                <td nowrap="nowrap"><span></span>提货人：</td>
                                <td colspan="2">
                                    {$info['delivery_man']}
                                </td>
                            </tr>
                            <tr>
                                <td nowrap="nowrap"><span></span>身份证号：</td>
                                <td colspan="2">
                                    {$info['idcard']}
                                </td>
                            </tr>
                             <tr>
                                <td nowrap="nowrap"><span></span>车牌号：</td>
                                <td colspan="2">
                                    {$info['plate_number']}
                                </td>
                            </tr>
                            <tr >
                                <td nowrap="nowrap"><span></span>备注：</td>
                                <td colspan="2">
                                    {$info['remark']}
                                </td>
                            </tr>
                            <tr >
                                <td nowrap="nowrap"><span></span>申请提货时间：</td>
                                <td colspan="2">
                                    {$info['create_time']}
                                </td>
                            </tr>
                               <tr >
                                <td nowrap="nowrap"><span></span>发货时间：</td>
                                <td colspan="2"> 
                                    {$info['delivery_time']}
                                </td>
                            </tr>
                            <tr >
                                <td nowrap="nowrap"><span></span>确认提货时间：</td>
                                <td colspan="2"> 
                                    {$info['confirm_time']}
                                </td>
                            </tr>
                                 
                            <tr >
                                <td nowrap="nowrap"><span></span>当前提货状态：</td>
                                <td colspan="2"> 
                                    {$info['title']}
                                </td>
                            </tr>   

              				
                      

                        <tr>
                            <td></td>
                            <td colspan="2" class="btn">


                                
                            </td>
                        </tr>
                         </table>
                         </div>
                         </div>
                         </div>

			