<?php

    function xarayatesting_scans_modules_to_upgrade()
    {
        $data['items'] = xarMod::apiFunc('modules', 'admin', 'getlist', ['filter' => ['State' => xarMod::STATE_UPGRADED]]);
        xarTpl::setPageTemplateName('admin');
        return $data;
    }
