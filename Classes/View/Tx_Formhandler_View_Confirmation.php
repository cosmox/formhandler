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
 * $Id: Tx_Formhandler_View_Confirmation.php 24857 2009-09-28 09:36:08Z reinhardfuehricht $
 *                                                                        */

/**
 * A view for Finisher_Confirmation used by Formhandler
 *
 * @author	Reinhard Führicht <rf@typoheads.at>
 * @package	Tx_Formhandler
 * @subpackage	View
 */
class Tx_Formhandler_View_Confirmation extends Tx_Formhandler_View_Form {

	/**
	 * This function fills the default markers:
	 *
	 * ###PRINT_LINK###
	 * ###PDF_LINK###
	 * ###CSV_LINK###
	 *
	 * @return string Template with replaced markers
	 */
	protected function fillDefaultMarkers() {
		parent::fillDefaultMarkers();
		if($this->settings['formValuesPrefix']) {
			$params[$this->settings['formValuesPrefix']] = $this->gp;
		} else {
			$params = $this->gp;
		}
		$params['type'] = 98;
		$label = trim($GLOBALS['TSFE']->sL('LLL:' . $this->langFile . ':print'));
		if(strlen($label) == 0) {
			$label = 'print';
		}
		$markers['###PRINT_LINK###'] = $this->cObj->getTypolink($label, $GLOBALS['TSFE']->id, $params);
		unset($params['type']);
		
		if($this->settings['actions.']) {
			foreach($this->settings['actions.'] as $action=>$options) {
				$sanitizedAction = str_replace('.', '', $action);
				$class = $options['class'];
				if($class) {
					$class = Tx_Formhandler_StaticFuncs::prepareClassName($class);
					$generator = $this->componentManager->getComponent($class);
					$generator->init($this->gp, $options['config.']);
					$markers['###' . strtoupper($sanitizedAction) . '_LINK###'] = $generator->getLink($params);
				}
			}
		}
		
		$this->fillFEUserMarkers($markers);
		$this->fillFileMarkers($markers);
		$this->template = $this->cObj->substituteMarkerArray($this->template, $markers);
	}
}
?>