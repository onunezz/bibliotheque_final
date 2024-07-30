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

    public function rolesSelect($selectedRole)
    {
        $roles = RoleModel::getAllRoles();

        foreach ($roles as $role) {
            $selected = ($role['id_role'] == $selectedRole) ? 'selected' : '';
            echo '<option value="' . htmlspecialchars($role['id_role']) . '" ' . $selected . '>' . htmlspecialchars($role['description']) . '</option>';
        }
    }
}
