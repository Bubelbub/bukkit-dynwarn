<?php

/**
 * The translator for multiple language support
 *
 * @author Bubelbub <bubelbub@gmail.com>
 */
class Translator
{

	/**
	 *
	 * @var string the language shortcut of this translator
	 */
	private $language;

	/**
	 * @var string[] the translations for the specified $language
	 */
	private $translations;

	/**
	 * Creates the translator, load the files
	 * 
	 * @param string|integer $id the id or guid of the user
	 * @param string $name the name of the user
	 */
	public function __construct($language = null)
	{
		if ($language == null && defined('CP_LANGUAGE'))
		{
			$language = CP_LANGUAGE;
		}
		$this->setLanguage($language);
	}

	/**
	 * Sets the language of this translator
	 * 
	 * @param type $language the language shotcut
	 * @throws Exception if the translations file does not exists
	 */
	public function setLanguage($language)
	{
		if (!file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'translations' . DIRECTORY_SEPARATOR . $language . '.ini'))
		{
			throw new Exception('404 - Translation ' . $language . ' not found in ' . __DIR__ . DIRECTORY_SEPARATOR . 'translations');
		}
		$this->language = $language;
		$this->loadTranslations();
	}

	/**
	 * 
	 * @return string the shortcut of the translator 
	 */
	public function getLanguage()
	{
		return $this->language;
	}

	/**
	 * Load the translation file
	 */
	public function loadTranslations()
	{
		$this->translations = parse_ini_file(__DIR__ . DIRECTORY_SEPARATOR . 'translations' . DIRECTORY_SEPARATOR . $this->getLanguage() . '.ini');
	}

	public function trans($key)
	{
		if (!array_key_exists($key, $this->translations))
		{
			throw new Exception('Could not found translation for "' . $key . '" in ' . __DIR__ . DIRECTORY_SEPARATOR . 'translations' . DIRECTORY_SEPARATOR . $this->getLanguage() . '.ini');
		}
		return $this->translations[$key];
	}

}
