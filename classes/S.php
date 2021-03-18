<?php

class S {

    public static function string(...$args): \Struct\_String {
        return new \Struct\_String($args);
    }
    public static function int(...$args): \Struct\_Integer {
        return new \Struct\_Integer();
    }
    public static function bool(...$args): \Struct\_Boolean {
        return new \Struct\_Boolean();
    }
    public static function float(...$args): \Struct\_Float {
        return new \Struct\_Float();
    }
    public static function object(...$args): \Struct\_Object {
        return new \Struct\_Object($args);
    }
    public static function array(...$args): \Struct\_Array {
        return new \Struct\_Array($args);
    }

}