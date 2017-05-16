<?php
/*****************************************************
 **作者：张文晓
**创始时间：2017-01-06
**描述：通用分页类，主要包括分页中具体常用的
*			   几种形式。
*****************************************************/
class CurrPage{
	
	#.起始行数
    public $firstRow; 
    #.列表每页显示行数
    public $listRows; 
    #.分页跳转时要带的参数
    public $parameter; 
    #.总行数
    public $totalRows;
    #.分页总页面数
    public $totalPages; 
    #.分页栏每页显示的页数
    public $rollPage= 5;
    #.最后一页是否显示总页数
	public $lastSuffix = true; 
	#.分页参数
    private $page= 'p'; 
    #.当前链接URL
    private $url= ''; 
    #.当前页面
    private $nowPage = 1;
	#.分页显示定制
    private $config  = array(
		        'header' => '<span class="rows">共 %Total% 条记录</span>',
		        'prev'     => '上一页',
		        'next'     => '下一页',
		        'first'      => '首页',
		        'theme'  => '%First%%UP%%Link%%Down%%END%',
    );
    /**
     ***********************************************************
     *方法::CurrPage::__construct
     * ----------------------------------------------------------
     * 描述::分页类初始化方法
     *----------------------------------------------------------
     *参数:
     *parm1:in--   String : url               :: 分页跳转链接
     *parm2:in--   String : totalSize     :: 分页数据总条数
     *parm3:in--   String : listSize        :: 每页多少条数
     *parm4:in--   Array  : parameter  :: 需要附加的参数组
     *parm5:in--   String : now            :: 当前页码
     *----------------------------------------------------------
     *返回：
     *return:out--  无 
     * ----------------------------------------------------------
     *示例:
     *case1:use--  new CurrPage('admin/list',50,'10',array("role"=>'admin'))
     *----------------------------------------------------------
     * 日期:2017.01.06  Add by zwx
     ************************************************************
     */
    public function __construct($urli,$totalSize, $listSize, $now=NULL,$param=array()) {
    	#.设置跳转地址
    	$this->url=$urli."?".$this->page."=[page]";
    	#.设置总记录数
        $this->totalRows  = $totalSize; 
        #.设置每页显示行数
        $this->listRows=$listSize;  
        $this->parameter=empty($param) ? NULL : $param;
        $this->nowPage=empty($now)?1:$now;
        $this->firstRow=$this->listRows * ($this->nowPage - 1);
    }
    /**
     ***********************************************************
     *方法::CurrPage::__setUrl
     * ----------------------------------------------------------
     * 描述::分页类设置连接方法
     *----------------------------------------------------------
     *参数:
     *parm1:in--   String : page     :: 页码
     *----------------------------------------------------------
     *返回：
     *return:out--  String : rowsStr :: 分页链接地址
     * ----------------------------------------------------------
     *示例:
     *case1:use--  setUrl(12)
     *----------------------------------------------------------
     * 日期:2017.01.06  Add by zwx
     ************************************************************
     */
    private function setUrl($page){
    	if(!empty($this->parameter)){
    		foreach ($this->parameter as $key => $value){
    			$this->url.="&".$key."=".$value;
    		}
    	}
        return str_replace('[page]', $page, $this->url);
    }
    /**
     ***********************************************************
     *方法::CurrPage::showPage
     * ----------------------------------------------------------
     * 描述::分页类显示方法
     *----------------------------------------------------------
     *参数:
     *parm1:in--   无
     *----------------------------------------------------------
     *返回：
     *return:out--  String : divStr :: 分页显示字符串
     * ----------------------------------------------------------
     *示例:
     *case1:use--  showPage()
     *----------------------------------------------------------
     * 日期:2017.01.06  Add by zwx
     ************************************************************
     */
    public function showPage() {
        if(0 == $this->totalRows) return '';
        /* 计算分页信息 */
        $this->totalPages = ceil($this->totalRows / $this->listRows); 
        (!empty($this->totalPages) && $this->nowPage > $this->totalPages) && $this->totalPages=$this->firstRow;
        /* 计算分页零时变量 */
        $nowPage=$this->rollPage/2;
		$nowPageCeil=ceil($nowPage);
		$this->lastSuffix && $this->config['last'] = $this->totalPages;
        /*上一页*/
        $up_page = ($this->nowPage - 1) > 0 ? '<a class="prev" href="' . $this->setUrl($this->nowPage - 1) . '">' . $this->config['prev'] . '</a>' : '';
        /*下一页*/
        $down_page = (($this->nowPage + 1) <= $this->totalPages) ? '<a class="next" href="' . $this->setUrl($this->nowPage + 1) . '">' . $this->config['next'] . '</a>' : '';
        /*首页*/
        $the_first = '<a class="first" href="' . $this->setUrl(1) . '">' . $this->config['first'] . '</a>';
        /*尾页*/
        $the_end = '<a class="end" href="' . $this->setUrl($this->totalPages) . '">末页</a>';
        /*数字页面*/
        $link_page = "";
        /*页数*/
        $page=0;
        for($i = 1; $i <= $this->rollPage; $i++){
        	(($this->nowPage -$nowPage) <= 0 && $page = $i) ||
        	(($this->nowPage + $nowPage - 1) >= $this->totalPages && $page = $this->totalPages - $this->rollPage + $i) ||
        	$page = $this->nowPage - $nowPageCeil + $i;
            if($page > 0 && $page != $this->nowPage){
                if($page <= $this->totalPages) $link_page .= '<a class="num" href="' . $this->setUrl($page) . '">' . $page . '</a>'; else  break;
            }else{
                ($page > 0 && $this->totalPages != 0) && $link_page .= '<a class="current" href="javascript:void(0);">' . $page . '</a>';
            }
        }
        $leftArray=array('%Header%', '%Now%', '%UP%', '%Down%', '%First%', '%Link%', '%END%', '%Total%', '%TotalPage%');
        $rightArray= array($this->config['header'], $this->nowPage, $up_page, $down_page, $the_first, $link_page, $the_end, $this->totalRows, $this->totalPages);
        /*替换分页内容*/
        return "<div id='paging'>".str_replace($leftArray ,$rightArray,$this->config['theme'])."</div>";
    }
}
