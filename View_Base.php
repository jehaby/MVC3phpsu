<?php


class View_Base {
    function render($template, $rgParams = array())
    {
        echo $this->_fetch($template, $rgParams);
    }

    protected function _fetch_segment($template, $rgParams = array())
    {
        extract($rgParams);
        ob_start();
        include VIEWS_PATH.$template.'.phtml';
        return ob_get_clean();
    }
    /*For debug purposes: */
    protected function _render_segment($template, $rgParams = array())
    {
        echo $this->_fetch_segment($template, $rgParams);
    }

    protected function _fetch($template, $rgParams = array())
    {
        $content = $this->_fetch_segment($template, $rgParams);
        return $this->_fetch_segment('layout', array('content' => $content));
    }
} 