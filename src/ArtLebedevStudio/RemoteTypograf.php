<?php

namespace ArtLebedevStudio;

/**
 * PHP-implementation of ArtLebedevStudio.RemoteTypograf class (web-service client)
 *  
 * Copyright (c) Art. Lebedev Studio | http://www.artlebedev.ru/
 * 
 * Typograf homepage: http://typograf.artlebedev.ru/
 * Web-service address: http://typograf.artlebedev.ru/webservices/typograf.asmx
 * WSDL-description: http://typograf.artlebedev.ru/webservices/typograf.asmx?WSDL
 *  
 * Default charset: UTF-8
 * 
 * Version: 1.0 (August 30, 2005)
 * Author: Andrew Shitov (ash@design.ru)
 * 
 */

class RemoteTypograf
{
	private int $_entityType = 3;
	private int $_useBr = 0;
	private int $_useP = 0;
	private int $_maxNobr = 3;
	private string $_encoding = 'UTF-8';
	private string $_quotA = 'laquo raquo';
	private string $_quotB = 'bdquo ldquo';


	/**
	 * Set charset
	 * 
	 * @param string|null $encoding
	 */
	public function __construct(string $encoding = null)
	{
		$this->_encoding = empty($encoding) ? $this->_encoding : $encoding;
	}

	/**
	 * Выдавать символы буквенными кодами - &laquo;а&raquo;
	 * 
	 * @return void
	 */
	public function htmlEntities(): void
	{
		$this->_entityType = 1;
	}

	/**
	 * Выдавать символы числовыми кодами - &171;а&187;
	 * 
	 * @return void
	 */
	public function xmlEntities(): void
	{
		$this->_entityType = 2;
	}

	/**
	 * Выдавать символы буквенными и числовыми кодами - &laquo;а&raquo; и &171;а&187;
	 * 
	 * @return void
	 */
	public function mixedEntities(): void
	{
		$this->_entityType = 4;
	}

	/**
	 * Выдавать символы готовыми символами - «а»
	 * 
	 * @return void
	 */
	public function noEntities(): void
	{
		$this->_entityType = 3;
	}

	/**
	 * Ставить переносы строк
	 * 
	 * @param bool $value
	 * 
	 * @return void
	 */
	public function br(bool $value): void
	{
		$this->_useBr = $value ? 1 : 0;
	}

	/**
	 * Размечать параграфы
	 * 
	 * @param bool $value
	 * 
	 * @return void
	 */
	public function p(bool $value): void
	{
		$this->_useP = $value ? 1 : 0;
	}

	/**
	 * Максимальное количество тегов br
	 * 
	 * @param int $value 
	 * 
	 * @return void
	 */
	public function nobr(int $value): void
	{
		$this->_maxNobr = $value ? $value : 0;
	}

	/**
	 * Кавычки первого уровня
	 * 
	 * « »	laquo raquo - Французские (ёлочки)
	 * 
	 * „ “	bdquo ldquo - Немецкие (лапки)
	 * 
	 * " "	quot quot - Программистские
	 * 
	 * ‘ ’	lsquo rsquo - Английские одиночные
	 * 
	 * “ ”	ldquo rdquo - Английские двойные
	 * 
	 * ‚ ‘	sbquo lsquo
	 * 
	 * @param string $value
	 * 
	 * @return void
	 */
	public function quotA(string $value): void
	{
		$this->_quotA = $value;
	}


	/**
	 * Кавычки второго уровня
	 * 
	 * « »	laquo raquo - Французские (ёлочки)
	 * 
	 * „ “	bdquo ldquo - Немецкие (лапки)
	 * 
	 * " "	quot quot - Программистские
	 * 
	 * ‘ ’	lsquo rsquo - Английские одиночные
	 * 
	 * “ ”	ldquo rdquo - Английские двойные
	 * 
	 * ‚ ‘	sbquo lsquo
	 * 
	 * @param string $value
	 * 
	 * @return void
	 */
	public function quotB(string $value): void
	{
		$this->_quotB = $value;
	}

	/**
	 * @param string $text
	 * 
	 * @return string
	 */
	public function processText(string $text): string
	{
		$text = str_replace('&', '&amp;', $text);
		$text = str_replace('<', '&lt;', $text);
		$text = str_replace('>', '&gt;', $text);

		$client = new \SoapClient("http://typograf.artlebedev.ru/webservices/typograf.asmx?WSDL");

		$params = array(
			"text" => $text,
			"entityType" => $this->_entityType,
			"useBr" => $this->_useBr,
			"useP" => $this->_useP,
			"maxNobr" =>  $this->_maxNobr,
			"quotA" => $this->_quotA,
			"quotB" => $this->_quotB
		);

		$response = $client->ProcessText($params);

		$typografResponse = $response->ProcessTextResult;

		$typografResponse = str_replace('&amp;', '&', $typografResponse);
		$typografResponse = str_replace('&lt;', '<', $typografResponse);
		$typografResponse = str_replace('&gt;', '>', $typografResponse);

		return $typografResponse;
	}
}
