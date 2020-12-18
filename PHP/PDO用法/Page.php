<?php
// namespace vendor\csl\framework;
class Page
{
	protected $totalRecords  = 1;  //总记录数
	protected $numberOfPage  = 1;  //每页的记录个数
	protected $totalPages;         //总页数
	protected $page;               //当前页
	protected $url;                //基准url

	/**
	 * [__construct description]
	 * @param int|integer $totalRecords [总记录数]
	 * @param int|integer $numberOfPage [每页记录数]
	 */
	public function __construct(int $totalRecords=1,int $numberOfPage=1)
	{
		$this->totalRecords = ($totalRecords > 0)?$totalRecords : $this->totalRecords;
		$this->numberOfPage = ($numberOfPage < 0 )?$this->numberOfPage : $numberOfPage;
		$this->totalPages = ceil($this->totalRecords / $this->numberOfPage);
		$this->getPage();//设置当前页
		$this->url = $this->getUrl();//获取基准url(不带page)
	}

	/**
	 * [first 首页]
	 * @return [type] [url字符串]
	 */
	public function first()
	{
		return $this->setUrl(1);
	}

	/**
	 * [last 尾页]
	 * @return [type] [url字符串]
	 */
	public function last()
	{
		return $this->setUrl($this->totalPages);
	}

	/**
	 * [pre 前一页]
	 * @return [type] [url字符串]
	 */
	public function pre()
	{
		if ($this->page <= 1) {
			return $this->first();
		}
		return $this->setUrl($this->page - 1);
	}

	/**
	 * [next 下一页]
	 * @return function [url字符串]
	 */
	public function next()
	{
		if ($this->page >= $this->totalPages) {
			return $this->setUrl($this->totalPages);
		}
		return $this->setUrl($this->page + 1);
	}

	public function limit()
	{
		return  ' ' .($this->page - 1)*$this->numberOfPage . ',' . $this->numberOfPage;
	}

	public function allPage()
	{
		return [
			'first' => $this->first(),
			'pre' => $this->pre(),
			'next' => $this->next(),
			'last' => $this->last(),
		];
	}

	public function pages()
	{
		return [
			 "<a href='{$this->allPage()['first']}'>首页</a>",
			"<a href='{$this->allPage()['pre']}'>前一页</a>",
			"<a href='{$this->allPage()['next']}'>下一页</a>",
			"<a href='{$this->allPage()['last']}'>尾页</a>",
		];
	}

	/**
	 * [setUrl 设置url]
	 * @param [type] $num [页数]
	 */
	protected function setUrl($num) 
	{
		if (stripos($this->url,'?') !== false) {
			return $this->url . '&' . "page= $num";
		} else {
			return $this->url ."?page=$num";
		}
	}

	//获取当前页
	function getPage()
	{
		if (empty($_GET['page'])) {
			$this->page = 1;
		} else {
			$page = $_GET['page'];
			if ($page < 1) {
				$this->page = 1;
			} elseif ($page > $this->totalPages) {
				$this->page = $this->totalPages;
			} else {
				$this->page = $page;
			}
		}
	}

	/**
	 * [getUrl 获取url]
	 * @return [type] [url字符串]
	 */
	function getUrl()
	{
		$url = $_SERVER['REQUEST_SCHEME'] .'://';//协议
		$url .= $_SERVER['HTTP_HOST']; //主机地址
		$url .= ':' . $_SERVER['SERVER_PORT']; //端口

		//array (size=2)
		// 'path' => string '/1712/high/5/server.php' (length=23)
		// 'query' => string 'page=1000&k=10&age=33' (length=21)
		$data = parse_url($_SERVER['REQUEST_URI']);//解析url为一个数组
		$url .= $data['path'];//拼接文件

		if (!empty($data['query'])) {//如果有参数
			$query = $data['query'];
			parse_str($query,$para);
			unset($para['page']);
			$query = http_build_query($para);
			$url .= '?' . $query;//拼接参数
		}
		$url = rtrim($url,'?');//去掉可能多余的问号
		return $url;
	}
}