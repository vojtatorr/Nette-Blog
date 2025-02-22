<?php
namespace App\Presentation\Sign;

use Nette;
use Nette\Application\UI\Presenter;
use Nette\Application\UI\Form;

final class SignPresenter extends Nette\Application\UI\Presenter
{
	public function actionOut(){
		$this->user->logout();
		$this->flashMessage('Odhlšení proběhlo úspěšně.', 'success');
		$this->redirect('Home:');
	}

	protected function createComponentSignInForm(): Form
	{
		$form = new Form;
		$form->addText('username', 'Uživatelské jméno:')
			->setRequired('Prosím vyplňte své uživatelské jméno.');

		$form->addPassword('password', 'Heslo:')
			->setRequired('Prosím vyplňte své heslo.');

		$form->addSubmit('send', 'Přihlásit');

		$form->onSuccess[] = [$this, 'signInFormSucceeded'];
		return $form;
	}

	public function signInFormSucceeded(Form $form, \stdClass $values): void
{
	try {
		$this->user->login($values->username, $values->password);
		$this->flashMessage("Úspěšné příhlášeno.", "success");
		$this->redirect('Home:');

	} catch (Nette\Security\AuthenticationException $e) {
		$form->addError('Nesprávné přihlašovací jméno nebo heslo.');
	}
}
}