<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 02.02.17
 * Time: 17:41
 */

namespace andrew72ru\flowjs\controllers;


use andrew72ru\flowjs\Module;
use yii\base\Controller;
use yii\helpers\FileHelper;
use yii\web\Response;
use Yii;

/**
 * Controller for upload files
 *
 * Class UploadController
 * @package andrew72ru\flowjs\controllers
 *
 * @property Module module
 */
class UploadController extends Controller
{
    /** @var  \Flow\Request */
    private $request;

    /** @var  \Flow\Config $config */
    private $config;

    /** @var  \Flow\File $file */
    private $file;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $dir = Yii::getAlias($this->module->tempChunksDirectory);
        if(!is_dir($dir))
            FileHelper::createDirectory($dir);

        $this->config = new \Flow\Config();
        $this->config->setTempDir($dir);

        $this->file = new \Flow\File($this->config);

        $this->request = new \Flow\Request();
    }

    /**
     * Uploads a file
     *
     * @return bool|string
     */
    public function actionUpload()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if(Yii::$app->request->isGet)
        {
            if($this->file->checkChunk())
                Yii::$app->response->setStatusCode(200, 'Ok');
            else
                Yii::$app->response->setStatusCode(204, 'No Content');

            Yii::$app->response->send();
            return false;
        }

        if($this->file->validateChunk())
            $this->file->saveChunk();
        else
        {
            Yii::$app->response->setStatusCode(400, 'Bad Request');
            Yii::$app->response->send();
            return false;
        }

        if($this->file->validateFile() && $this->file->save($this->config->getTempDir() . DIRECTORY_SEPARATOR . $this->request->getFileName()))
        {
            return call_user_func($this->checkCallable(),
                $this->config->getTempDir() . DIRECTORY_SEPARATOR . $this->request->getFileName());
        }

        return false;
    }

    /**
     * Function checks a callback_class and callback_method from $_POST
     *
     * @return array|mixed|callable
     */
    private function checkCallable()
    {
        $class = Yii::$app->request->post('callback_class', null);
        $method = Yii::$app->request->post('callback_method', null);

        if($class !== null && class_exists($class))
        {
            if(method_exists($class, $method) && is_callable([$class, $method]))
            {
                if((new \ReflectionMethod($class, $method))->isStatic())
                    return [$class, $method];
            }
        }

        return $this->module->callback;
    }

}