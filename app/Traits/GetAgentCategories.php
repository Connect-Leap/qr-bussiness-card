<?php

namespace App\Traits;

trait GetAgentCategories
{
    public function getDeviceType($agent)
    {
        $value = "";

        if ($agent->isDesktop()) {
            $value = DESKTOP;
        } elseif ($agent->isMobile()) {
            $value = MOBILE;
        } elseif ($agent->isTablet()) {
            $value = TABLET;
        } else {
            $value = "OTHER";
        }

        return $value;
    }
}
