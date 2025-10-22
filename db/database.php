<?php
require_once __DIR__ . "/../src/user.php";
class UsersDB{
     private static $file = __DIR__ . '/../storage/users.json';

    public static function allUsers() {
        if (empty(self::$file)) {
            $users = [];
            $data = json_decode(file_get_contents(self::$file), true);
            foreach ($data as $dat) {
                $users[] = new User($dat['id'], $dat['nickname'], $dat['firstname'], $dat['lastname'], $dat['password']);
            }
            return $users;
        }
    else {
        return [];
    }
    }

    public static function addUser(User $user){
        $users = self::allUsers();
        if (count($users) > 0) {
            $all_id = array_map(function ($id) {
                return $id->getID();
            }, $users);
            $user->id = max($all_id) + 1;
        } else {
            $user->id = 1;
        }
        $users[] = $user;
        $data = array_map(function ($usr) {
            return $usr->createArray();
        }, $users);
        file_put_contents(self::$file, json_encode($data));
    }

    public static function getUserByNickname($username){
        $users = self::allUsers();
        foreach ($users as $user){
            if ($user -> getNickname() == $username){
                return $user;
            }
        }
        return null;
    }

    public static function getUserByID($id){
        $users = self::allUsers();
        foreach ($users as $user){
            if ($user -> getID() == $id){
                return $user;
            }
        }
        return null;
    }


    public static function deleteUser($username){
        $users = self::allUsers();
        foreach ($users as $user){
            if ($user -> getNickname() == $username){
                unset($user);

            }
        }
        return null;
    }
}
