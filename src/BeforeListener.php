<?php
namespace ivol;

interface BeforeListener extends Listener
{
    /**
     * @param ExecParams $params
     * @return ExecParams
     */
    public function before(ExecParams $params);
}