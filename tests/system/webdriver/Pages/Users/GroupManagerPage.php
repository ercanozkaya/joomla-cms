<?php

use SeleniumClient\By;
use SeleniumClient\SelectElement;
use SeleniumClient\WebDriver;
use SeleniumClient\WebDriverWait;
use SeleniumClient\DesiredCapabilities;
use SeleniumClient\WebElement;

/**
 * Class for the back-end control panel screen.
 *
 */
class GroupManagerPage extends AdminManagerPage
{
	protected $waitForXpath =  "//ul/li/a[@href='index.php?option=com_users&view=groups']";
	protected $url = 'administrator/index.php?option=com_users&view=groups';

	/**
	 *
	 * @var GroupManagerPage
	 */
	public $groupManagerPage = null;

	public $toolbar = array (
			'toolbar-new',
			'toolbar-edit',
			'toolbar-delete',
			'toolbar-options',
			'toolbar-help'
			);

	public $submenu = array (
			'option=com_users&view=users',
			'option=com_users&view=groups',
			'option=com_users&view=levels',
			'option=com_users&view=notes',
			'option=com_categories&extension=com_users'
			);

	public function addGroup($name='Test Group', $parent='Public')
	{
		$this->clickButton('toolbar-new');
		$editGroupPage = $this->test->getPageObject('GroupEditPage');
		$editGroupPage->setFieldValues(array('Group Title' => $name, 'Group Parent' => $parent));
		$editGroupPage->clickButton('toolbar-save');
		$this->groupManagerPage = $this->test->getPageObject('GroupManagerPage');
	}

	public function deleteGroup($name)
	{
		$this->searchFor($name);
		$this->driver->findElement(By::name("checkall-toggle"))->click();
		$this->clickButton('toolbar-delete');
		$this->driver->waitForElementUntilIsPresent(By::xPath($this->waitForXpath));
		$this->searchFor();
	}

	public function editGroup($name, $fields)
	{
		$this->clickItem($name);
		$editGroupPage = $this->test->getPageObject('GroupEditPage');
		$editGroupPage->setFieldValues($fields);
		$editGroupPage->clickButton('toolbar-save');
		$this->groupManagerPage = $this->test->getPageObject('GroupManagerPage');
	}
}