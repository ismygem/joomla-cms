<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_privacy
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Privacy\Administrator\View\Export;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\AbstractView;
use Joomla\Component\Privacy\Administrator\Helper\PrivacyHelper;
use Joomla\Component\Privacy\Administrator\Model\ExportModel;

/**
 * Export view class
 *
 * @since  3.9.0
 *
 * @property-read   \Joomla\CMS\Document\XmlDocument  $document
 */
class XmlView extends AbstractView
{
	/**
	 * Execute and display a template script.
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  mixed  A string if successful, otherwise an Error object.
	 *
	 * @since   3.9.0
	 * @throws  \Exception
	 */
	public function display($tpl = null)
	{
		/** @var ExportModel $model */
		$model = $this->getModel();

		$exportData = $model->collectDataForExportRequest();

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new \JViewGenericdataexception(implode("\n", $errors), 500);
		}

		$requestId = $model->getState($model->getName() . '.request_id');

		// This document should always be downloaded
		$this->document->setDownload(true);
		$this->document->setName('export-request-' . $requestId);

		echo PrivacyHelper::renderDataAsXml($exportData);
	}
}
