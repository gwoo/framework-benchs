<?php
declare(ENCODING = 'utf-8');
namespace F3\FLOW3\SignalSlot;

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
 * Testcase for the Signal Aspect
 *
 * @version $Id: SignalAspectTest.php 2813 2009-07-16 14:02:34Z k-fish $
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class SignalAspectTest extends \F3\Testing\BaseTestCase {

	/**
	 * @test
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function forwardSignalToDispatcherForwardsTheSignalsMethodArgumentsToTheDispatcher() {
		$mockJoinPoint = $this->getMock('F3\FLOW3\AOP\JoinPoint', array(), array(), '', FALSE);
		$mockJoinPoint->expects($this->any())->method('getClassName')->will($this->returnValue('SampleClass'));
		$mockJoinPoint->expects($this->any())->method('getMethodName')->will($this->returnValue('emitSignal'));
		$mockJoinPoint->expects($this->any())->method('getMethodArguments')->will($this->returnValue(array('arg1' => 'val1', 'arg2' => array('val2'))));

		$mockDispatcher = $this->getMock('F3\FLOW3\SignalSlot\Dispatcher');
		$mockDispatcher->expects($this->once())->method('dispatch')->with('SampleClass', 'emitSignal', array('arg1' => 'val1', 'arg2' => array('val2')));

		$aspect = new \F3\FLOW3\SignalSlot\SignalAspect();
		$aspect->injectDispatcher($mockDispatcher);
		$aspect->forwardSignalToDispatcher($mockJoinPoint);
	}
}
?>