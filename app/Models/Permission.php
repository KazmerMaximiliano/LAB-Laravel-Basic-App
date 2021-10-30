<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    public static $scopes = [];

    public static function permissionCan(array $scopes)
    {
        static::$scopes = $scopes;
    }

    public static function permissions()
    {
        return collect(static::$scopes)->map(function ($description, $permission) {
            return [
                'permission' => $permission,
                'description' => $description
            ];
        });
    }

    public static function permissionExcept($params)
    {
        $permissionsString = [
            'permissions' => '',
            'descriptions' => ''
        ];
        $permissions = static::permissions();
        $permissionsFilter = $permissions->whereNotIn('permission', explode(' ', $params));

        foreach ($permissionsFilter as $per) {
            $permissionsString['permissions'] = $permissionsString['permissions'] . $per['permission'] . ' ';
            $permissionsString['descriptions'] = $permissionsString['descriptions'] . $per['description'] . ', ';
        }

        return $permissionsString;
    }

    public static function permissionOnly($params)
    {
        $permissionsString = [
            'permissions' => '',
            'descriptions' => ''
        ];
        $permissions = static::permissions();
        $permissionsFilter = $permissions->whereIn('permission', explode(' ', $params));

        foreach ($permissionsFilter as $per) {
            $permissionsString['permissions'] = $permissionsString['permissions'] . $per['permission'] . ' ';
            $permissionsString['descriptions'] = $permissionsString['descriptions'] . $per['description'] . ', ';
        }

        return $permissionsString;
    }

    public static function permissionAll()
    {
        $permissionsString = [
            'permissions' => '',
            'descriptions' => ''
        ];

        $permissions = self::permissions();

        foreach ($permissions as $per) {
            $permissionsString['permissions'] = $permissionsString['permissions'] . $per['permission'] . ' ';
            $permissionsString['descriptions'] = $permissionsString['descriptions'] . $per['description'] . ', ';
        }

        return $permissionsString;
    }
}
