<?php
namespace ivol;

class ExecutionWrapper implements Observable
{
    /** @var array */
    private $observers = array();

    /**
     * @param string $command Sprintf formatted string @see http://php.net/manual/en/function.sprintf.php
     * @param array $params
     */
    public function exec($command, $params)
    {

        $execParams = $this->notifyBefore(new ExecParams($command, $params));
        exec($execParams->getFullCommand(), $output, $returnValue);
        $result = new Result($returnValue, $output);
        return $this->notifyAfter($result);
    }

    public function addObserver(Listener $observer)
    {
        $this->observers[] = $observer;
    }

    public function removeObserver(Listener $observer)
    {
        foreach ($this->observers as $key => $internalObserver) {
            if ($internalObserver == $observer) {
                unset($this->observers[$key]);
            }
        }
    }

    /**
     * @param ExecParams $execParams
     * @return ExecParams
     */
    private function notifyBefore(ExecParams $execParams)
    {
        foreach ($this->observers as $observer) {
            if ($observer instanceof BeforeListener) {
                $execParams = $observer->before($execParams);
            }
        }
        return $execParams;
    }

    private function notifyAfter(Result $result)
    {
        foreach ($this->observers as $observer) {
            if ($observer instanceof AfterListener) {
                $result = $observer->after($result);
            }
        }
        return $result;
    }
}