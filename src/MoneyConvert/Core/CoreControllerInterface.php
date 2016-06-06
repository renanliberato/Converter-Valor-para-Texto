<?php

namespace MoneyConvert\Core;

/**
 * @author Diego Brocanelli <contato@diegobrocanelli.com.br>
 */
interface CoreControllerInterface
{
    public function convert($group, $groupPoint = 0);
}
