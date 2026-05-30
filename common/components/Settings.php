<?php

namespace common\components;
class Settings
{
    public static function errorText($errors, &$resultText = '')
    {
        if (is_array($errors)) {
            foreach ($errors as $index => $value) {
                if (!is_array($value)) {
                    if ($resultText) {

                        if (mb_strpos($resultText, $value) !== false) {
                            continue;
                        }

                        $resultText .= '<br />';
                    }
                    $resultText .= $value;

                } else {
                    self::errorText($value, $resultText);
                }
            }
        } else {
            if ($resultText) {
                $resultText .= '<br />';
            }
            $resultText .= $errors;

        }

        return $resultText;

    }
}