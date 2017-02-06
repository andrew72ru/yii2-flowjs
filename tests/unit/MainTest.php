<?php


class MainTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testModule()
    {
        $this->assertInstanceOf('yii\base\Application', Yii::$app);
        $this->assertInstanceOf('andrew72ru\flowjs\Module', Yii::$app->getModule('flowjs'));
    }
}