<?php
declare(ENCODING = 'utf-8');
namespace F3\FLOW3\Validation\Validator;

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
 * Validator to chain many validators in a disjunction (logical or). So only one
 * validator has to be valid, to make the whole disjunction valid. Errors are
 * only returned if all validators failed.
 *
 * @version $Id: DisjunctionValidator.php 3345 2009-10-22 17:22:44Z k-fish $
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @api
 * @scope prototype
 */
class DisjunctionValidator extends \F3\FLOW3\Validation\Validator\AbstractCompositeValidator {
	/**
	 * Checks if the given value is valid according to the validators of the conjunction.
	 *
	 * If at least one error occurred, the result is FALSE.
	 *
	 * @param mixed $value The value that should be validated
	 * @return boolean TRUE if the value is valid, FALSE if an error occured
	 * @author Robert Lemke <robert@typo3.org>
	 * @author Christopher Hlubek <hlubek@networkteam.com>
	 * @api
	 */
	public function isValid($value) {
		$result = FALSE;
		foreach ($this->validators as $validator) {
			if ($validator->isValid($value) === FALSE) {
				$this->errors = array_merge($this->errors, $validator->getErrors());
			} else {
				$result = TRUE;
			}
		}
		if ($result === TRUE) {
			$this->errors = array();
		}
		return $result;
	}
}

?>