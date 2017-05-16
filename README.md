# zcloud
汽车售后服务大数据检测平台
#.整体系统业务采用M-S-C-V四层架构，商户平台功能最为完善，代码最具代表性
	1.查看复杂语句查询可查看Model层下merchant文件夹下：AnagroupModel.php;		AnastoreModel.php;		MonitorModel.php;	PDFModel.php;
	   四个文件，这其中主要是数据分析和数据挖掘
	2.查看PHP代码业务逻辑情况请查看对应的Service层和Controller,其他控制器也都可以
	3.查看JS+Jquery情况可打开static/wechat/js即可查看，或者查看static/merchant/js/cada_merchant开头的js文件
1.applocation
	|-----------config			::配置层
	|-----------controller 		::控制器层
					|-----------admin(管理平台)
					|-----------merchant(商户平台)
					|-----------collection(采集平台)
	|-----------core				::核心层
	|-----------libraries		::类库层
					|-----------admin(管理平台)
					|-----------merchant(商户平台)
					|-----------collection(采集平台)
	|-----------service			::服务层
					|-----------admin(管理平台)
					|-----------merchant(商户平台)
					|-----------collection(采集平台)
	|-----------views				::视图层
					|-----------admin(管理平台)
					|-----------merchant(商户平台)
					|-----------collection(采集平台)
2.static
	|-----------admin
	|-----------merchant
	|-----------global
	|-----------wechat
3.system
4.upload