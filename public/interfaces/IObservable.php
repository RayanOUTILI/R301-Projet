<?php

interface IObservable
{
    public function attach(IObserver $observer);
    public function detach(IObserver $observer);
    public function notify(string $action);
    
}

?>