<?php

namespace Ivy;

trait Stash
{

    public static array $stash = array();

    public function stash(): static
    {
        self::$stash = $this->rows;
        return $this;
    }

}