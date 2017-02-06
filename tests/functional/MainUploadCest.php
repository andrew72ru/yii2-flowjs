<?php


class MainUploadCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    public function tryToTest(FunctionalTester $I)
    {
        $I->amOnRoute('flowjs/upload');
        $I->wantToTest('Upload files with JS');
    }
}
