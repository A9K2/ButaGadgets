<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminUserController extends Controller
{
    // Список усіх користувачів
    public function index()
    {
        // Пагінація по 15 користувачів на сторінку
        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    // Форма редагування користувача (наприклад, зміна ролі)
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // Оновлення даних користувача в БД
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'role'     => 'required|in:user,admin', // Дозволяємо лише ролі з вашої міграції
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'Дані користувача успішно оновлено!');
    }

    // Видалення користувача
    public function destroy(User $user)
    {
        // Захисний механізм: адмін не може видалити сам себе
        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'Ви не можете видалити свій власний акаунт!');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Користувача успішно видалено з системи.');
    }
}
