<?php

namespace statuo\GoogleShoppingFeed\variables;

use craft\elements\db\ElementQuery;
use craft\web\View;

use Craft;
use statuo\GoogleShoppingFeed\GoogleShoppingFeed;
use yii\base\InvalidValueException;

class GoogleShoppingFeedVariable
{
    public function products(ElementQuery $query = null, array $fields = null)
    {
        if (!$query) {
            return false;
        }
        if (!$fields) {
            $fields = GoogleShoppingFeed::getInstance()->getSettings();
        }
        Craft::$app->view->setTemplateMode(View::TEMPLATE_MODE_CP);
        $headers = Craft::$app->response->headers;
        $headers->add('Content-Type', 'text/xml; charset=utf-8');
        $feed = Craft::$app->view->renderTemplate('google-shopping-feed/_products', [
            'products' => $query->all(),
            'settings' => $fields,
        ]);

        echo $feed;
        exit;
    }

    public function entries(ElementQuery $query = null, array $fields = null)
    {
        if ($fields) {
            if (!$this->_validateFields($fields)) {
                if (Craft::$app->getConfig()->general->devMode) {
                    throw new InvalidValueException('Field settings incorrect');
                } else {
                    return false;
                }
            }
        }
        if (!$query) {
            return false;
        }

        Craft::$app->view->setTemplateMode(View::TEMPLATE_MODE_CP);
        $headers = Craft::$app->response->headers;
        $headers->add('Content-Type', 'text/xml; charset=utf-8');
        $feed = Craft::$app->view->renderTemplate('google-shopping-feed/_entries', [
            'entries' => $query->all(),
            'settings' => $fields,
        ]);

        echo $feed;
        exit;
    }

    public function _validateFields($fields): bool
    {
        $isValid = true;
        if (!array_key_exists('title', $fields)) {
            $isValid = false;
        }
        if (!array_key_exists('title', $fields)) {
            $isValid = false;
        }
        if (!array_key_exists('id', $fields)) {
            $isValid = false;
        }
        if (!array_key_exists('description', $fields)) {
            $isValid = false;
        }
        if (!array_key_exists('image_link', $fields)) {
            $isValid = false;
        }
        if (!array_key_exists('brand', $fields)) {
            $isValid = false;
        }
        if (!array_key_exists('price', $fields)) {
            $isValid = false;
        }
        if (!array_key_exists('currency', $fields)) {
            $isValid = false;
        }
        return $isValid;
    }
}
