<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route as RouteFacade;
use Illuminate\Routing\Route;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Retrieve all registered routes
        $routes = RouteFacade::getRoutes();

        // Array to store permissions
        $permissions = [];

        // Iterate over each route
        foreach ($routes as $route) {
            // Ensure $route is of type Route
            if ($route instanceof Route) {
                // Check if the route is protected by 'permission_protected' and 'auth' middleware,
                // and if its name starts with 'admin.'
                if (
                    in_array('permission_protected', $route->middleware())
                    && in_array('auth', $route->middleware())
                    && str_starts_with($route->getName(), 'admin.')
                ) {
                    // Extract permission name and add to permissions array
                    $routeName = $route->getName();
                    Permission::firstOrCreate([
                        'guard_name' => 'web',
                        'name' => $routeName,
                    ], [
                        'display_name' => $this->getPermissionDisplayName($routeName),
                        'created_at' => now()->toDateTimeString()
                    ]);
                    $permissions[] = $routeName;
                }
            }
        }

        // Remove permissions that are no longer needed
        Permission::whereNotIn('name', $permissions)->delete();
    }

    /**
     * @param $routeName
     * @return string
     */
    function getPermissionDisplayName($routeName): string
    {
        $displayName = str_replace('.', ' ', preg_replace('/^admin./', '', $routeName));
        $words = str_word_count($displayName, 1); // Split the string into an array of words
        $reversedWords = array_reverse($words); // Reverse the order of the words
        return ucfirst(implode(' ', $reversedWords));
    }
}
