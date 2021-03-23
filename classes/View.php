<?php

use eftec\bladeone\BladeOne;

class View {

    public static function render($name, $data = []): string {

        $views = \Path::get('modules');
        $cache = \Path::get('cache') . '/blade';

        // https://github.com/EFTEC/BladeOne/blob/master/lib/BladeOne.php
        // BladeOne::MODE_AUTO (default),BladeOne::MODE_DEBUG,BladeOne::MODE_FAST,BladeOne::MODE_SLOW
        // MODE_DEBUG allows to pinpoint troubles.
        $blade = new BladeOne($views, $cache, \Env::isDebug() ? BladeOne::MODE_DEBUG : BladeOne::MODE_AUTO);

        return $blade->run($name, $data);
    }
}