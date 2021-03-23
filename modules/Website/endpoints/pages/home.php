<?php

return new class {

    public function run($req, $res) {

        $db = \DB::main();
        $user = $db->User->find(1);
        // $user = \Model\User::query($mysql)->find(1);
        $user->firstname = "TEST";
        $user->save();

        $pg = \DB::pg();
        $pg->User->insert($user);

        $html = \View::render('website.views.pages.home', ['message' => 'Hello world!']);
        return $res->html($html);
    }

};
