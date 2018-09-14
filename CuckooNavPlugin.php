<?php
/**
 * Cuckoo Nav plugin for Craft CMS
 *
 * Simple nav variable to limit SQL queries
 *
 * @author    cole007
 * @copyright Copyright (c) 2018 cole007
 * @link      http://ournameismud.co.uk/
 * @package   CuckooNav
 * @since     0.0.1
 */

namespace Craft;

class CuckooNavPlugin extends BasePlugin
{
    /**
     * @return mixed
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @return mixed
     */
    public function getName()
    {
         return Craft::t('Cuckoo Nav');
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return Craft::t('Simple nav variable to limit SQL queries');
    }

    /**
     * @return string
     */
    public function getDocumentationUrl()
    {
        return 'https://github.com/ournameismud/cuckoonav/blob/master/README.md';
    }

    /**
     * @return string
     */
    public function getReleaseFeedUrl()
    {
        return 'https://raw.githubusercontent.com/ournameismud/cuckoonav/master/releases.json';
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return '0.0.1';
    }

    /**
     * @return string
     */
    public function getSchemaVersion()
    {
        return '0.0.1';
    }

    /**
     * @return string
     */
    public function getDeveloper()
    {
        return 'cole007';
    }

    /**
     * @return string
     */
    public function getDeveloperUrl()
    {
        return 'http://ournameismud.co.uk/';
    }

    /**
     * @return bool
     */
    public function hasCpSection()
    {
        return false;
    }

    /**
     */
    public function onBeforeInstall()
    {
    }

    /**
     */
    public function onAfterInstall()
    {
    }

    /**
     */
    public function onBeforeUninstall()
    {
    }

    /**
     */
    public function onAfterUninstall()
    {
    }
}