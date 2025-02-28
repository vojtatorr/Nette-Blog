<?php
namespace App\Presentation\Sign;

use Nette;
use Nette\Application\UI\Presenter;
use Nette\Application\UI\Form;
use App\Components\User\Sign\In\FormFactory;

final class SignPresenter extends Nette\Application\UI\Presenter
{
	private FormFactory $userSignInFormFactory;

	private string $storeRequestId = "";

	public function actionIn(string $storeRequestId = "")
	{
		$this->storeRequestId = $storeRequestId;
	}


	public function actionOut(){
		$this->user->logout();
		$this->flashMessage('Odhlšení proběhlo úspěšně.', 'success');
		$this->redirect('Home:');
	}

	protected function createComponentSignInForm(): Form
	{
		$form = $this->userSignInFormFactory->create();

		$form->onSuccess[] = [$this, "onSignInFormSuccess"];

		return $form;
	}

	public function onSignInFormSuccess(): void
	{
		$this->flashMessage("Úspěšně přihlášeno.", "success");
		$this->restoreRequest($this->storeRequestId);
		$this->redirect("Home:");
	}

}