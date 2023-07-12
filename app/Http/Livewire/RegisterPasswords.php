<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use ZxcvbnPhp\Zxcvbn;

class RegisterPasswords extends Component
{
    public string $password = '';
    public string $confirmPassword = '';
    public int $strengthScore = 0;
    public array $strengthLevels = [
        1 => 'weak',
        2 => 'Fair',
        3 => 'Good',
        4 => 'Strong'
    ];

    public function generatePassword(): void
    {
        $lowercase = range('a', 'z');
        $uppercase = range('A', 'Z');
        $numbers = range(0, 9);
        $specialChars = ['!', '@', '#', '$', '%', '^', '*'];
        $passwordChars = array_merge($lowercase, $uppercase, $numbers, $specialChars);
        $length = 12;
        do {
            $password = [];
            for ($i = 0; $i < $length; $i++) {
                $int = rand(0, count($passwordChars) - 1);
                $password[] = $passwordChars[$int];
            }
        } while (empty(array_intersect($specialChars, $password)));
        $this->setPasswords(implode('', $password));
    }

    public function updatePassword($value): void
    {
        $this->strengthScore = (new Zxcvbn())->passwordStrength($value)['score'];
    }

    protected function setPasswords($value): void
    {
        $this->password = $value;
        $this->confirmPassword = $value;
        $this->updatePassword($value);
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.register-passwords');
    }
}
