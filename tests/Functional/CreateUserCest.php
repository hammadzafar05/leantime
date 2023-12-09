<?php

namespace Functional;

use Codeception\Attribute\Depends;
use Tests\Support\FunctionalTester;
use Tests\Support\Page\Functional\Login;

class CreateUserCest
{
    public function _before(FunctionalTester $I, Login $loginPage)
    {
        $loginPage->login('test@leantime.io', 'test');
    }

    #[Depends('Tests\Functional\LoginCest:loginSuccessfully')]
    public function createAUser(FunctionalTester $I)
    {
        $I->wantTo('Create a user');
        $I->amOnPage('/users/showAll');
        $I->click('Add User');
        $I->waitForElement('#firstname', 120);
        $I->fillField('#firstname', 'John');
        $I->fillField('#lastname', 'Doe');
        $I->selectOption('#role', 'Read Only');
        $I->selectOption('#client', 'Not assigned to a client');
        $I->fillField('#user', 'john@doe.com');
        $I->fillField('#phone', '1234567890');
        $I->fillField('#jobTitle', 'Testing');
        $I->fillField('#jobLevel', 'Testing');
        $I->fillField('#department', 'Testing');
        $I->click('Invite User');
        echo $I->grabPageSource();
        $I->waitForElement('.growl', 120);
        $I->wait(2);
        $I->see('New user invited successfully');
    }

    #[Depends('Tests\Functional\LoginCest:loginSuccessfully')]
    public function editAUser(FunctionalTester $I)
    {
        $I->wantTo('Edit a user');
        $I->amOnPage('/users/editUser/1/');
        $I->see('Edit User');
        $I->fillField(['name' => 'jobTitle'], 'Testing');
        $I->click('Save');
        $I->waitForElement('.growl', 120);
        $I->see('User edited successfully');
    }
}