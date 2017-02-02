<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 02.02.17
 * Time: 16:53
 */

namespace andrew72ru\flowjs\commands;


use yii\console\Controller;

/**
 * Controller for flush old FlowJs chunks
 *
 * Class FlowController
 * @package andrew72ru\flowjs\commands
 */
class FlowController extends Controller
{
    public $color = true;

    /**
     * Flush Chunks by $path
     *
     * @param string $path Path to chunks temp directory. '@runtime/runtime/flow-chunks by default'
     */
    public function actionIndex($path = null)
    {

    }
}