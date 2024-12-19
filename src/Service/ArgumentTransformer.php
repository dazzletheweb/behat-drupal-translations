<?php

namespace Dazzle\DrupalTranslations\Service;

use Behat\Behat\Definition\Call\DefinitionCall;
use Behat\Behat\Transformation\Transformer\ArgumentTransformer as ArgumentTransformerInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;

class ArgumentTransformer implements ArgumentTransformerInterface {

    /**
     * @var \Behat\Mink\Mink
     */
    protected $mink;

    public function __construct($mink) {
        $this->mink = $mink;
    }

    /**
     * @inheritDoc
     */
    public function supportsDefinitionAndArgument(DefinitionCall $definitionCall, $argumentIndex, $argumentValue) {
        return is_string($argumentValue) && substr($argumentValue, -2) === '|t';
    }

    /**
     * @inheritDoc
     */
    public function transformArgument(DefinitionCall $definitionCall, $argumentIndex, $argumentValue) {
        $argumentValue = substr($argumentValue, 0, -2);
        $session = $this->mink->getSession();
        try {
            $url = $session->getCurrentUrl();
        }
        catch (\Exception $e) {
            return $argumentValue;
        }

        $arguments = [];
        $parts = explode('|', $argumentValue);
        $translation_context = '';
        if ($parts[0] && $context = explode('#', $parts[0])) {
            $parts[0] = $context[0];
            $translation_context = $context[1] ?? '';
        }
        if (count($parts) > 1) {
            $matches = [];
            if (preg_match_all('/(@|%)\w+/', $parts[0], $matches)) {
                $argumentValue = array_shift($parts);
                $arguments = array_combine($matches[0], $parts);
            }
            else {
                throw new \Exception('Could not detect parameters.');
            }
        }
        else {
            $argumentValue = $parts[0];
        }

        $langcode = \Drupal::languageManager()->getCurrentLanguage()->getId();

        // Try to get the language from the URL.
        $url = explode('/', trim($url, '/'));
        $langcode_from_url = $url[3] ?? NULL;
        if ($langcode_from_url) {
            $lang_exists = \Drupal::languageManager()->getLanguage($langcode_from_url);
            if ($lang_exists && is_object($lang_exists)) {
                $langcode = $langcode_from_url;
            }
        }

        $string = new TranslatableMarkup($argumentValue, $arguments, ['langcode' => $langcode, 'context' => $translation_context]);
        $string = $string->render();
        $string = strip_tags($string);

        return $string;
    }

}
