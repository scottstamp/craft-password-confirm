<?php
/**
 * PasswordConfirm plugin for Craft CMS 3.x
 *
 * PasswordConfirmPlugin
 *
 * @link      https://christopherdosin.me
 * @copyright Copyright (c) 2019 Christopher Dosin
 */

namespace christopherdosin\passwordconfirm;


use Craft;
use craft\base\Plugin;
use craft\elements\User;
use craft\events\ModelEvent;
use craft\services\Plugins;
use craft\events\PluginEvent;

use yii\base\Event;

/**
 * Class PasswordConfirm
 *
 * @author    Christopher Dosin
 * @package   PasswordConfirm
 * @since     1.0.0
 *
 */
class PasswordConfirm extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var PasswordConfirm
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );

        Event::on(User::class, User::EVENT_BEFORE_SAVE, function(ModelEvent $event) {
            if (Craft::$app->request->isSiteRequest) {

                $password = Craft::$app->request->getBodyParam('password');
                $passwordConfirm = Craft::$app->request->getBodyParam('passwordConfirm');

                if (isset($passwordConfirm) && strcmp($password, $passwordConfirm) !== 0) {

                    $event->sender->addErrors([
                        'password' => 'Passwords do not match.'
                    ]);
                    $event->isValid = false;

                }
            }
        });

        Craft::info(
            Craft::t(
                'password-confirm',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

}
