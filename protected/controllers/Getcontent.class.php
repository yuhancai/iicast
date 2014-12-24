<?php
/** grep class


*   set:        设置内容
*   get:        返回指定的内容
             'url' => '/<a.*?href="((http(s)?:\/\/).*?)".*?/si',
                            'email' => '/([\w\-\.]+@[\w\-\.]+(\.\w+))/',
                            'image' => '/<img.*?src=\"(http:\/\/.+\.(jpg|jpeg|gif|bmp|png))\">/i',
							'shijian'=>'/\d{4}/x'
*   replace:    返回替换后的内容
*   get_pattern 根据type返回pattern  pile("\\([^\\(]+\\)"); /
*/
class Grep { // class start 2014-11-16 14:42:30.281 \d{4}-\d{2}-\d{2}\s?\d{2}:\d{2}:\d{2} <span class="txt-red">
	private $_pattern = array (
			'url' => '/<a.*?href="((http(s)?:\/\/).*?)".*?/si',
			'email' => '/([\w\-\.]+@[\w\-\.]+(\.\w+))/',
			'image' => '/<img.*?src=\"(http:\/\/.+\.(jpg|jpeg|gif|bmp|png))\">/i',
			'shijian' => '/(\d{4}-\d{2}-\d{2}\s?\d{2}:\d{2}:\d{2})/',
			'luckynum' => '/<span.*>(\d{8})\D/',
			'dijiqi' => '/<title.*([\(][\S]*[\)])/' 
	);
	private $_content = ''; // 源内容
	
	/*
	 * 設置搜尋的內容 @param String $content
	 */
	public function set($content = '') {
		$this->_content = $content;
	}
	
	/*
	 * 获取指定内容 @param String $type @param int $unique 0:all 1:unique @return Array
	 */
	public function get($type = '', $unique = 0) {
		$type = strtolower ( $type );
		
		if ($this->_content == '' || ! in_array ( $type, array_keys ( $this->_pattern ) )) {
			return array ();
		}
		
		$pattern = $this->get_pattern ( $type ); // 获取pattern
		
		preg_match_all ( $pattern, $this->_content, $matches );
		
		return isset ( $matches [1] ) ? ($unique == 0 ? $matches [1] : array_unique ( $matches [1] )) : array ();
	}
	
	/*
	 * 获取替换后的内容 @param String $type @param String $callback @return String
	 */
	public function replace($type = '', $callback = '') {
		$type = strtolower ( $type );
		
		if ($this->_content == '' || ! in_array ( $type, array_keys ( $this->_pattern ) ) || $callback == '') {
			return $this->_content;
		}
		
		$pattern = $this->get_pattern ( $type );
		
		return preg_replace_callback ( $pattern, $callback, $this->_content );
	}
	
	/*
	 * 根据type获取pattern @param String $type @return String
	 */
	private function get_pattern($type) {
		return $this->_pattern [$type];
	}
	private function get_url_contents($url) {
		// 先判断allow_url_fopen是否打开，如果打开则用file_get_contents获取，如果没打开用curl_init获取
		if (ini_get ( "allow_url_fopen" ) == "1")
			return file_get_contents ( $url );
		else {
			$ch = curl_init ();
			curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
			curl_setopt ( $ch, CURLOPT_URL, $url );
			$result = curl_exec ( $ch );
			curl_close ( $ch );
		}
		return $result;
	}
} // class end

?>