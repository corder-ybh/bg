<?php
/**
 * 封装分页类
 * Created by PhpStorm.
 * User: bhyang
 * Date: 2018/3/15
 * Time: 11:32
 */
class Page
{
    //定义相关属性
    private $rowPerPage;    //每页显示的记录数
    private $maxNum;        //页面显示的最大页码数
    private $rowCount;      //总记录数
    private $url;           //固定url链接

    /**
     * 构造方法，初始化相关属性
     */
    public function __construct($rowPerPage, $rowCount, $maxNum, $url)
    {
        $this->rowPerPage = $rowPerPage;
        $this->rowCount = $rowCount;
        $this->maxNum = $maxNum;
        $this->url = $url;
    }

    /**
     * 核心方法，返回页码字符串
     */
    public function getStrPage()
    {
        //计算总页数 ceil?
        $pages = ceil($this->rowCount / $this->rowPerPage);
        //确定当前选中的页码数
        $pageNum = isset($_GET['pageNum']) ? $_GET['pageNum'] : 1;
        //定义页码字符串
        $strPage = '';
        //拼凑出 "首页"
        $strPage .= "<a href='{$this->url}pageNum=1'>首页</a>";
        //拼凑出 "上一页",如果当前页比1大，那么加上上一页的选项
        $preNum = $pageNum -  1;
        if ($pageNum != 1) {
            $strPage .= "<a href='{$this->url}pageNum=$preNum'><<上一页</a>";
        }
        //确定显示的初始化$startNum
        if ($pageNum <= ceil($this->maxNum) / 2) {
            $startNum = 1;    //如果当前页事1-3页，显示的初始页就是1
        } else {
            $startNum = $pageNum - ceil($this->maxNum / 2) + 1;
        }
        //确定显示初始页的最大值
        if ($startNum >= $pages - $this->maxNum + 1) {
            $startNum = $pages - $this->maxNum + 1;
        }
        //防止页面出现负值
        if ($startNum <= 1) {
            $startNum = 1;
        }
        //确定显示的最后一页$endNum
        $endNum = $startNum + $this->maxNum - 1;
        //防止显示的最后一页越界
        if ($endNum > $pages) {
            $endNum = $pages;
        }

        //拼凑出中间的页码
        for ($i=$startNum;$i<=$endNum;$i++) {
            //选中的当前页标红
            if ($i == $pageNum) {
                $strPage .= "<a href='{$this->url}pageNum=$i'><font color='red'>$i</font></a>";
            } else {
                $strPage .= "<a href='{$this->url}pageNum=$i'>$i</a>";
            }
        }
        //拼凑出下一页,如果当前页不是最后一页，那么就有下一页
        $nextNum = $pageNum + 1;
        if ($pageNum != $pages) {
            $strPage .= "<a href='{$this->url}pageNum=$nextNum'>下一页>></a>";
        }
        //拼凑出"尾页"
        $strPage .= "<a href='{$this->url}pageNum=$pages'>尾页</a>";
        //拼凑出总页码数
        $strPage .= "|总页数:$pages";
        //返回页码字符串
        return $strPage;
    }
}