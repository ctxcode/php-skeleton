<?php

return new class {

    public function run($req, $res) {

        return $res->html("Le homepage!");
        // $user = \Model\User::query($mysql)->find(1);
        // $user->firstname = "TEST";
        // $user->save();

        // \Model\User::query($pg)->insert($user);

    }

};
