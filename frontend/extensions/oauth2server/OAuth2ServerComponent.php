<?php
/**
 * @author      Alexander Stepanenko <alex.stepanenko@gmail.com>
 * @license     http://mit-license.org/
 */

Yii::setPathOfAlias('OAuth2', Yii::getPathOfAlias('ext.oauth2server.lib.OAuth2'));

class OAuth2ServerComponent extends CComponent {}