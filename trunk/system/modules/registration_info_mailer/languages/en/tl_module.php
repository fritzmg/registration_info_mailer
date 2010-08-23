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
 * @copyright  LU-Hosting 2010
 * @author     Leo Unglaub <leo@leo-unglaub.net>
 * @package    registration_info_mailer
 * @license    LGPL
 * @filesource
 */

// thanks to fLOSt. 
$GLOBALS['TL_LANG']['tl_module']['rim_active']			= array('activate', 'Select this checkbox to activate sending the registration info mail');
$GLOBALS['TL_LANG']['tl_module']['rim_mail_from']		= array('sender', 'E-Mail Senders adress (e.g.: noreply@foobar.com)');
$GLOBALS['TL_LANG']['tl_module']['rim_mail_from_name']	= array('senders name', 'senders name (e.g: Dont Answer Me)');
$GLOBALS['TL_LANG']['tl_module']['rim_subject']			= array('subject', 'subject of mail');
$GLOBALS['TL_LANG']['tl_module']['rim_mailto']			= array('recipients', 'Put here a list of recipients. e.g.: office@foobar.com,private@foobar.com');
$GLOBALS['TL_LANG']['tl_module']['rim_mailto_cc']		= array('CC-recipiants', 'Put here a list of CC-recipiants. e.g: office@foobar.com,private@foobar.com');
$GLOBALS['TL_LANG']['tl_module']['rim_mailto_bcc']		= array('BCC-recipiants', 'Put here a list of BCC-recipiants. e.g.: office@foobar.com,private@foobar.com');
$GLOBALS['TL_LANG']['tl_module']['rim_mailtext']		= array('Mailtext', 'This text will be send via email. There are all standard-insert-tags avalible and also all userattributes. For help see the help wizard.');

$GLOBALS['TL_LANG']['tl_module']['rim_legend']			= 'Registration Info Mailer';
?>