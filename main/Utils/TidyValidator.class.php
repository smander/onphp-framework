<?php
/***************************************************************************
 *   Copyright (C) 2007 by Sergey Skachkov                                 *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 *                                                                         *
 ***************************************************************************/
/* $Id$ */

	/**
	 * Small Tidy-based HTML validator.
	 * 
	 * @ingroup Utils
	**/
	final class TidyValidator
	{
		private $content		= null;
		private $validationErrors	= null;
		
		private $config			= array(
			'output-xhtml'	=> true,
			'doctype'	=> 'strict',
			'wrap'		=> 0,
			'quote-marks'	=> true,
			'drop-empty-paras'=> false
		);
		
		private $header			= '
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<title></title>
			</head>
			<body>';
		private $headerLines		= 7;
		
		private $encoding		= 'utf8';
	
		public static function create()
		{
			return new self;
		}

		/**
		 * Sets content to validate.
		 *
		 * For example: TidyValidator::create()->setContent('<b>blabla</b>');
		 * 
		 * @param $content content itself
		 * @return TidyValidator
		 */
		public function setContent($content)
		{
			$this->content = $content;
		
			return $this;
		}
	
		public function getContent()
		{
			return $this->content;
		}
		
		public function setValidationErrors($errors)
		{
			$this->validationErrors = $errors;
			
			return $this;
		}
		
		public function getValidationErrors()
		{
			return $this->validationErrors;
		}

		/**
		 * Sets configuration array for tidy. There is default config (see code).
		 *
		 * For example: TidyValidator::create()->setConfig('output-xhtml' => true);
		 * 
		 * @param $config array with tidy's configuration
		 * @return TidyValidator
		 */
		public function setConfig($config)
		{
			$this->config = $config;
			
			return $this;
		}
		
		public function getConfig()
		{
			return $this->config;
		}
		
		/**
		 * Sets header for content. There is default header (see code).
		 *
		 * @param $header header string
		 * @return TidyValidator
		 */
		public function setHeader($header)
		{
			$this->header = $header;
			$this->headerLines = count(explode("\n", $header));
			
			return $this;
		}
		
		public function getHeader()
		{
			return $this->header;
		}
		
		/**
		 * Sets encoding for content. There is default encoding 'utf8'.
		 *
		 * For example: TidyValidator::create()->setEncoding('utf8');
		 * 
		 * @param $encoding encoding name
		 * @return TidyValidator
		 */
		public function setEncoding($encoding)
		{
			$this->encoding = $encoding;
			
			return $this;
		}
		
		public function getEncoding()
		{
			return $this->encoding;
		}
		
		/**
		 * Do the content validation and repair it.
		 * 
		 * For example:
		 * 	$repairedContent = 
		 * 		TidyValidator::create()->
		 * 		setContent('<b>blablabla')->
		 * 		validateContent()->
		 * 		getContent();
		 * 
		 * Or just:
		 * 	$repairedContent = 
		 * 		TidyValidator::create()->
		 * 		validateContent('<b>blablabla')->
		 * 		getContent();
		 *
		 * @param $content content to validate
		 * @return TidyValidator
		 */
		public function validateContent($content = null)
		{
			if (isset($content)) {
				$this->setContent($content);
			} elseif (!$this->getContent()) {
				return $this;
			}
				
			$tidy = tidy_parse_string(
				$this->getHeader()."\n".$this->getContent()."\n</body></html>",
				$this->getConfig(),
				$this->getEncoding()
			);
			
			$pattern = array('/</','/>/');
			$replace = array('&lt;','&gt;');
			$errors = tidy_get_error_buffer($tidy);
			
			if (!empty($errors)) {
				$errorStrings = explode("\n", preg_replace($pattern, $replace, $errors));
				
				$out = '';
				foreach ($errorStrings as $str) {
					list($line, $num, $col, $rest) = explode(" ", $str, 4);
					$out = $out.($out == '' ? '' : "\n").'line '.($num-($this->headerLines)).' column '.$rest;
				}
				
				$tidy->cleanRepair();
				preg_match_all('/<body>(.*)<\/body>/s', $tidy, $outContent);
				$this->setContent($outContent[1][0]);
				$this->setValidationErrors($out);
			}
			
			return $this;
		}
	}
?>
