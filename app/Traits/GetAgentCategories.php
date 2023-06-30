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

    public function getBrowserType($agent)
    {
        $value = "";

        if ($agent->browser() == CHROME) {
            $value = CHROME;
        } elseif ($agent->browser() == SAFARI) {
            $value = SAFARI;
        } elseif ($agent->browser() == FIREFOX) {
            $value = FIREFOX;
        } else {
            $value = "OTHER";
        }

        return $value;
    }
}
