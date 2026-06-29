<?php

namespace App\Http\Controllers\Auth;

use App\Enums\AccessStatus;
use App\Enums\CompanyStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\AdminCompanyRegisteredNotification;
use App\Notifications\CompanyRegisteredNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

/**
 * Registra ciudadanos y empresas desde el portal público.
 *
 * El controlador crea el usuario base y después inicializa el perfil mínimo
 * según el tipo seleccionado en el formulario.
 */
class RegisteredUserController extends Controller
{
    /**
     * Muestra el formulario de registro para ciudadano o empresa.
     */
    public function create(string $type = 'citizen')
    {
        abort_unless(in_array($type, ['citizen', 'company'], true), 404);
        return view('auth.register', compact('type'));
    }

    /**
     * Valida datos, crea usuario y dispara verificación de correo.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => ['required', 'in:citizen,company'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'business_name' => ['required_if:type,company', 'nullable', 'string', 'max:255'],
            'rfc' => ['nullable', 'string', 'max:13'],
        ]);

        $role = $data['type'] === 'company' ? UserRole::Company : UserRole::Citizen;
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
            'role' => $role,
            'status' => AccessStatus::Active,
            'access_expires_at' => now()->addYear(),
        ]);

        if ($role === UserRole::Company) {
            $company = $user->company()->create([
                'business_name' => $data['business_name'],
                'rfc' => $data['rfc'] ?? null,
                'primary_email' => $data['email'],
                'primary_phone' => $data['phone'] ?? null,
                'status' => CompanyStatus::Pending,
            ]);

            $user->notify(new CompanyRegisteredNotification());
            User::where('role', UserRole::Admin->value)->get()
                ->each(fn (User $admin) => $admin->notify(new AdminCompanyRegisteredNotification($company)));
        } else {
            $user->citizenProfile()->create(['full_name' => $data['name'], 'phone' => $data['phone'] ?? null]);
        }

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('verification.notice');
    }
}
