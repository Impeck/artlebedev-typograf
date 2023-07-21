<?php

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
 * Version: 2.0.0 (July 21, 2023)
 * @author: Andrew Shitov (ash@design.ru)
 * @author: Ilya Rozhkov (impeck@ya.ru)
 *
 */

namespace ArtLebedevStudio;

use SoapClient;
use SoapFault;

/**
 * Class RemoteTypograf
 */
class RemoteTypograf
{

    /**
     * @var int Entity type constant for HTML entities
     */
    private const ENTITY_TYPE_HTML = 1;

    /**
     * @var int Entity type constant for XML entities  
     */
    private const ENTITY_TYPE_XML = 2;

    /**
     * @var int Entity type constant for no entities
     */
    private const ENTITY_TYPE_NONE = 3;

    /**
     * @var int Entity type constant for mixed entities
     */
    private const ENTITY_TYPE_MIXED = 4;

    /**
     * @var int Default entity type
     */
    private int $entityType = self::ENTITY_TYPE_NONE;

    /**
     * @var int Whether to use <br> tags
     */
    private int $useBr = 0;

    /**
     * @var int Whether to use <p> tags
     */
    private int $useP = 0;

    /**
     * @var int Maximum number of nobr tags
     */
    private int $maxNobr = 3;

    /**
     * @var string Quote style A
     */
    private string $quotA = 'laquo raquo';

    /**
     * @var string Quote style B
     */
    private string $quotB = 'bdquo ldquo';

    /**
     * @var \SoapClient SOAP client instance
     */
    private SoapClient $soapClient;

    /**
     * Constructor
     *
     * Initializes SOAP client
     */
    public function __construct()
    {
        $this->soapClient = new SoapClient('http://typograf.artlebedev.ru/webservices/typograf.asmx?WSDL');
    }

    /**
     * Set entity type to HTML entities
     *
     * @return void
     */
    public function htmlEntities(): void
    {
        $this->entityType = self::ENTITY_TYPE_HTML;
    }

    /**
     * Set entity type to XML entities
     *
     * @return void
     */
    public function xmlEntities(): void
    {
        $this->entityType = self::ENTITY_TYPE_XML;
    }

    /**
     * Set entity type to no entities
     *
     * @return void
     */
    public function noEntities(): void
    {
        $this->entityType = self::ENTITY_TYPE_NONE;
    }

    /**
     * Set entity type to mixed entities
     *
     * @return void
     */
    public function mixedEntities(): void
    {
        $this->entityType = self::ENTITY_TYPE_MIXED;
    }

    /**
     * Enable/disable <br> tags
     *
     * @param bool $value Whether to use <br> tags  
     *
     * @return void
     */
    public function br(bool $value): void
    {
        $this->useBr = $value ? 1 : 0;
    }

    /**
     * Enable/disable <p> tags
     *
     * @param bool $value Whether to use <p> tags
     *
     * @return void
     */
    public function p(bool $value): void
    {
        $this->useP = $value ? 1 : 0;
    }

    /**
     * Set maximum number of nobr tags
     *
     * @param int $value Maximum nobr tags
     *
     * @return void
     */
    public function nobr(int $value): void
    {
        $this->maxNobr = $value ?: 0;
    }

    /**
     * Set quote style A
     * 	
     * « »	laquo raquo - French (herringbones)
     * 
     * „ “	bdquo ldquo - German (paws)
     * 
     * " "	quot quot - Programming
     * 
     * ‘ ’	lsquo rsquo - English singles
     * 
     * “ ”	ldquo rdquo - English doubles
     * 
     * ‚ ‘	sbquo lsquo
     *
     * @param string $value Quote style A
     *
     * @return void
     */
    public function quotA(string $value): void
    {
        $this->quotA = $value;
    }

    /**
     * Set quote style B
     *
     * « »	laquo raquo - French (herringbones)
     * 
     * „ “	bdquo ldquo - German (paws)
     * 
     * " "	quot quot - Programming
     * 
     * ‘ ’	lsquo rsquo - English singles
     * 
     * “ ”	ldquo rdquo - English doubles
     * 
     * ‚ ‘	sbquo lsquo
     * 
     * @param string $value Quote style B
     *
     * @return void
     */
    public function quotB(string $value): void
    {
        $this->quotB = $value;
    }

    /**
     * Process text with Typograf web service
     *
     * @param string $text Text to process
     *
     * @return string Processed text
     *
     * @throws \Exception If SOAP call fails
     */
    public function processText(string $text): string
    {
        $text = str_replace(['&', '<', '>'], ['&amp;', '&lt;', '&gt;'], $text);

        try {
            $result = $this->soapClient->ProcessText([
                'text' => $text,
                'entityType' => $this->entityType,
                'useBr' => $this->useBr,
                'useP' => $this->useP,
                'maxNobr' => $this->maxNobr,
                'quotA' => $this->quotA,
                'quotB' => $this->quotB
            ])->ProcessTextResult;
        } catch (SoapFault $e) {
            throw new \Exception('Error calling web service: ' . $e->getMessage());
        }

        return str_replace(['&amp;', '&lt;', '&gt;'], ['&', '<', '>'], $result);
    }
}
