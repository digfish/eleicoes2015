<?php

class BaseController extends Controller {

    /**
     * The layout that should be used for responses.
     */
    protected $layout = 'master';

    protected function setupLayout() {
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }

}
