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
 * $Id: Tx_Formhandler_Finisher_Redirect.php 23289 2009-08-12 11:54:05Z reinhardfuehricht $
 *                                                                        */

/**
 * Sample implementation of a Finisher Class used by Formhandler redirecting to another page.
 * This class needs a parameter "redirect_page" to be set in TS.
 *
 * Sample configuration:
 *
 * <code>
 * finishers.4.class = Tx_Formhandler_Finisher_Default
 * finishers.4.config.redirectPage = 65
 * </code>
 *
 * @author	Reinhard Führicht <rf@typoheads.at>
 * @package	Tx_Formhandler
 * @subpackage	Finisher
 */
class Tx_Formhandler_Finisher_Redirect extends Tx_Formhandler_AbstractFinisher {




	/**
	 * The main method called by the controller
	 *
	 * @return array The probably modified GET/POST parameters
	 */
	public function process() {


		//read redirect page
		$emailRedirect = $this->settings['redirectPage'];

		$url = '';

		if(!isset($emailRedirect)) {
			return;
		}

		Tx_Formhandler_Staticfuncs::doRedirect($emailRedirect, $this->settings['correctRedirectUrl']);
		exit();
	}

	/**
	 * Method to set GET/POST for this class and load the configuration
	 *
	 * @param array The GET/POST values
	 * @param array The TypoScript configuration
	 * @return void
	 */
	public function loadConfig($gp,$tsConfig) {
		$this->gp = $gp;
		$this->settings = $tsConfig;
		$redirect = Tx_Formhandler_StaticFuncs::pi_getFFvalue($this->cObj->data['pi_flexform'], 'redirect_page', 'sMISC');
		if($redirect) {
			$this->settings['redirectPage'] = $redirect;
		}
	}

}
?>