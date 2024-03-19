<?php

namespace App\Utilities;

use App\Utilities\Helper\{
    Hashing,
    TimeDate
};

class Utilitie
{
    use Hashing;
    use TimeDate;
    use Informations;

    #region [Output debugging information.]
    /**
     *
     * This function is used to output debugging information to aid in troubleshooting and development.
     *
     * @param mixed $data The data to be debugged.
     * @param bool $continue Optional. Determines whether to continue execution after debugging. Defaults to false.
     *
     * @return void
     */
    public static function debug($data, $continue = false)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';

        if (!$continue) exit;
    }
    #endregion
}
