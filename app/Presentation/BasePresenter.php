<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Components\User\Sign\In\ControlFactory;
use Nette\Application\UI\Control;
use Nette\Application\UI\Presenter;

abstract class BasePresenter extends \Nette\Application\UI\Presenter
{
    private ControlFactory $userSignInControlFactory;

    public function createComponentSignInForm(): Control
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