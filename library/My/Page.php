<?php

class My_Page
{
    protected $_options;

    public function __construct(array $options = null)
    {
        if ($options === null) {
            $this->_options = array();
        } else {
            $this->_options = $options;
        }

        if (!isset($this->_options['title']['separator'])) {
            $this->_options['title']['separator'] = '';
        }
        if (!isset($this->_options['title']['content'])) {
            $this->_options['title']['content'] = '';
        }
        if (!isset($this->_options['title']['defaultAttachOrder'])) {
            $this->_options['title']['defaultAttachOrder'] = 'APPEND';
        }
        if (!isset($this->_options['css'])) {
            $this->_options['css'] = array();
        }
        if (!isset($this->_options['js'])) {
            $this->_options['js'] = array();
        }
        if (!isset($this->_options['keywords'])) {
            $this->_options['keywords'] = false;
        }
        if (!isset($this->_options['description'])) {
            $this->_options['description'] = false;
        }
        if (!isset($this->_options['extension'])) {
            $this->_options['extension'] = 'phtml';
        }
    }

    public function getTitleSeparator()
    {
        return $this->_options['title']['separator'];
    }

    public function setTitleSeparator($titleSeparator)
    {
        $this->_options['title']['separator'] = $titleSeparator;
    }
}