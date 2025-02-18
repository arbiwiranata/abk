<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as AuthLogin;

class Login extends AuthLogin
{
    // protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.login';

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getEmailFormComponent()
                            ->label(false)
                            ->markAsRequired(false)
                            ->placeholder('Username')
                            ->extraAttributes([
                                'class' => 'input-1',
                            ]),
                        $this->getPasswordFormComponent()
                            ->label(false)
                            ->markAsRequired(false)
                            ->placeholder('Password')
                            ->revealable(false)
                            ->extraAttributes([
                                'class' => 'input-1',
                            ]),
                        // $this->getRememberFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    public function getHeading(): string
    {
        return 'Login';
    }
}
