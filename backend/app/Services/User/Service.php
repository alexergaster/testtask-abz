<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Tinify\Tinify;

class Service
{
    public function getUserPagination(int $page, int $count): array
    {
        $validator = Validator::make(
            ['page' => $page, 'count' => $count],
            [
                'page' => 'integer|min:1',
                'count' => 'integer|min:1',
            ]
        );

        if ($validator->fails()) {
            return [
                [
                    "success" => false,
                    "message" => "Validation failed",
                    "fails" => $validator->errors(),
                ],

                "status" => 422
            ];
        }

        $query = User::with('position');
        $totalUsers = $query->count();

        $users = $query->skip(($page - 1) * $count)
            ->take($count)
            ->get();

        if ($users->isEmpty()) {
            return ['success' => false, 'message' => 'Page not found', 'status' => 404];
        }

        $formattedUsers = $users->map(fn($user) => $this->userSchema($user));
        return [
            'success' => true,
            'page' => $page,
            'total_pages' => ceil($totalUsers / $count),
            'total_users' => $totalUsers,
            'count' => $formattedUsers->count(),
            'links' => [
                'next_url' => $page * $count < $totalUsers ? Request::url() . "?page=" . ($page + 1) . "&count=$count" : null,
                'prev_url' => $page > 1 ? Request::url() . "?page=" . ($page - 1) . "&count=$count" : null,
            ],
            'users' => $formattedUsers,
            'status' => 200
        ];
    }

    public function getUserById($id): array
    {
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            return [
                "success" => false,
                "message" => "The user with the requestedid does not exist",
                "fails" => [
                    "userId" => [
                        "The user must be an integer."
                    ]
                ],
                'status' => 404
            ];
        }

        $user = User::find($id);

        if (empty($user)) {
            return [
                'success' => false,
                'message' => 'User not found',
                'status' => 404
            ];
        }

        $formattedUser = $this->userSchema($user);

        return [
            'success' => true,
            'user' => $formattedUser,
            'status' => 200
        ];
    }

    public function store($data, $token): array
    {
        if (empty($token)) {
            return ['success' => false, 'message' => 'API key is missing', 'status' => 404];
        }

        $registrationToken = DB::table('registration_tokens')
            ->where('token', $token)
            ->where('expires_at', '>', now())
            ->where('used', false)
            ->first();

        if (!$registrationToken) {
            return ['success' => false, 'error' => 'Invalid or expired token', 'status' => 400];
        }

        DB::table('registration_tokens')->where('token', $token)->update(['used' => true]);

        $image = $data['image'];

        $imagePath = $image->store('images/users', 'public');

        $imageNewPath = $this->optimizeImage($imagePath);
        $data['image'] = $imageNewPath;

        User::create($data);

        return ['success' => true, 'message' => 'User created successfully', 'status' => 201];
    }

    private function optimizeImage($path): string
    {
        Tinify::setKey(config('services.tinypng.api_key'));
        $fullPath = storage_path('app/public/' . $path);

        $source = Tinify::fromFile($fullPath);

        $resized = $source->resize(array(
            "method" => "cover",
            "width" => 70,
            "height" => 70
        ));
        $pathInfo = pathinfo($fullPath);

        if($pathInfo['extension'] !== 'jpg'){
            $converted = $resized->convert(array("type" => "image/jpg"));

            $converted->toFile($pathInfo ['dirname'] . '/' . $pathInfo['filename'] . '.jpg');
        }

        unlink($fullPath);
        return 'images/' . $pathInfo['filename'] . '.jpg';
    }

    private function userSchema($user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'image' => $user->image,
            'registration_timestamp' => strtotime($user->registration_timestamp),
            'position_id' => $user->position_id,
            'position' => $user->position->position
        ];
    }
}

