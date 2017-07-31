
<script type="text/javascript" src="{root:js/upload/ajaxfileupload.js}"></script>
<script type="text/javascript" src="{root:js/upload/docUpload.js}"></script>
<!--start中间内容-->
            <style type="text/css">

            </style>
			<div class="user_c">
				<div class="user_zhxi">
					<div class="zhxi_tit">
						<p><a>我的招标</a>><a>投标</a></p>
					</div>
                                                        <div class="project_detail">
                                                            <h1>{$detail['pro_name']}</h1>
                                                            <p>招标方：{$detail['true_name']}</p>
                                                            <p>招标方式：{$detail['mode_text']}</p>
                                                            <p>评标类型：{$detail['pack_type_text']}</p>
                                                            <p>项目地点：{$detail['pro_address']}</p>
                                                            <p>投标时间：{$detail['begin_time']}——{$detail['end_time']}</p>
                                                            <p>开标地点：[{$detail['open_way_text']}]</p>
                                                        </div>
					<div class="center_tabl">
                                                            <ul class="step_list">
                                                                <li class="bid_step">
                                                                    <span class="val_on on">1</span>
                                                                    <p class="step_name">
                                                                        <span class="on">资格预审</span>
                                                                    </p>
                                                                </li>
                                                                <li class="bid_step">
                                                                    <span class="val_on on">2</span>
                                                                    <p class="step_name">
                                                                        <span class="on">购买下载标书</span>
                                                                    </p>
                                                                </li>
                                                                <li class="bid_step">
                                                                    <span class="val_on on">3</span>
                                                                    <p class="step_name">
                                                                        <span class="on">投标</span>
                                                                    </p>
                                                                </li>
                                                                <li class="bid_step">
                                                                    <span class="val_on ">4</span>
                                                                    <p class="step_name">
                                                                        <span class="">开标</span>
                                                                    </p>
                                                                </li>
                                                                <li class="bid_step">
                                                                    <span class="val_on ">5</span>
                                                                    <p class="step_name">
                                                                        <span class="">中标结果</span>
                                                                    </p>
                                                                </li>
                                                            </ul>


                                                            <div class="invite" id="invite" style="padding-top:47px;">
                                                                <div class="invite_title">
                                                                    <span>购买标书</span>
                                                                </div>
                                                                <div class="bid_zige" style="padding-left:317px;">
                                                                    <!-- <p class="zigefile"><span>招标编号：</span>ZB20150827B002</p>
                                                                    <p class="zigefile"><span>项目名称：</span>501矿</p>
                                                                    <p class="zigefile"><span>标书费用：</span><i>100.00</i> 元</p> -->

                                                                </div>
                                                            </div>

                                                            <div class="clear"></div>

                                                            <div class="button">
                                                                <a href="{$detail['doc']}"><button>下载标书</button></a>
                                                            </div>
                                                        <form method="post" action="{url:/bid/replyGivePrice}" auto_submit="1" pay_secret="1">
                                                            <input type="hidden" name="reply_id" value="{$reply_id}" />
                                                            <div class="invite" id="invite" style="padding-top:47px;">
                                                                <div class="invite_title">
                                                                    <span>投标文件</span>
                                                                </div>
                                                                <div class="bid_zige" style="padding-left:317px;">
                                                                    <p class="zigefile"><span>招标编号：</span>{$detail['no']}</p>
                                                                    <p class="zigefile"><span>项目名称：</span>{$detail['pro_name']}</p>
                                                                    <p class="zigefile"><span>投标保证金：</span><i>{$detail['supply_bail']}</i> 元</p>
                                                                    {if:$reply['bid_doc']==''}
                                                                    <p class="zigefile">
                                                                        <span>投&nbsp;&nbsp;标&nbsp;&nbsp;书：</span>
                                                                        <input type="file" class="doc" id="1" name="doc" onchange="javascript:uploadDoc(this,'{url:/bid/ajaxUploadDoc}');" accept="application/pdf" style="height: 30px;"><i>*</i><span>只允许上传.pdf文件</span></p>
                                                                        <!-- application/msword -->
                                                                    <p class="zigefile" style="color:#e00101;"></p>
                                                                    {else:}
                                                                    <p class="zigefile">
                                                                        <span>投&nbsp;&nbsp;标&nbsp;&nbsp;书：</span>
                                                                            <a href="{$reply['bid_doc_url']}">[下载投标书]</a>
                                                                       </p>
                                                                    {/if}
                                                                     <input name="doc1" type="hidden" value="{$reply['bid_doc']}"/>

                                                                </div>
                                                            </div>

                                                            <div class="clear"></div>


                                                            <div class="invite" id="invite" style="padding-top:47px;">
                                                                <div class="invite_title">
                                                                    <span>在线报价</span>
                                                                    <!-- <b style="color:#e00101;">分包&nbsp;说明：投标人可以单个包件投标</b> -->
                                                                </div>
                                                                <div class="bid_zige">
                                                                    <table>
                                                                        <tr>
                                                                            <td>包件号</td>
                                                                            <td>货物名称</td>
                                                                            <td>品牌</td>
                                                                            <td>规格型号</td>
                                                                            <td>技术要求</td>
                                                                            <td>计量单位</td>
                                                                            <td>数量</td>
                                                                            <td>送货到场</td>
                                                                            <td>单价（元）</td>
                                                                            <td>运杂费（元）</td>
                                                                            <td>金额（元）</td>
                                                                            <td>质量标准</td>
                                                                            <td>交货期（天）</td>
                                                                            <td>总金额</td>
                                                                            <td>备注</td>
                                                                        </tr>
                                                                        {if:empty($reply['reply_package'])}
                                                                            {foreach:$items=$detail['package']}
                                                                                <tr>
                                                                                    <input type="hidden" name="pack_id[]" value="{$item['id']}"/>
                                                                                    <td>
                                                                                        {$item['pack_no']}
                                                                                        <input type="hidden" name="pack_no[]" value="{$item['pack_no']}"/>
                                                                                    </td>
                                                                                    <td>
                                                                                        {$item['product_name']}
                                                                                    </td>
                                                                                    <td><input type="text" name="brand[]"></td>
                                                                                    <td>
                                                                                        {$item['spec']}

                                                                                    </td>
                                                                                    <td>
                                                                                        {$item['tech_need']}

                                                                                    </td>
                                                                                    <td>
                                                                                        {$item['unit']}


                                                                                    </td>
                                                                                    <td>
                                                                                        {$item['num']}
                                                                                        <input class="itme_num" type="hidden" value="{$item['num']}"/>
                                                                                    </td>
                                                                                    <td>
                                                                                        <select name="deliver[]">
                                                                                            <option value="1">是</option>
                                                                                            <option value="0">否</option>
                                                                                        </select>
                                                                                    </td>
                                                                                    <td><input class="djia_price" type="text" name="unit_price[]"/></td>
                                                                                    <td><input class="freight_fee" type="text" name="freight_fee[]"/></td>
                                                                                    <!-- 金额=单价*数量 -->
                                                                                    <td><span class="amount"></span></td>
                                                                                    <td><input type="text" name="quanlity[]"></td>
                                                                                    <td><input type="text" name="tran_days[]"></td>
                                                                                    <!-- 总金额=单价*数量+运杂费 -->
                                                                                    <td><span class="total_amount"></span></td>
                                                                                    <td><input type="text" name="note[]"></td>
                                                                                </tr>

                                                                            {/foreach}
                                                                                    </table>

                                                                                </div>
                                                                            </div>

                                                                            <div class="clear"></div>

                                                                            <div class="button">
                                                                                <button>提交</button>
                                                                            </div>
                                                        </form>
                                                                        {else:}
                                                                            {foreach:$items=$reply['reply_package']}
                                                                                <tr>
                                                                                    <input type="hidden" name="pack_id[]" value="{$item['pack_id']}"/>
                                                                                    <td>{$item['pack_no']}</td>
                                                                                    <td>{$item['product_name']}</td>
                                                                                    <td>{$item['brand']}</td>
                                                                                    <td>{$item['spec']}</td>
                                                                                    <td>{$item['tech_need']}</td>
                                                                                    <td>{$item['unit']}</td>
                                                                                    <td>{$item['num']}</td>
                                                                                    <td>
                                                                                        {if:$item['deliver']}是{else:}否{/if}
                                                                                    </td>
                                                                                    <td>{$item['unit_price']}</td>
                                                                                    <td>{$item['freight_fee']}</td>
                                                                                    <td>{echo:$item['num']*$item['unit_price']}</td>
                                                                                    <td>{$item['quanlity']}</td>
                                                                                    <td>{$item['tran_days']}</td>
                                                                                    <td>{echo:$item['num']*$item['unit_price'] + $item['freight_fee']}</td>
                                                                                    <td>{$item['note']}</td>
                                                                                </tr>
                                                                            {/foreach}
                                                                                                                            </table>

                                                                                    </div>
                                                                                </div>

                                                                                <div class="clear"></div>
                                                                              </form>
                                                                                <div class="button">
                                                                                    <a href="{url:/bid/bidoper4}?reply_id={$reply_id}" ><button>下一步</button></a>
                                                                                </div>
                                                                        {/if}




                                                        </div>
				</div>
			</div>

			<!--end中间内容-->
