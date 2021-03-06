<?php
declare(ENCODING = 'utf-8');
namespace F3\FLOW3\Persistence\QOM;

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
 * Performs a logical conjunction of two other constraints.
 *
 * To satisfy the And constraint, a tuple must satisfy both constraint1 and
 * constraint2.
 *
 * @version $Id: LogicalAnd.php 3783 2010-01-28 15:53:37Z k-fish $
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @api
 * @scope prototype
 */
class LogicalAnd extends \F3\FLOW3\Persistence\QOM\Constraint {

	/**
	 * @var \F3\FLOW3\Persistence\QOM\Constraint
	 */
	protected $constraint1;

	/**
	 * @var \F3\FLOW3\Persistence\QOM\Constraint
	 */
	protected $constraint2;

	/**
	 *
	 * @param \F3\FLOW3\Persistence\QOM\Constraint $constraint1
	 * @param \F3\FLOW3\Persistence\QOM\Constraint $constraint2
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 */
	public function __construct(\F3\FLOW3\Persistence\QOM\Constraint $constraint1, \F3\FLOW3\Persistence\QOM\Constraint $constraint2) {
		$this->constraint1 = $constraint1;
		$this->constraint2 = $constraint2;
	}

	/**
	 * Gets the first constraint.
	 *
	 * @return \F3\FLOW3\Persistence\QOM\Constraint the constraint; non-null
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 * @api
	 */
	public function getConstraint1() {
		return $this->constraint1;
	}

	/**
	 * Gets the second constraint.
	 *
	 * @return \F3\FLOW3\Persistence\QOM\Constraint the constraint; non-null
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 * @api
	 */
	public function getConstraint2() {
		return $this->constraint2;
	}

}
?>