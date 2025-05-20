<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Passwords\CreatePassword;
use App\Actions\Passwords\DeletePassword;
use App\Actions\Passwords\UpdatePassword;
use App\Http\Requests\StorePasswordRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\Password;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use Inertia\Inertia;
use Inertia\Response;

class PasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Dashboard', [
            'passwords' => Password::with('user')->get()->map(fn ($password) => [
                'id' => $password->id,
                'url' => $password->url,
                'password' => Crypt::decryptString($password->password),
                'username' => $password->username,
                'created_at' => $password->created_at,
                'updated_at' => $password->updated_at,
            ]),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePasswordRequest $request, CreatePassword $action): RedirectResponse
    {
        $action->handle($request->validated(), $request->user());

        return to_route('dashboard');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Password $password): Response
    {
        return Inertia::render('Passwords/Edit', [
            'password' => Crypt::decryptString($password->password),
            'username' => $password->username,
            'url' => $password->url,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePasswordRequest $request, Password $password, UpdatePassword $action): RedirectResponse
    {
        $action->handle($password, $request->validated());

        return to_route('passwords.edit', $password);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Password $password, DeletePassword $action): RedirectResponse
    {
        $action->handle($password);

        return to_route('dashboard');
    }
}
