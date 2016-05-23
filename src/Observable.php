<?php
namespace ivol;

interface Observable
{
    public function addObserver(Listener $observer);
    public function removeObserver(Listener $observer);
}