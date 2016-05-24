exec-wrapper
============

[![Build Status](https://travis-ci.org/ivol84/exec_wrapper.svg?branch=master)](https://travis-ci.org/ivol84/exec_wrapper)

Execution wrapper is extension implements execution of external application in OOP way. Also allows to add listener before and after execution.

Installation
------------
**Will be added soon**

Usage
-----
It is really simple:
```
<php>
// Autoload here
use ivol/ExecutionWrapper;

$wrapper = new ExecutionWrapper();
$result = $wrapper->execute('echo %s', ['123']);
if ($result->getReturnCode() == 0) {
    echo('Success');
} else {
    echo('Failure');
}
echo($result->getOutput());
</php>
```
If you want to use Event System then you should configure event dispatcher:
```
...
$dispatcher = $wrapper->getEventDispatcher();
$dispatcher->addSubscriber(...);
$dispatcher->addListener(...);
...
```
For more information about event dispatcher see [The EventDispatcher Component](http://symfony.com/doc/3.0/components/event_dispatcher/introduction.html).

For additional examples see [ExecutionWrapperIntegrationTest](https://github.com/ivol84/exec_wrapper/blob/master/test/src/ExecutionWrapperIntegrationTest.php).

Configuration:
-------
You can configure behaviour of args and command escaping by passing config array to ExecWrapper.

For configuration option names please see [ExecWrapperConfiguration](https://github.com/ivol84/exec_wrapper/blob/master/src/Config/ExecWrapperConfiguration.php).

License
-------

exec-wrapper is released under the MIT License.
