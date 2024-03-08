<?php
namespace Ivy;

trait Cache {

    public static array $cache = array();

    public function cache(): static
    {
        self::$cache = $this->data;
        return $this;
    }

}