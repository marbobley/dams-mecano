<?php
namespace  Nora\EntitiesVisitorBundle;

final class VisitorCounter{

    public function incrementCounter(int $i) : int
    {
        $i++;
        return $i;
    }
}
