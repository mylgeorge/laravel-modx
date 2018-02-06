<?php
/*
 * This file is part of the Laravel-Modx package.
 *
 * (c) Giorgos Mylonas <mylgeorge@gmail.com>
 *
 */

namespace Modx;

require_once base_path().'/modx/config.core.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';

class ModxCMS extends \modX
{
}