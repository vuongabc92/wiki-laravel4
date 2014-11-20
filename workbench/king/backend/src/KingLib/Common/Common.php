<?php namespace King\Backend\Common;

use \Redirect,
    \Session,
    \Route,
    \Config;

class Common{

    /**
     * Update active status for table that have specified model name and primary key
     *
     * @param string $model Model name
     * @param int  $id Primary key
     *
     * @return int Current active status
     */
    public function active($model, $id){

        $model = 'King\Backend\\' . $model;
        $model = $model::find($id);
        if($model->is_active){
            $model->is_active = 0;
        }else{
            $model->is_active = 1;
        }

        $model->save();

        return $model->is_active;
    }

    /**
     * Change string datetime to other format
     *
     * @param string $datetime
     * @param string $format (d/m/Y, Y-m-d,...)
     *
     * @return string Datetime string with format was set
     */
    public function changeDatetimeFormat($datetime, $format){

        $date = new \DateTime($datetime);

        return $date->format($format);
    }


    /**
     * Find specified resources
     *
     * @param string $sessionID Id of session flash
     * @param string $sessionMsg Message of session flash
     * @param string $urlTo URL will be redirected to
     *
     * @return string Datetime string with format was set
     */
    public function redirectWithMsg($sessionID, $sessionMsg, $urlTo){

        Session::flash($sessionID, $sessionMsg);
        return Redirect::to($urlTo);
    }

    /**
     * Get max order number
     *
     * @param string $model Model class name
     * @param string $column Order number column
     *
     * @return int max order number
     */
    public function getMaxOrderNumber($model, $column = 'order_number'){

        return $model::max($column);
    }

    /**
     * show active class
     *
     * @return string
     */
    public function showActiveClass($className, $nav){

        $currentPath = Route::getCurrentRoute()->getPath();

        if (count(explode('/', $currentPath)) >= 2) {
            list(, $navPath) = explode('/', $currentPath);

            if ($navPath == $nav) {
                return $className;
            }
        }
    }

    /**
     * Generate vertical menu navigation
     *
     * @return string Unorder list HTML
     */
    public function generateNavs(){
        
        $navs = Config::get('backend::navs');
        $activeClass = Config::get('backend::active_nav_class');

        $navHTML = '<ul class="_fwfl _db _m0 vertical-nav">';
        foreach($navs as $order => $nav){
            if($order == 0){
                $navHTML .= '<li class="vertical-nav-top">';
            }else{
                $navHTML .= '<li>';
            }
            $navHTML .= '<a href="' . url($nav['url']) . '" class ="' . $this->showActiveClass($activeClass, $nav['nav_name']) . '">'
                    .   '<i class="' . $nav['icon'] . ' left-nav-icon"></i>'
                    .   '<span class="left-nav-txt"> ' . $nav['txt'] . '</span>'
                    .   '<i class="fa fa-angle-left left-nav-arrow"></i>'
                    .   '</a></li>';
        }

        $navHTML .= '</ul>';

        return $navHTML;
    }
}