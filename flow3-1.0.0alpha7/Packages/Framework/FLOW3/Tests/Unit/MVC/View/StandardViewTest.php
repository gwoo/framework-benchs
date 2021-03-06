<?php
declare(ENCODING = 'utf-8');
namespace F3\FLOW3\MVC\View;

/*                                                                        *
 * This script belongs to the FLOW3 framework.                            *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * Testcase for the MVC StandardView
 *
 * @version $Id: StandardViewTest.php 3643 2010-01-15 14:38:07Z robert $
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class StandardViewTest extends \F3\Testing\BaseTestCase {

	/**
	 * @var \F3\FLOW3\Object\ObjectFactoryInterface
	 */
	protected $objectFactory;

	/**
	 * @var \F3\FLOW3\Package\PackageManagerInterface
	 */
	protected $packageManager;

	/**
	 * @var \F3\FLOW3\Resource\ResourceManager
	 */
	protected $recourceManager;

	/**
	 * @var \F3\FLOW3\Object\ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * @var \F3\FLOW3\MVC\Controller\Context
	 */
	protected $controllerContext;

	/**
	 * @var \F3\FLOW3\MVC\View\NotFoundView
	 */
	protected $view;

	public function setUp() {
		$this->objectFactory = $this->getMock('F3\FLOW3\Object\ObjectFactoryInterface', array(), array(), '', FALSE);
		$this->packageManager = $this->getMock('F3\FLOW3\Package\PackageManagerInterface', array(), array(), '', FALSE);
		$this->resourceManager = $this->getMock('F3\FLOW3\Resource\ResourceManager', array(), array(), '', FALSE);
		$this->objectManager = $this->getMock('F3\FLOW3\Object\ObjectManagerInterface', array(), array(), '', FALSE);

		$this->view = new \F3\FLOW3\MVC\View\StandardView($this->objectFactory, $this->packageManager, $this->resourceManager, $this->objectManager);

		$this->controllerContext = $this->getMock('F3\FLOW3\MVC\Controller\Context', array('getRequest'), array(), '', FALSE);
		$this->view->setControllerContext($this->controllerContext);
	}

	/**
	 * @test
	 * @expectedException \F3\FLOW3\MVC\Exception
	 * @author Bastian Waidelich <bastian@typo3.org>
	 */
	public function renderThrowsExceptionIfNoRequestIsAvailable() {
		$this->controllerContext->expects($this->atLeastOnce())->method('getRequest')->will($this->returnValue(NULL));

		$this->view->render();
	}

	/**
	 * @test
	 * @author Bastian Waidelich <bastian@typo3.org>
	 */
	public function renderReturnsContentOfTemplateAndReplacesBaseUriMarkerIfRequestIsWebRequest() {
		$mockRequest = $this->getMock('\F3\FLOW3\MVC\Web\Request', array('getBaseUri'));
		$mockRequest->expects($this->any())->method('getBaseUri')->will($this->returnValue('someBaseUri'));
		$this->controllerContext->expects($this->any())->method('getRequest')->will($this->returnValue($mockRequest));

		$templateContent = file_get_contents(FLOW3_PATH_FLOW3 . 'Resources/Private/MVC/StandardView_Template.html');
		$templateContent = str_replace('###BASEURI###', 'someBaseUri', $templateContent);

		$this->assertSame($templateContent, $this->view->render());
	}

	/**
	 * @test
	 * @author Bastian Waidelich <bastian@typo3.org>
	 */
	public function renderReturnsContentOfTemplateAndReplacesBaseUriMarkerIfRequestIsNoWebRequest() {
		$mockRequest = $this->getMock('\F3\FLOW3\MVC\RequestInterface');
		$mockRequest->expects($this->never())->method('getBaseUri');
		$this->controllerContext->expects($this->any())->method('getRequest')->will($this->returnValue($mockRequest));

		$templateContent = file_get_contents(FLOW3_PATH_FLOW3 . 'Resources/Private/MVC/StandardView_Template.html');

		$this->assertSame($templateContent, $this->view->render());
		$this->assertContains('###BASEURI###', $templateContent);
	}
}
?>