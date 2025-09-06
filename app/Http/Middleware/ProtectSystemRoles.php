<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Role;

class ProtectSystemRoles
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $routeParameters = $request->route()->parameters();
        $role = null;

        foreach ($routeParameters as $param) {
            if ($param instanceof Role) {
                $role = $param;
                break;
            } elseif (is_numeric($param)) {
                $role = Role::query()->find($param);
                if ($role) {
                    break;
                }
            }
        }

        if ($role && $role->protected) {
            if ($request->isMethod('DELETE') ||
                ($request->isMethod('POST') && $request->has('_method') && $request->input('_method') === 'DELETE')) {
                return response()->json([
                    'success' => false,
                    'message' => $role->name . __(' role is required our system. You can not delete it.')
                ], 403);
            }

            if (($request->isMethod('PUT') || $request->isMethod('PATCH') ||
                    ($request->isMethod('POST') && $request->has('_method') &&
                        in_array($request->input('_method'), ['PUT', 'PATCH']))) &&
                $request->has('name') && $request->input('name') !== $role->name) {
                return response()->json([
                    'success' => false,
                    'message' => $role->name . __(' role is required our system. You can not rename it.')
                ], 403);
            }
        }

        return $next($request);
    }
}
