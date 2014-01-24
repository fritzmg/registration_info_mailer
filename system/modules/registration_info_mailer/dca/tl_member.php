<?php

/**
 * Contao Open Source CMS
 *
 * @copyright  Leo Unglaub 2011, MEN AT WORK 2014 
 * @package    registration_info_mailer
 * @license    GNU/LGPL 
 * @filesource
 */

$GLOBALS['TL_DCA']['tl_member']['palettes']['default'] = str_replace('login;', 'rim_send_mail,rim_activate_mailtemplate,rim_deactivate_mailtemplate,login;', $GLOBALS['TL_DCA']['tl_member']['palettes']['default']);
$GLOBALS['TL_DCA']['tl_member']['config']['onsubmit_callback'][] = array('registration_info_mailer', 'sendMemberMail');

/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_member']['fields']['rim_send_mail'] = array(
    'label'             => &$GLOBALS['TL_LANG']['tl_member']['rim_send_mail'],
    'exclude'           => true,
    'load_callback'     => array(array('RimHelper', 'reset_rim_send_mail')),
    'inputType'         => 'checkbox'
);

$GLOBALS['TL_DCA']['tl_member']['fields']['rim_activate_mailtemplate'] = array(
    'label'             => &$GLOBALS['TL_LANG']['tl_member']['rim_activate_mailtemplate'],
    'exclude'           => true,
    'inputType'         => 'select',
    'options_callback'  => array('RimHelper', 'getMailTeplates'),
    'explanation'       => 'RimHelper',
    'load_callback'     => array(array('RimHelper', 'setDefaultTemplate')),
    'eval'              => array('helpwizard'=>true, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_member']['fields']['rim_deactivate_mailtemplate'] = array(
    'label'             => &$GLOBALS['TL_LANG']['tl_member']['rim_deactivate_mailtemplate'],
    'exclude'           => true,
    'inputType'         => 'select',
    'options_callback'  => array('RimHelper', 'getMailTeplates'),
    'explanation'       => 'RimHelper',
    'load_callback'     => array(array('RimHelper', 'setDefaultTemplate')),
    'eval'              => array('helpwizard'=>true, 'tl_class'=>'w50')
);