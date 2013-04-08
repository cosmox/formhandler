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
 * $Id: Tx_Formhandler_Finisher_StoreGP.php 22614 2009-07-21 20:43:47Z fabien_u $
 *                                                                        */

/**
 * This finisher stores GP to session for further use in other plugins and update $_SESSION 
 * to not loose changes in gp made by other finishers (e.g. insert_id from Finisher_DB)
 * Automaically called if plugin.Tx_Formhandler.settings.predef.example.storeGP = 1 is set
 * No further configuration.
 *
 * @author Johannes Feustel
 * @package	Tx_Formhandler
 * @subpackage	Finisher
 */
class Tx_Formhandler_Finisher_StoreGP extends Tx_Formhandler_AbstractFinisher {

	/**
	 * The main method called by the controller
	 *
	 * @return array The probably modified GET/POST parameters
	 */
	public function process() {

		//store in Session for further use by other plugins
		$this->storeUserGPinSession();

		//update $_SESSION['formhandlerValues']
		$this->updateSession();

		return $this->gp;
	}

	/**
	 * Stores the GP in session.
	 *
	 * @return void
	 */
	protected function storeUserGPinSession() {
		foreach ($this->gp as $key => $value) {
			$GLOBALS['TSFE']->fe_user->setKey('ses', $key, $value);
		}
	}

	/**
	 * Stores $this->gp parameters in SESSION
	 * actually only needed for finisher_confirmation
	 *
	 * @return void
	 */
	protected function updateSession() {
		session_start();

		//reset session
		unset($_SESSION['formhandlerValues']);

		//set the variables in session
		//no need to seperate steps in finishers, so simply store to step 1
		foreach($this->gp as $key => $value) {
			$_SESSION['formhandlerValues'][1][$key] = $value;
		}
	}

}
?>