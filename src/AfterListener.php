<?php

namespace ivol;

interface AfterListener extends Listener
{
    /**
     * @param Result $result
     * @return Result
     */
    public function after(Result $result);
}