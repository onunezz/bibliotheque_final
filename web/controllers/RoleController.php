<?php

class RoleController
{
    static public function allRolesSelect()
    {
        $roles = RoleModel::getAllRoles();

        foreach ($roles as $role) {
            echo '<option value="' . htmlspecialchars($role['id_role']) . '">' . htmlspecialchars($role['description']) . '</option>';
        }
    }
}
