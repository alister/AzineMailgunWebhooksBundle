<?php
namespace Azine\EmailBundle\Services;

/**
 * Interface with methods required by the AzineEmailBundle to render the email-content in nice templates
 *
 * @author dominik
 */
interface TemplateProviderInterface {

	/**
	 * Add all styles and variables that are required to render the layout of the html-email-template
	 *
	 * @param string $template the twig template for the email to render (template id in standard-notation, without the ending ( .txt.twig) => "AcmeFooBundle:bar:default")
	 * @param array $contentVariables array with variables required to render the content in the email
	 * @return array of merged template- and content-vars. Variables in the supplied array will NOT be replaced by newly added ones.
	 */
	public function addTemplateVariablesFor($template, array $contentVariables);


	/**
	 * Add template blocks that refer to images encoded in the email to the supplied array.
	 * This function will be called AFTER the images have been embeded, so you can define vars that include embede images => e.g. see variable "cellSeparator" in class AzineTemplateProvider.
	 * @param string $template the twig template for the email to render (template id in standard-notation, without the ending ( .txt.twig) => "AcmeFooBundle:bar:default")
	 * @param array $vars
	 * @param string $emailLocale the locale to be used for translations for this single email
	 * @param boolean $forWebView
	 * @return array of merged template-vars. Variables in the supplied array WILL BE replaced by newly added ones, if the use the same key.
	 */
	public function addTemplateSnippetsWithImagesFor($template, array $vars, $emailLocale, $forWebView = false);

	/**
	 * Get the absolute filesystem path to the folder where  the template-images are stored.
	 */
	public function getTemplateImageDir();

	/**
	 * Check if an image that should be embeded into an email is stored in an "allowed_images_folder" see config.yml
	 * @param string the filesystem path to the file
	 */
	public function isFileAllowed($filePath);

	/**
	 * Get the filesystem-folder for the given key
	 * @param string $md5
	 * @return string the fs-folder | false
	 */
	public function getFolderFrom($key);


	/**
	 * Define for which emails you want to make the web-view available and for which not.
	 * @param string $template the template id in standard-notation, without the ending ( .txt.twig) => "AcmeFooBundle:bar:default"
	 * @return boolean
	 */
	public function saveWebViewFor($template);

	/**
	 * Get the id of the webViewToken. You only have to implement this method if your TemplateProvider
	 * doesn't extend the AzineTemplateProvider or if you wan't to change the ID from "azineEmailWebViewToken"
	 * to something else.
	 *
	 * This ID is used in the AzineEmailBundle::baseEmailLayout.html.twig to show a link to the web-view.
	 */
	public function getWebViewTokenId();

	/**
	 * Get the url-query-parameters for campaign identification.
	 * If you work with GoogleAnalytics take a look at this page: https://support.google.com/analytics/answer/1033867
	 *
	 * @param String $templateId (without ending) as key and params to render the template as value
	 * @param array $template parameters already loaded
	 * @return array of (string => string)
	 */
	public function getCampaignParamsFor($templateId, array $params = null);

}