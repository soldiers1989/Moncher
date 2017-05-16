<?php
class  Textso{
	/**静态目录常量*/
	public static $Tabi='<table  cellpadding="2" border="1">
										 <tr>
										  <td width="60%%" style="text-align:center; background-color:#538DD5;">三级指标</td>
										  <td width="25%%" style="text-align:center;background-color:#538DD5;">汇总指标</td>
										  <td width="15%%" style="text-align:center;background-color:#538DD5;">加权得分</td>
										 </tr>
										 <tr>
										  <td>F2、服务顾问仪表着装是否干净整洁？</td>
										  <td style="text-align:center;">着装仪表</td>
										  <td style="text-align:center;">%s</td>
										 </tr>
										 <tr>
										  <td>F4、您感觉服务顾问的态度是：</td>
										  <td style="text-align:center;"rowspan="2">服务态度 </td>
										  <td style="text-align:center;"rowspan="2">%s</td>
										 </tr>
										 <tr>
										  <td>F1、进入服务区是否有人主动接待？</td>
										 </tr>
											<tr>
										  <td>F8、服务顾问对建议维修保养项目的解释说明：</td>
										  <td style="text-align:center;"rowspan="3">经验能力</td>
										  <td style="text-align:center;"rowspan="3">%s</td>
										 </tr>
											<tr>
										  <td>F7、服务顾问给您的维修保养建议：</td>
										 </tr>
											<tr>
										  <td>F6、您提出的需求，服务顾问：</td>
										 </tr>
										  <tr>
										  <td>F9、服务顾问对您的用车、养车是否主动给出合理化建议及注意事项？</td>
										   <td style="text-align:center;" rowspan="6">操作规范</td>
										  <td style="text-align:center;" rowspan="6">%s</td>
										 </tr>
										  <tr>
										  <td>F5、服务顾问进行环车检查是否专业高效？</td>
	
										 </tr>
													<tr>
										  <td>F3、服务顾问是否能准确提出车主上次维修保养的内容并询问此次需求？</td>
	
										 </tr>
													<tr>
										  <td>F12、服务顾问是否提醒您进入休息等待区前保管好车内财物？</td>
	
										 </tr>
														<tr>
										  <td>F11、服务顾问是否完整记录接车单、维修保养作业确认书、费用结算单并让您签字确认？</td>
	
										 </tr>
														<tr>
										  <td>F10、服务顾问是否对您全程一对一服务？</td>
	
										 </tr>
	
										</table>';
	public static $Tabii='<table  cellpadding="3" border="1">
											 <tr>
											  <td width="50%%" style="text-align:center; background-color:#538DD5;">三级指标</td>
											  <td width="30%%" style="text-align:center;background-color:#538DD5;">汇总指标</td>
											  <td width="20%%" style="text-align:center;background-color:#538DD5;">加权得分</td>
											 </tr>
											 <tr>
											  <td>S1、您认为门店的位置是否便利？</td>
											  <td style="text-align:center;" rowspan="4">门店便利性</td>
											  <td style="text-align:center;" rowspan="4">%s</td>
											 </tr>
											 <tr>
											  <td>S3、您进店时停车场车位是否充足？</td>
						
											 </tr>
													<tr>
											  <td>S5、是否有专人引导停车？</td>
						
											 </tr>
												<tr>
											  <td>S6、停车位置到维修接待区是否便利</td>
						
											 </tr>
												<tr>
											  <td>S7、休息区有无服务人员主动服务？ </td>
												<td style="text-align:center;" rowspan="5">客休区服务及设施</td>
											  <td style="text-align:center;" rowspan="5">%s</td>
											 </tr>
						
												<tr>
											  <td>S8、休息区座位是否充足？</td>
						
											 </tr>
														<tr>
											  <td>S9、休息区是否舒适整洁？</td>
						
											 </tr>
														<tr>
											  <td>S10、休息区设施是否安排合理？</td>
						
											 </tr>
														<tr>
											  <td>S13、休息区是否提供休闲娱乐设施？</td>
						
											 </tr>
														<tr>
											  <td>S11、您对本店提供的饮料种类和质量是否满意？</td>
												<td style="text-align:center;" rowspan="2">餐饮品质</td>
											  <td style="text-align:center;" rowspan="2">%s</td>
											 </tr>
															<tr>
											  <td>S12、您对本店提供的餐食种类和质量是否满意？</td>
											 </tr>
											</table>';
	public static $Tabiii='<table  cellpadding="2" border="1">
											 <tr>
											  <td width="50%%" style="text-align:center; background-color:#538DD5;">三级指标</td>
											  <td width="30%%" style="text-align:center;background-color:#538DD5;">汇总指标</td>
											  <td width="20%%" style="text-align:center;background-color:#538DD5;">加权得分</td>
											 </tr>
											 <tr>
											  <td>Z1、每次维修/保养是否能解决您的问题？</td>
											  <td style="text-align:center;" rowspan="4">维修保养结果</td>
											  <td style="text-align:center;"rowspan="4">%s</td>
											 </tr>
											 <tr>
											  <td>Z8、交车时，车辆是否清洁？ </td>
						
											 </tr>
													<tr>
											  <td>Z9、服务完成后，座椅、倒车镜、音响、空调等车辆设置与入厂时是否一致？（可多选）</td>
						
											 </tr>
												<tr>
											  <td>Z10、交车时服务顾问是否与您确认维修保养结果？</td>
						
											 </tr>
												<tr>
											  <td>Z3、店里是否允许您与维修保养技师直接沟通？</td>
												 <td style="text-align:center;" rowspan="5">维修保养结果</td>
											  <td style="text-align:center;"rowspan="5">%s</td>
											 </tr>
						
												<tr>
											  <td>Z4、维修保养的过程是否透明？</td>
						
											 </tr>
														<tr>
											  <td>Z6、店内是否主动告知车主三包内容？</td>
						
											 </tr>
														<tr>
											  <td>Z11、是否主动告知配件、辅料（机油、防冻液等）的使用情况？</td>
						
											 </tr>
														<tr>
											  <td>Z12、服务顾问是否主动询问剩余材料和旧件的处理方式？</td>
						
											 </tr>
														<tr>
											  <td>Z14、您是否因为维修保养进行过投诉？</td>
											 <td style="text-align:center;" rowspan="2">维修保养结果</td>
											  <td style="text-align:center;"rowspan="2">%s</td>
											 </tr>
															<tr>
											  <td>Z15、您对门店投诉处理是否感到满意？</td>
						
											 </tr>
						
						
											</table>';
	public static $Tabiv='<table  cellpadding="2" border="1">
											 <tr>
											  <td style="text-align:center; background-color:#538DD5;">三级指标</td>
											  <td style="text-align:center;background-color:#538DD5;">汇总指标</td>
											  <td style="text-align:center;background-color:#538DD5;">加权得分</td>
											 </tr>
											 <tr>
											  <td>T2、预约是否有优惠？</td>
											  <td style="text-align:center;" rowspan="1">预约服务提供</td>
											  <td style="text-align:center;"rowspan="1">%s</td>
											 </tr>
											 <tr>
											  <td>T5、进入接待区后是否需要等待？ </td>
												<td style="text-align:center;" rowspan="7">维修保养服务时长</td>
											  <td style="text-align:center;"rowspan="7">%s</td>
											 </tr>
													<tr>
											  <td>T6、是否提前告知维修保养时长？</td>
						
											 </tr>
												<tr>
											  <td>T7、维修工位是否需要等待？</td>
						
											 </tr>
												<tr>
											  <td>T8、服务顾问预计的维修保养等待时长您是否满意？</td>
						
											 </tr>
						
												<tr>
											  <td>T9、是否按约定时间交车？</td>
						
											 </tr>
														<tr>
											  <td>T12、完工后交车是否需要等待？</td>
						
											 </tr>
														<tr>
											  <td>T13、付款结算环节是否需要等待？</td>
						
											 </tr>
						
														<tr>
											  <td>T15、您认为门店的营业时间是否便利？</td>
											 <td style="text-align:center;" rowspan="1">营业时间便利</td>
											  <td style="text-align:center;"rowspan="1">%s</td>
											 </tr>
											</table>';
	public static $Tabv='<table  cellpadding="2" border="1">
											 <tr>
											  <td width="50%%" style="text-align:center; background-color:#538DD5;">指标</td>
											  <td width="30%%" style="text-align:center;background-color:#538DD5;">三级指标</td>
											  <td width="20%%" style="text-align:center;background-color:#538DD5;">加权得分</td>
											 </tr>
											 <tr>
											  <td>P1、维修、保养价格是否公开透明？</td>
											  <td style="text-align:center;" rowspan="1">价格透明度</td>
											  <td style="text-align:center;"rowspan="1">%s</td>
											 </tr>
											 <tr>
											  <td>P2、您觉得店内维修保养的配件和材料定价是否合理？ </td>
												<td style="text-align:center;" rowspan="3">定价合理性</td>
											  <td style="text-align:center;"rowspan="3">%s</td>
											 </tr>
											 <tr>
											  <td>P3、您觉得店内维修保养的工时定价是否合理</td>
						
											 </tr>
											  <tr>
											  <td>P4、店内是否提供配件的多种选择（如：原厂件、配套件等）？</td>
						
											 </tr>
											</table>';
	/**全文标题*/
	const  TitleAll='北京立秋公司售后服务测评报告';
	/**全文一级标题*/
	const  TitleOneI='第一节	背景分析与样本汇总情况';
	const  TitleOneII='第二节	单店售后服务客户体验测评总体情况';
	/**全文二级标题*/
	const  TitleTwoI1='一 	被访车主人口学背景信息分析';
	const  TitleTwoI2='二 	单店完成样本量汇总';
	
	const  TitleTwoII1='一	售后服务测评得分情况';
	const  TitleTwoII2='二	五大模块得分情况点评';
	const  TitleTwoII3='三	“车主忠诚度”情况分析';
	const  TitleTwoII4='四	“口碑推荐”结果分析';
	
	/**全文三级标题*/
	const  TitleThrI1_1='1.1	性别分布';
	const  TitleThrI1_2='1.2	年龄分布';
	const  TitleThrI1_3='1.3	学历分布';
	const  TitleThrI1_4='1.4	职业分布';
	const  TitleThrI1_5='1.5	家庭年收入';
	const  TitleThrI1_6='1.6	购车年限';
	
	const  TitleThrII2_1='2.1	“服务顾问”';
	const  TitleThrII2_2='2.2	“服务设施”';
	const  TitleThrII2_3='2.3	“维修保养质量”';
	const  TitleThrII2_4='2.4	“维修保养时间”';
	const  TitleThrII2_5='2.5	“维修保养价格”';
	
	/**全文搜索四级**/
	const  TitleFouII2_1_1='2.1.1	服务顾问指标得分情况';
	const  TitleFouII2_1_2='2.1.2	服务顾问指标细项归纳得分情况';
	const  TitleFouII2_1_3='2.1.3	服务顾问指标得分极值分析';
	const  TitleFouII2_1_4='2.1.4	服务顾问探查分析';
	const  TitleFouII2_1_5='2.1.5	服务顾问改进分析';
	
	const  TitleFouII2_2_1='2.2.1	服务设施指标得分情况';
	const  TitleFouII2_2_2='2.2.2	服务设施指标细项归纳得分情况';
	const  TitleFouII2_2_3='2.2.3	服务设施指标得分极值分析';
	const  TitleFouII2_2_4='2.2.4	服务设施车主需求探查';
	const  TitleFouII2_2_5='2.2.5	服务设施改进分析';
	
	const  TitleFouII2_3_1='2.3.1	维修保养质量指标得分情况';
	const  TitleFouII2_3_2='2.3.2	维修保养质量指标细项归纳得分情况';
	const  TitleFouII2_3_3='2.3.3	维修保养质量指标得分极值分析';
	const  TitleFouII2_3_4='2.3.4	维修保养质量车主需求探查';
	const  TitleFouII2_3_5='2.3.5	维修保养质量改进分析';
	
	const  TitleFouII2_4_1='2.4.1	维修保养时间指标得分情况';
	const  TitleFouII2_4_2='2.4.2	维修保养时间指标细项归纳得分情况';
	const  TitleFouII2_4_3='2.4.3	维修保养时间指标得分极值分析';
	const  TitleFouII2_4_4='2.4.4	维修保养时间车主需求探查分析';
	const  TitleFouII2_4_5='2.4.5	维修保养时间改进分析';
	
	const  TitleFouII2_5_1='2.5.1	维修保养价格指标得分情况';
	const  TitleFouII2_5_2='2.5.2	维修保养价格指标细项归纳得分情况';
	const  TitleFouII2_5_3='2.5.3	维修保养价格指标得分极值分析';
	const  TitleFouII2_5_4='2.5.4	维修保养价格车主需求探查分析';
	const  TitleFouII2_5_5='2.5.5	维修保养价格改进分析';
	
	
	/**全文搜索五级**/
	const  TitleFivII2_2_4_A='A.	门店地理位置重要性评价';
	const  TitleFivII2_2_4_B='B	.	无停车位时店面处理情况';
	const  TitleFivII2_2_4_C='C.	对店内提供的娱乐设施的评价';
	const  TitleFivII2_2_4_D='D.	车主希望店内新增娱乐设施';
	
	const  TitleFivII2_3_4_A='A.	车主希望店内新增娱乐设施';
	const  TitleFivII2_3_4_B='B	.	车主对三包内容和维修保养手册内容的了解';
	const  TitleFivII2_3_4_C='C.	车主希望在什么环节了解三包内容';
	const  TitleFivII2_3_4_D='D.	维修保养质量改进分析';
	
	const  TitleFivII2_4_4_A='A.	车主预约习惯分析';
	const  TitleFivII2_4_4_B='B	.	车主不愿意预约的原因分析';
	const  TitleFivII2_4_4_C='C.	超长交车多长时间可能会导致车主换店';
	const  TitleFivII2_4_4_D='D.	车主进店维修保养时间段偏好分析';
	
	const  TitleFivII2_5_4_A='A.	维修保养价格影响换店可能性分析';
	const  TitleFivII2_5_4_B='B	.	维修保养价差导致的换店分析';
	
	/**全文文本信息*/
	#.第一节
	const  TextI1='				本月参与测评的车主样本一共%s位，人口学背景具有以下分布。';
	const  TextI2='			    本月参与测评的男性车主共%s位，比例为%s;女性车主为%s位，比例%s。';
	const  TextI3='			    本月参与测评的车主年龄%s区间最多，比例为%s；其次是%s区间，比例为%s；%s区间最少，比例为%s。';
	const  TextI4='				本月参与测评的车主学历以%s最多，比例为%s；其次是%s，比例为%s；%s的车主比例最低，为%s。';
	const  TextI5='             本月参与测评的车主职业以%s最多，比例为%s%；其次是%s，比例为%s，职业分布最少的是%s，比例为%s。';
	const  TextI6='				本月参与测评的车主家庭年收入集中在%s的最多，比例为%s，其次是%s，比例为%s，比例最低的是%s，为%s。';
	const  TextI7='				本月参与测评的车主购车年限%s的最多，比例为%s；其次是%s的车主，比例为%s；购车年限为%s的车主比例最低，仅为%s。';
	const  TextI8='			    本月共有%s位车主参与了测评调查，各模块完成样本数量如下：';
	#.第二节
	const  TextII1='			本店%s月售后服务测评平均得分为%s分，其中服务顾问得%s分；服务设施得%s分；维修保养质量得%s分；维修保养时间得%s分；维修保养价格得分%s分。';
	
	/**全文文本列表*/
	#.第二节

	//2-2-1-1
	const  TextIIUl1='<ul>
									<li>		"%s"得分最高，为%s分</li>
									<li>		"%s"得分最低，为%s分</li>
								   </ul>';
	//2-2-1-2
	const  TextIIUl2='<ul>
									<li>		"%s"得分最高，为%s分</li>
									<li>		"%s"得分最低，为%s分</li>
								   </ul>';
	 const     TextIIUl3='<ul><li>车主选选择	%s	的比例最高，为%s</li><li>车主选选择	%s	的比例最低，为%s</li></ul>';
	 const     TextIIUl4='<ul><li>车主认为服务顾问里	%s	是最重要的因素，比例为%s</li><li>车主认为服务顾问里	%s	是第二重要的因素，比例为%s</li></ul>';
	 const     TextIIUl5='<ul><li>车主认为门店地理位置里	%s	是最重要的因素，比例为%s</li><li>车主认为门店地理位置里	%s	是最不重要的因素，比例为%s</li></ul>';
	 const     TextIIUl6='<ul><li>%s的车主表示返修会考虑更换门店</li><li>%s的车主表示返修不会考虑更换门店</li></ul>';
	 const     TextIIUl7='<ul><li>%s的车主表示了解三包内容和维修保养手册内容</li><li>%s的车主表示不了解三包内容和维修保养手册内容</li></ul>';
	 const     TextIIUl8='<ul><li>%s的车主希望在“购车时”了解三包内容</li><li>%s的车主希望在“日常维修保养时”了解三包内容</li></ul>';
	 const     TextIIUl9='<ul><li>%s的车主希望自行处理剩余材料和旧件需求</li><li>%s的车主不希望自行处理剩余材料和旧件需求</li></ul>';
	 const     TextIIUl10='<ul><li>%s的车主希望在“购车时”了解三包内容</li><li>%s的车主希望在“日常维修保养时”了解三包内容</li></ul>';
	 const     TextIIUl11='<ul><li>%s的车主希望自行处理剩余材料和旧件需求</li><li>%s的车主不希望自行处理剩余材料和旧件需求</li></ul>';
	 const     TextIIUl12='<ul><li>%s  娱乐落差比例最低，比例为%s</li><li>%s  娱乐落差比例最高，比例为%s</li></ul>';
	 #.最后的分析
	 const      TextIIUl26='<ul><li>%s的车主表示下次仍会接受本店的服务</li><li>%s的车主表示下次不会来本店接受服务</li></ul>';
	 const      TextIIUl27='<ul><li>%s的车主表示会向朋友推荐本店</li><li>%s的车主表示不会向朋友推荐本店</li></ul>';
}
?>