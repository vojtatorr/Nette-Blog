<?php
namespace App\Presentation\Sign;

use Nette;
use App\Components\User\Sign\In\Control as MyControl;
use App\Components\User\Sign\In\ControlFactory;
use Nette\Application\UI\Control;
use Nette\Application\UI\Presenter;

class SignPresenter extends Nette\Application\UI\Presenter
{
	private ControlFactory $userSignInControlFactory;

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

	protected function createComponentSignInForm(): Control
	{
		return $this->userSignInControlFactory->create([$this, "onSignInFormSuccess"]);
	}

	public function onSignInFormSuccess(): void
	{
		$this->flashMessage("Úspěšně přihlášeno.", "success");
		$this->restoreRequest($this->storeRequestId);
		$this->redirect("Home:");
	}

}