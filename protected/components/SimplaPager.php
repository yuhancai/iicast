<?php
class SimplaPager extends CLinkPager{
	const CSS_HIDDEN_PAGE='hidden';
	const CSS_SELECTED_PAGE='current';
	
	public $nextPageLabel = 'Siguiente &gt;';
	public $prevPagelabel = '&lt; Previo';
	public $firstPageLabel = '&lt;&lt; Primero';
	public $lastPageLabel = 'Ultimo &gt;&gt;';
	public $header = '';
	
	/**
	 * Executes the widget.
	 * This overrides the parent implementation by displaying the generated page buttons.
	 */
/* 	public function run()
	{
		$buttons=$this->createPageButtons();
		if(empty($buttons))
			return;
		echo $this->header;
		echo implode("&nbsp;",$buttons);
		echo $this->footer;
	} */
	/**
	 * Creates a page button.
	 * You may override this method to customize the page buttons.
	 * @param string the text label for the button
	 * @param integer the page number
	 * @param string the CSS class for the page button. This could be 'page', 'first', 'last', 'next' or 'previous'.
	 * @param boolean whether this page button is visible
	 * @param boolean whether this page button is selected
	 * @return string the generated button
	 */
/* 	protected function createPageButton($label,$page,$class,$hidden,$selected)
	{
		if($hidden || $selected)
			$class=' '.($hidden ? self::CSS_HIDDEN_PAGE : self::CSS_SELECTED_PAGE);
		$class .= ' number';
		
		return CHtml::link($label,'#',array('class'=>$class, 'onclick'=>"site.call(CONST_MAIN_LAYER,'{$this->createPageUrl($this->getController(),$page)}');"));
	} */
	/**
	 * Creates the URL suitable for pagination.
	 * This method is mainly called by pagers when creating URLs used to
	 * perform pagination. The default implementation is to call
	 * the controller's createUrl method with the page information.
	 * You may override this method if your URL scheme is not the same as
	 * the one supported by the controller's createUrl method.
	 * @param CController the controller that will create the actual URL
	 * @param integer the page that the URL should point to. This is a zero-based index.
	 * @return string the created URL
	 */
/* 	public function createPageUrl($controller,$page)
	{
		$params=$this->getPages()->params===null ? $_REQUEST : $this->getPages()->params;
		if($page>0) // page 0 is the default
			$params[$this->getPages()->pageVar]=$page+1;
		else
			unset($params[$this->getPages()->pageVar]);
		return $controller->createUrl($this->getPages()->route,$params);
	} */
}