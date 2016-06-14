<?php

namespace Teachat\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    /**
     * Get user role.
     *
     * @param integer $role_id
     * @return string
     */
    protected function getUserRole($role_id)
    {
        switch ($role_id) {
            case 1:
                return 'admin';
                break;
            case 2:
                return 'teacher';
                break;
            case 3:
                return 'parent';
                break;
            default:
                return 'school-admin';
                break;
        }
    }
}
