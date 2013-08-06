<?php
/*                                                                        *
 * This script is part of the TYPO3 project - inspiring people to share!  *
 *                                                                        *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by  *
 * the Free Software Foundation.                                          *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *
 * $Id: Tx_Formhandler_ErrorCheck_FileRequired.php 22614 2009-07-21 20:43:47Z fabien_u $
 *                                                                        */

/**
 * Validates that a file gets uploaded via specified upload field
 *
 * @author	Reinhard Führicht <rf@typoheads.at>
 * @package	Tx_Formhandler
 * @subpackage	ErrorChecks
 */
class Tx_Formhandler_ErrorCheck_FileRequired extends Tx_Formhandler_AbstractErrorCheck {

	/**
	 * Validates that a file gets uploaded via specified upload field
	 *
	 * @param array &$check The TypoScript settings for this error check
	 * @param string $name The field name
	 * @param array &$gp The current GET/POST parameters
	 * @return string The error string
	 */
	public function check(&$check,$name,&$gp) {
		$checkFailed = '';
		session_start();
		$found = false;
		foreach($_FILES as $sthg => &$files) {
			if(strlen($files['name'][$name]) > 0) {
				$found = true;
			}
		}
		if(!$found && count($_SESSION['formhandlerFiles'][$name]) == 0) {
			$checkFailed = $this->getCheckFailed($check);
		}
		return $checkFailed;
	}


}
?>