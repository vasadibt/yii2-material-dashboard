<?php
/**
 * Created by PhpStorm.
 * User: Vasadi-Balogh Tamás
 * Date: 2018. 02. 28.
 * Time: 9:04
 */

namespace vasadibt\materialdashboard\grid;

/**
 * Class SerialColumn
 * @package vasadibt\materialdashboard\grid
 */
class SerialColumn extends \kartik\grid\SerialColumn
{
    public $width = '30px';

    public function init()
    {
        parent::init();
        $this->setPageRows();
    }
}