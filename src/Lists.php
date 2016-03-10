<?php
/**
 * Created by: gellu
 * Date: 13.09.2013 13:52
 * Modified: 25.09.2014 15:26 AEST By: Synergi
 */

$app->group('/lists', function() use ($app, $db) {

    $app->get('/add', function() use ($app, $db) {

        $get = $app->request->get();

        if(!$get['name'] )
        {
            echo json_encode(array('status' => 'error', 'result' => 'Some parameters are missing'));
            $app->stop();
        }

        //get app_key
        $sth = $db->prepare('SELECT id FROM apps WHERE app_key = :app_key');
        $sth->execute(array('app_key' => $app->request()->get('app_key')));
        $app = $sth->fetchAll(PDO::FETCH_ASSOC);

        //check if this list already exists
        $sth = $db->prepare('SELECT * FROM lists WHERE name = :name');
        $sth->execute(array('name' => $get['name']));
        $res = $sth->fetchAll(PDO::FETCH_ASSOC);

        //don't add new list, just return existed
        if(count($res) > 0)
        {
            echo json_encode(array('status' => 'ok', 'result' => $res[0]['id']));
            $app->stop();
        }

        $sth = $db->prepare('INSERT INTO lists SET name = :name, app = :app');

        $sth->execute(array(
                        'name' => $get['name'],
                        'app'  => $app[0]['id'],
                        ));

        echo json_encode(array('status' => 'ok', 'result' => $db->lastInsertId()));

    });

    $app->get('/get', function() use ($app, $db) {

        if(!$app->request()->get('name'))
        {
            echo json_encode(array('status' => 'error', 'result' => 'Parameter [name] is missing'));
            $app->stop();
        }

        $sth = $db->prepare('SELECT * FROM lists WHERE name LIKE :name');
        $sth->execute(array('name' => '%' . $app->request()->get('name') .'%'));
        $res = $sth->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(array('status' => 'ok', 'result' => $res));

    });

    $app->get('/show', function() use ($app, $db) {

        //get app_key
        $sth = $db->prepare('SELECT id FROM apps WHERE app_key = :app_key');
        $sth->execute(array('app_key' => $app->request()->get('app_key')));
        $app = $sth->fetchAll(PDO::FETCH_ASSOC);

        //Get lists
        $sth = $db->prepare('SELECT * FROM lists WHERE app = :id');
        $sth->execute(array('id' => $app[0]['id']));
        $res = $sth->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(array('status' => 'ok', 'result' => $res));

    });

});