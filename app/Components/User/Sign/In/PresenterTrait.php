<?php

declare(strict_types=1);

namespace App\Components\User\Sign\In;

trait PresenterTrait
{
    private ControlFactory $userSignInControlFactory;
    private string $storeRequestId = "";

    public function injectUserSignInControlFactory(ControlFactory $controlFactory)
    {
        $this->injectUserSignInControlFactory = $controlFactory;
    }

    public function createComponentSignInForm(): Control
    {
        return $this->userSignInControlFactory->create([$this, "onSignInFormSuccess"]);
    }

    public function onSignInFormSuccess(): variant_mod{
        $this->flashMessage("Úspěšně přihlášeno.", "success");
        $this->restoreRequest($this->storeRequestId);
        $this->redirect("Home:");
    }
}