<?php

/**
 * 空白を空と判定させるクラス
 */
class IsNullorWhitespace
{
    public function is_nullorwhitespace($obj)
    {
        if (is_string($obj) && mb_ereg_match("^(\s|　)+$", $obj)) {
            return true;
        }

        return false;
    }
}
