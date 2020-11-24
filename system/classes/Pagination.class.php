<?php defined('Imperial') or die('No direct script access.');

class Pagination {
	/**
     * Constructor
     *
     * @param int $total
     * @param int $limit
     * @param string $str
     */
	function __construct($total, $limit, $str) {
		$this -> total = $total;
		$this -> limit = $limit;
		$this -> str = $str;
		$this -> page = (!isset($_GET['page']) or !is_numeric($_GET['page']) or $_GET['page'] == 0) ? 1 : (int)$_GET['page'];
		$this -> pages = ceil($this -> total / $this -> limit);

		if($this -> page > $this -> pages)
			$this -> page = $this -> pages;
	}


	/**
     * run
     *
     * @return string
     */
	function run() {
		if($this -> total <= $this -> limit)
			return;
			
		$navi = '<article><nav>';
		$navi .= ($this -> page > 1) ? '<ul><li><a title="&lt; туда" href="' . $this -> str . '/' . ($this -> page - 1) . '">&lt;- туда</a></li>' : '<ul><li><span>&lt;- туда</span></li>';
     	$navi .= ($this -> page < $this -> pages) ? '<li><a title="&gt; сюда" href="' . $this -> str . '/' . ($this -> page + 1) . '">сюда -&gt;</a></li></ul>' : '<li><span>сюда -&gt;</span></li></ul>';
     	if($this -> total > $this -> limit) {

        	$navi .= '<ul>';
        	if($this -> page != 1) {
        		$navi .= '<li><a title="Страница #1" href="' . $this -> str . '/1">1</a><li> ';
        		if($this -> page == 3)
        			$navi .= '<li><a title="Страница #2" href="' . $this -> str . '/2">2</a></li>';
        		if($this -> page > 4)
        			$navi .= '<li class="space"><span>...</span></li>';
        	}
  			if($this -> page-2 > 0 and $this -> page-2 != 1)
        		$navi .= '<li><a title="Страница #' . ($this -> page - 2) . '" href="' . $this -> str . '/' . ($this -> page - 2) . '">' . ($this -> page - 2) . '</a></li>';

    		$navi .= ($this -> page-2 > 0 and $this -> page-2 != 1) ? '<li><a title="Страница #' . ($this -> page - 1) . '" href="' . $this -> str . '/' . ($this -> page - 1) . '">' . ($this -> page - 1) . '</a></li>' : ' <li><span>' . $this -> page . '</span></li>';

			if($this -> pages == 2 and $this -> page != 2)
               $navi .= '<li><a title="Страница #2" href="' . $this -> str . '/2">2</a></li>';

  			if(($this -> page + 1) <= $this -> pages) {
  				if(!in_array($this -> page, array(1, 2, 3)))
  					$navi .= '<li><span>' . $this -> page . '</span></li>';
  				if(($this -> page + 1) != $this -> pages)
  					$navi .= '<li><a title="Страница #' . ($this -> page + 1) . '" href="' . $this -> str . '/' . ($this -> page + 1) . '">' . ($this -> page + 1) . '</a></li>';
  			}

   			if($this -> pages == 3 and $this -> page != 3)
               $navi .= '<li><a title="Страница #3" href="' . $this -> str . '/3">3</a></li>';

  			if(($this -> page + 2) < $this -> pages)
  				$navi .= '<li><a title="Страница #' . ($this -> page + 2) . '" href="' . $this -> str . '/' . ($this -> page + 2) . '">' . ($this -> page + 2) . '</a></li>';

  			if($this -> pages > 3) {
  				if($this -> page != $this -> pages) {
  					if(!in_array($this->page, array($this->pages - 1, $this->pages - 2, $this->pages - 3)))
  						$navi .= '<li class="space"><span>...</span></li>';
  					$navi .= ' <li><a title="Страница #' . $this -> pages . '" href="' . $this -> str . '/' . ($this -> pages) . '">' . ($this -> pages) . '</a></li>';
  				} else {
  					$navi .= ' <li><span>' . $this -> pages . '</span></li>';
  				}
  	 		}
  	 	}
  	 	return $navi . '</ul>
                    </nav>
                </article><!-- block -->';
  	}
}