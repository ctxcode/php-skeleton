<?php

return new class {

    public function test($mysql, $pg) {

        $user = \Model\User::query($mysql)->find(1);
        $user->firstname = "TEST";
        $user->save();

        \Model\User::query($pg)->insert($user);

    }

};
