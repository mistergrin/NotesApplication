<?php
require_once __DIR__ . "/../src/user.php";

/**
 * Class UsersDB
 *
 * Provides a simple file-based storage for User entities.
 * Users are stored in a JSON file and loaded into User objects.
 */

class UsersDB{

    /**
     * Path to the JSON file used as storage.
     *
     * @var string
     */
     private static $file = __DIR__ . '/../storage/users.json';

     /**
     * Retrieve all users from storage.
     *
     * @return User[] List of all users
     */
    public function allUsers() {
        if (!empty(self::$file)) {
            $users = [];
            $data = json_decode(file_get_contents(self::$file), true) ?: [];
            foreach ($data as $dat) {
                $users[] = new User($dat['id'], $dat['nickname'], $dat['firstname'], $dat['lastname'], $dat['password'], $dat['role']);
            }
            return $users;
        }
        return  [];
    }


     /**
     * Retrieve users with pagination and sorting.
     *
     * Users are sorted alphabetically by nickname.
     *
     * @param int $page  Page number (starting from 1)
     * @param int $limit Number of users per page
     *
     * @return array{
     *     users: User[],
     *     total: int,
     *     page: int,
     *     pages: int
     * }
     */

    public function get_all_users_paginated($page, $limit){
        $users = self::allUsers();

        $page = intval($page);
        $limit = intval($limit);

        usort($users, function($a, $b) {
            return strcasecmp($a->getNickname(), $b->getNickname());
        });


        $start = ($page - 1) * $limit;
        $paginated_users = array_slice($users, $start, $limit);
        $total = count($users);

        return  ['users' => $paginated_users, 'total' => $total, 'page' => $page, 'pages' => ceil($total / $limit)];

    }



      /**
     * Add a new user to storage.
     *
     * Automatically assigns a unique ID to the user.
     *
     * @param User $user User to add
     *
     * @return void
     */

    public function addUser(User $user){
        $users = self::allUsers();
        if (count($users) > 0) {
            $all_id = array_map(function ($id) {
                return $id->getID();
            }, $users);
            $user->setUserId(max($all_id) + 1);
        } else {
            $user->setUserId(1);
        }
        $users[] = $user;
        $data = array_map(function ($usr) {
            return $usr->createArray();
        }, $users);
        file_put_contents(self::$file, json_encode($data, JSON_PRETTY_PRINT));
    }

    /**
     * Find a user by nickname.
     *
     * @param string $username User nickname
     *
     * @return User|null User object if found, null otherwise
     */

    public function getUserByNickname($username){
        $users = self::allUsers();
        foreach ($users as $user){
            if ($user -> getNickname() == $username){
                return $user;
            }
        }
        return null;
    }

     /**
     * Find a user by ID.
     *
     * @param int $id User ID
     *
     * @return User|null User object if found, null otherwise
     */

    public function getUserByID($id){
        $users = self::allUsers();
        foreach ($users as $user){
            if ($user -> getID() == $id){
                return $user;
            }
        }
        return null;
    }

    /**
     * Update an existing user.
     *
     * @param User $updated_user Updated user object
     *
     * @return void
     */

    public function updateUser($updated_user)
    {
        $users = self::allUsers();
        foreach ($users as $index => $user){
            if ($user -> getID() == $updated_user -> getID()){
                $users[$index] = $updated_user;
                break;
            }
        }
        $data = array_map(function($usr){
            return $usr->createArray();
        }, $users);

        file_put_contents(self::$file, json_encode($data, JSON_PRETTY_PRINT));
    }


    /**
     * Delete a user by ID.
     *
     * @param int $id User ID
     *
     * @return void
     */

    public function deleteUser($id){
        $users = self::allUsers();

        foreach ($users as $i => $current_user) {
            if ($current_user->getID() == $id) {
                unset($users[$i]);
                break;
            }
        }
        $data = array_map(function($usr) {
            return $usr->createArray();
        }, $users);

        file_put_contents(self::$file, json_encode($data, JSON_PRETTY_PRINT));
    }

    /**
     * Upgrade a user's role to ADMIN.
     *
     * @param int $id User ID
     *
     * @return void
     */

    public function upgradeUserRole($id){
        $users = self::allUsers();

        foreach ($users as $index => $user){
            if ($user->getID() == $id){
                $user->setRole("ADMIN");
                $users[$index] = $user;
                break;
            }
        }
        $data = array_map(function($user){
            return $user->createArray();
        }, $users);
        file_put_contents(self::$file, json_encode($data, JSON_PRETTY_PRINT));
    }
}
