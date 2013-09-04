<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Leo Unglaub 2011
 * @author     Leo Unglaub <leo@leo-unglaub.net>
 * @package    registration_info_mailer
 * @license    LGPL
 * @filesource
 */


/**
 * Class registration_info_mailer
 *
 * @copyright	Leo Unglaub 2011
 * @author		Leo Unglaub <leo@leo-unglaub.net>
 * @author     David Maack <david.maack@arcor.de>
 * @package		registration_info_mailer
 * @license		LGPL
 */
class registration_info_mailer extends Controller
{
	/**
	 * must be static because the loadLanguageFile hook call the method
	 * without an instance. so we need a static property here ...
	 *
	 * @var array
	 */
	protected static $arrUserOptions = array();

	/**
	 * Load the database object
	 */
	protected function __construct()
	{
		parent::__construct();
		$this->import('Database');
		$this->getUserOptions();
	}
	
	/**
	 * send an email if a new user registrated on the contao installation
	 *
	 * @param int $intId
	 * @param array $arrData
	 * @return none
	 */
	public function sendRegistrationMail($intId, $arrData, $objModule)
	{

		global $objPage;

		
		// check if the registration mail sould be send
		if ($objModule->rim_active == 1)
		{
			// store the registration data
			self::$arrUserOptions = $arrData;

			// check if we have all needet data
			if (!strlen($objModule->rim_mailto) || !strlen($objModule->rim_mailtemplate))
			{
				$this->log('RIM: failed to send the registration mail. The module needs more email informations. Please check the module configuration.', 'registration_info_mailer sendRegistrationMail()', 'ERROR');
				return;
			}
			
			$objMail = new EmailTemplate($objModule->rim_mailtemplate, $arrData['language']);
			$objMail->send($objModule->rim_mailto);

			// log to tl_log if the user set the option
			if ($objModule->rim_do_syslog == 1)
			{
				$this->log('RIM: a registration info mail has been send. Check your email.log for more informations.', 'registration_info_mailer sendRegistrationMail()', 'GENERAL');
			}

			// done :) lets cleanup and get some food, maybe a big pizza
			unset($objMail);
		}
	}


	/**
	 * send an email if a user account is activated
	 *
	 * @global object $objPage
	 * @param $objUser
	 */
	public function sendActivationMail($objUser, $objModule)
	{

		// check if the registration mail sould be send
		if ($objModule->rim_act_active == 1)
		{

			// check if we have all needet data
			if (!strlen($objModule->rim_act_mailto) || !strlen($objModule->rim_act_mailtemplate))
			{
				$this->log('RIM: failed to send the activation mail. The module needs more email informations. Please check the module configuration.', 'registration_info_mailer sendActivationMail()', 'ERROR');
				return;
			}

			$objMail = new EmailTemplate($objModule->rim_act_mailtemplate, $arrData['language']);
			$objMail->send($objModule->rim_act_mailto);

			// log to tl_log if the user set the option
			if ($objModule->rim_act_do_syslog == 1)
			{
				$this->log('RIM: An activation info mail for the user ' . $objUser->id . ' has been send.', 'registration_info_mailer sendActivationMail()', 'GENERAL');
			}

			unset($objMail);
		}
	}


	/**
	 * replace the insert tags {{rim::%useroption%}} with the $arrData from the registration
	 *
	 * @param string $strTag
	 * @return mixed
	 */
	public function replaceRimInsertTags($strTag)
	{
		if (count(self::$arrUserOptions) === 0)
			return false;

		$arrTemp = explode('::', $strTag);

		// check if it's our rim insert tag
		if ($arrTemp[0] == 'rim' && isset(self::$arrUserOptions[$arrTemp[1]]))
		{
			return self::$arrUserOptions[$arrTemp[1]];
		}

		return false;
	}
		
	/**
	 * send the mail
	 */
    public function sendMemberMail($dc) {
	
		$objUser = $this->Database->prepare('SELECT * FROM tl_member WHERE id = ?')->executeUncached($dc->activeRecord->id);
		
		//send the mail is checkbox is set
		if ($objUser->rim_send_mail)
		{
			$intTemplateId = ($objUser->login) ? $objUser->rim_activate_mailtemplate : $objUser->rim_deactivate_mailtemplate;
			$objMail = new EmailTemplate($intTemplateId, $objUser->language);
			$objMail->send($dc->activeRecord->email);

		}
    }

	/**
	 * generate the "Help Wizard" with the values from tl_member
	 *
	 * @param string $strContent
	 * @param string $strTemplate
	 */
	public function generateHelpWizard($strContent, $strTemplate)
	{          
		if ($strContent == 'explain')
		{
			$this->Import('Database');
			$this->loadLanguageFile('tl_member');
			$arrFields = $this->Database->listFields('tl_member');
			$arrRemoveTags = array('id', 'tstamp', 'password', 'locked', 'session', 'dateAdded', 'currentLogin', 'lastLogin', 'activation', 'autologin', 'createdOn');

			// clean the array, not nessesary but maybe i add a filter later
			// edit: i told you i add a filter...and here he is ;)
			foreach ($arrFields as $value)
			{
				if (!in_array($value['name'], $arrRemoveTags))
				{
					$arrFieldsClean[] =  $value['name'];
				}
			}

			foreach ($arrFieldsClean as $v)
			{
				$GLOBALS['TL_LANG']['XPL']['rim_helper'][] = array
				(
					'{{rim::' . $v . '}}',
					'<strong>' . $GLOBALS['TL_LANG']['tl_member'][$v][0] . '</strong> - ' . $GLOBALS['TL_LANG']['tl_member'][$v][1]
				);
			}
		}
	}
	
	
	protected function getUserOptions()
	{
		// force all user options we have to the rim insert tags
		foreach ($this->Database->getFieldNames('tl_member') as $v)
		{
			// don't use empty here
			if ($objUser->$v != '')
			{
				self::$arrUserOptions[$v] = $objUser->$v;
			}
		}
	}
}
?>