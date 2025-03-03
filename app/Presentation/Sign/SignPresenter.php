<?php

namespace App\Presentation\Sign;

use App\Components;

class SignPresenter extends BaseManager
{
	use Components\User\Sign\In\PresenterTrait;

	public function actionIn(string $storeRequestId = "")
	{
		$this->storeRequestId = $storeRequestId;
	}

	public function actionOut(){
		$this->user->logout(true);
		$this->flashMessage('Odhlšení proběhlo úspěšně.', 'success');
		$this->redirect('Home:');
	}
}