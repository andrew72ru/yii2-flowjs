<?php

namespace andrew72ru\flowjs;

use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\i18n\PhpMessageSource;

/**
 * Bootstraping a Module
 * Set url configuration for web application, console commands controller namespace and translation
 */
class Bootstrap implements BootstrapInterface
{

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        /** @var Module $module */
        if($app->hasModule('flowjs') && (($module = $app->getModule('flowjs')) instanceof Module))
        {
            if($app instanceof \yii\console\Application)
            {
                $module->controllerNamespace = 'andrew72ru\flowjs\commands';
            } else
            {
                $configUrlRule = [
                    'prefix' => $module->urlPrefix,
                    'rules' => $module->urlRules
                ];

                if($module->urlPrefix != 'flowjs')
                    $configUrlRule['routePrefix'] = 'flowjs';

                $configUrlRule['class'] = 'yii\web\GroupUrlRule';
                $rule = \Yii::createObject($configUrlRule);

                $app->urlManager->addRules([$rule], false);
            }

            if(!isset($app->get('i18n')->translations['flowjs*']))
            {
                $app->get('i18n')->translations['flowjs*'] = [
                    'class' => PhpMessageSource::className(),
                    'basePath' => __DIR__ . '/messages',
                    'sourceLanguage' => 'en-US'
                ];
            }
        }

    }
}