<?php

declare(strict_types=1);

namespace App\Components\User\Sign\In;

use Exception;
use Nette\Application\UI\Form;
use Nette\Security\User;
use stdClass;

class FormFactory
{
    public function __construct(
        private User $user,
    ) { }

    public function create(): Form
    {
        $form = new Form;

		$form->addEmail('email', 'Váš E-mail:')
			->setRequired('Prosím vyplňte svůj E-mail.');

		$form->addPassword('password', 'Heslo:')
			->setRequired('Prosím vyplňte své heslo.');

		$form->addSubmit('send', 'Přihlásit');

		$form->onSuccess[] = [$this, 'signInFormSucceeded'];

		return $form;
    }

    public function signInFormSucceeded(Form $form, stdClass $values): void
    {
        try {
            $this->user->login($values->username, $values->password);
            $this->flashMessage("Úspěšné příhlášeno.", "success");
            $this->restoreRequest($this->storeRequestId);
            $this->redirect('Home:');

        } catch (Exception $e) {
            $form->addError('Nesprávné přihlašovací jméno nebo heslo.');
        }
    }

}