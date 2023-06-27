<?php

namespace App\Traits;


trait SocialMediaFormatAudit
{
    public function socialMediaFormatAudit(int $social_media, string $format_string)
    {
        $result = false;

        switch ($social_media) {
            case LINKEDIN:
                $parsed_string = $this->stringParser($format_string);

                if (str_contains($parsed_string[2], 'linkedin')) {
                    $result = true;
                }

                return $result;

            case WHATSAPP:
                $parsed_string = $this->stringParser($format_string);

                if (str_contains($parsed_string[2], 'whatsapp')) {
                    $result = true;
                }

                return $result;
            default:
                return true;
        }

    }

    private function stringParser(string $string)
    {
        $string_explode = explode('/', $string);

        return $string_explode;
    }
}
