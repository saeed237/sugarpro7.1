<?php
/*********************************************************************************
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright (C) 2004-2013 SugarCRM Inc.  All rights reserved.
 ********************************************************************************/


/**
 * Class for parsing title from RSS feed, and keep default encoding (UTF-8)
 * Created: Sep 12, 2011
 */
class DashletRssFeedTitle {
	public $defaultEncoding = "UTF-8";
	public $readBytes = 8192;
	public $url;
	public $cut = 70;
	public $contents = "";
	public $title = "";
	public $endWith = "...";
	public $xmlEncoding = false;
	public $fileOpen = false;

	public function __construct($url) {
		$this->url = $url;
	}

	public function generateTitle() {
		if ($this->readFeed()) {
			$this->getTitle();
			if (!empty($this->title)) {
				$this->convertEncoding();
				$this->cutLength();
			}
		}
		return $this->title;
	}

	/**
	 * @todo use curl with waiting timeout instead of fopen
	 */
	public function readFeed() {
		if ($this->url) {
			$fileOpen = @fopen($this->url, 'r');
			if ($fileOpen) {
				$this->fileOpen = true;
				$this->contents = fread($fileOpen, $this->readBytes);
				fclose($fileOpen);
				return true;
			}
		}
		return false;
	}

	/**
	 *
	 */
	public function getTitle() {
		$matches = array ();
		preg_match("/<title>.*?<\/title>/i", $this->contents, $matches);
		if (isset($matches[0])) {
			$this->title = str_replace(array('<![CDATA[', '<title>', '</title>', ']]>'), '', $matches[0]);
		}
	}

	public function cutLength() {
		if (mb_strlen(trim($this->title), $this->defaultEncoding) > $this->cut) {
			$this->title = mb_substr($this->title, 0, $this->cut, $this->defaultEncoding) . $this->endWith;
		}
	}

	private function _identifyXmlEncoding() {
		$matches = array ();
		preg_match('/encoding\=*\".*?\"/', $this->contents, $matches);
		if (isset($matches[0])) {
			$this->xmlEncoding = trim(str_replace('encoding="', '"', $matches[0]), '"');
		}
	}

	public function convertEncoding() {
		$this->_identifyXmlEncoding();
		if ($this->xmlEncoding && $this->xmlEncoding != $this->defaultEncoding) {
			$this->title = iconv($this->xmlEncoding, $this->defaultEncoding, $this->title);
		}
	}
}